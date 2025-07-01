import base64
import requests
import time
import sys
import json
from tqdm import tqdm
from openai import OpenAI
from putinjail import procesar_output_chatgpt
from concurrent.futures import ThreadPoolExecutor, as_completed
import os
from dotenv import load_dotenv

load_dotenv()
URL_TOKEN=os.getenv("OPENAI_API_KEY")


def imagen_a_base64(url_imagen):
    respuesta = requests.get(url_imagen)
    if respuesta.status_code == 200:
        base64_str = base64.b64encode(respuesta.content).decode('utf-8')
        return f"data:image/webp;base64,{base64_str}"
    else:
        raise Exception(f"No se pudo descargar la imagen: {url_imagen}")


# Crear cliente OpenAI (agrega tu clave real aquí)
client = OpenAI(api_key=URL_TOKEN)  # ← Reemplaza con tu clave real


def generar_prompt(titulo, frase_objetivo, palabras_clave, link_sitio, link_contacto):
    prompt = f'''Desarrolla el contenido del artículo "{titulo}" con 5 subtítulos principales, que contengan la palabra clave: {palabras_clave}. y un parrafo inicial antes de los subtitulos . Optimiza el texto HTML para SEO incluyendo en el título el tag <h1>, y en los subtítulos incluye el tag <h2>, en los parrafos el tag <p>. Incluye dentro de cada párrafo la referencia al sitio web con el link {link_sitio} y a la página de contáctanos a {link_contacto}. Repite varias veces la palabra clave para optimización del SEO. Escribe el texto evitando penalización de Google por generarse por IA. La frase objetivo "{frase_objetivo}" debe estar en el primer párrafo siempre. La frase clave debe repetirse al menos 3 veces en todo el texto. En los subtítulos deben aparecer sinónimos de las frases objetivo o la frase clave completa. Al final, en otro párrafo, dame la frase clave: {frase_objetivo}  en el formato Frase Clave: {frase_objetivo.lower().replace(' ', '-')} pero con el tag <p> sin <strong>. También incluye al final la etiqueta de la meta descripción.'''
    return prompt


def pedir_datos():
    if len(sys.argv) > 1:
        ruta_json = sys.argv[1]
        try:
            with open(ruta_json, 'r', encoding='utf-8') as f:
                lista_datos = json.load(f)

            if not isinstance(lista_datos, list):
                raise ValueError("⚠️ El archivo JSON debe contener una lista de objetos.")

            prompts = []
            for i, datos in enumerate(lista_datos):
                titulo = datos.get("titulo", "").strip()
                frase_objetivo = datos.get("frase_objetivo", "").strip()
                palabras_clave = datos.get("palabras_clave", "").strip()
                link_sitio = datos.get("link_sitio", "").strip()
                link_contacto = datos.get("link_contacto", "").strip()
                imagenes = datos.get("imagenes", [])
                imagen_alt = datos.get("imagen_alt", [])

                if not all([titulo, frase_objetivo, palabras_clave, link_sitio, link_contacto]):
                    raise ValueError(f"❌ Faltan campos obligatorios en el post #{i + 1}")
                if not isinstance(imagenes, list) or not isinstance(imagen_alt, list):
                    raise ValueError(f"❌ 'imagenes' o 'imagen_alt' deben ser listas en el post #{i + 1}")
                if len(imagenes) != len(imagen_alt):
                    raise ValueError(f"❌ La cantidad de imágenes y textos alt no coincide en el post #{i + 1}")
                imagenes_base64 = []
                for url in imagenes:
                    img_base64 = imagen_a_base64(url)
                    if img_base64:
                        imagenes_base64.append(img_base64)

                prompts.append({
                    "titulo": titulo,
                    "prompt": generar_prompt(titulo, frase_objetivo, palabras_clave, link_sitio, link_contacto),
                    "imagenes": imagenes_base64,
                    "imagen_alt": imagen_alt
                })

                


            return prompts

        except Exception as e:
            print(f"❌ Error leyendo JSON: {e}")
            sys.exit(1)

    else:
        # Input manual (solo 1 post)
        print("📝 Generador de Artículo SEO HTML con ChatGPT\n")
        titulo = input("📌 Título del artículo: ").strip()
        frase_objetivo = input("🎯 Frase objetivo: ").strip()
        palabras_clave = input("🔑 Palabras clave (coma separadas): ").strip()
        link_sitio = input("🌐 Link del sitio web: ").strip()
        link_contacto = input("📨 Link de contacto: ").strip()

        # Manualmente pedir imágenes y alt si quisieras hacerlo en consola
        imagenes = []
        imagen_alt = []
        print("➕ No se incluyeron imágenes desde JSON. Puedes agregarlas manualmente más adelante si lo deseas.")

        return [{
            "titulo": titulo,
            "prompt": generar_prompt(titulo, frase_objetivo, palabras_clave, link_sitio, link_contacto),
            "imagenes": imagenes,
            "imagen_alt": imagen_alt
        }]

def mostrar_barra_carga(segundos=8):
    for _ in tqdm(range(segundos), desc="⌛ Generando artículo..."):
        time.sleep(1)


def solicitar_articulo(prompt):
    while True:
        try:
            mostrar_barra_carga()
            respuesta = client.chat.completions.create(
                model="gpt-3.5-turbo",
                messages=[{"role": "user", "content": prompt}],
                temperature=0.4,
            )
            return respuesta.choices[0].message.content.strip()

        except Exception as e:
            error_str = str(e).lower()
            print(f"\nError: {e}")
            if "rate limit" in error_str or "429" in error_str:
                print("⏳ Límite de uso alcanzado. Esperando 25 segundos...")
                time.sleep(25)
            else:
                print("⚠️ Error inesperado. Reintentando en 10 segundos...")
                time.sleep(10)


# if __name__ == "__main__":
#     prompts = pedir_datos()
#     for i, item in enumerate(prompts):
#         print(f"\n📡 Generando artículo {i+1}: {item['titulo']}\n")
#         respuesta = solicitar_articulo(item["prompt"])
#         print(f"\n✅ Artículo {i+1} generado:\n")
#         print(respuesta)
#         procesar_output_chatgpt(respuesta)
#         print(f"\n✅ Articulo procesado {i+1} generado:\n")



def generar_articulos_concurrente(prompts):
    resultados = []

    with ThreadPoolExecutor(max_workers=5) as executor:
        futuras = {
            executor.submit(solicitar_articulo, item["prompt"]): i for i, item in enumerate(prompts)
        }

        for futura in as_completed(futuras):
            i = futuras[futura]
            item = prompts[i]
            try:
                respuesta = futura.result()
                resultados.append((i, item, respuesta))
            except Exception as e:
                print(f"❌ Error al generar artículo {i+1}: {e}")
    
    resultados.sort(key=lambda x: x[0])  # Mantener el orden original

    for i, item, respuesta in resultados:
        print(f"\n✅ Artículo {i+1} generado: {item['titulo']}\n")
        print(respuesta)
        procesar_output_chatgpt(respuesta, item['imagenes'], item['imagen_alt'])
        print(f"✅ Artículo procesado {i+1}\n")

# ------------------------
# MAIN
# ------------------------
def main():
    prompts = pedir_datos()
    generar_articulos_concurrente(prompts)

if __name__ == "__main__":
    main()