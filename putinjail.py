import re
import os
from datetime import datetime


def extraer_datos_articulo(contenido_generado):
    """Extrae título, párrafo introductorio, subtítulos, contenido, slug y meta descripción del output de ChatGPT"""
    
    # Extraer título H1
    titulo_match = re.search(r'<h1>(.*?)</h1>', contenido_generado)
    titulo = titulo_match.group(1) if titulo_match else "Título por defecto"
    
    # Extraer párrafo introductorio (el primer <p> después del H1)
    intro_match = re.search(r'<h1>.*?</h1>\s*<p>(.*?)</p>', contenido_generado, re.DOTALL)
    intro = intro_match.group(1) if intro_match else "Introducción por defecto"
    
    # Extraer subtítulos H2 y sus contenidos
    secciones = []
    patron_h2 = r'<h2>(.*?)</h2>\s*<p>(.*?)</p>'
    matches = re.findall(patron_h2, contenido_generado, re.DOTALL)
    
    for subtitulo, contenido in matches:
        contenido_limpio = contenido.strip()
        secciones.append({
            'subtitulo': subtitulo.strip(),
            'contenido': contenido_limpio
        })
    
    # Extraer slug (buscar "Frase Clave: slug-ejemplo" en un párrafo)
    slug_match = re.search(r'<p>\s*Frase\s+Clave:\s*([\w-]+)\s*</p>', contenido_generado, re.IGNORECASE)
    slug = slug_match.group(1) if slug_match else "articulo-default"
    
    # Extraer meta descripción
    meta_match = re.search(r'<meta name="description" content="(.*?)">', contenido_generado)
    meta_descripcion = meta_match.group(1) if meta_match else "Descripción por defecto"
    
    return {
        'titulo': titulo,
        'intro': intro,
        'secciones': secciones,
        'slug': slug,
        'meta_descripcion': meta_descripcion
    }

def leer_plantilla_php():
    """Lee la plantilla PHP base desde archivo"""
    try:
        with open('blog-details.php', 'r', encoding='utf-8') as file:
            return file.read()
    except FileNotFoundError:
        print("❌ Error: No se encontró el archivo blog-details.php")
        return None

def generar_contenido_html(secciones, images, imagestl):
    """Genera el HTML de las secciones del blog"""
    html_content = ""
    
    for i, seccion in enumerate(secciones):
        # Alternar imágenes por sección
        imagenes = images
        
        imagen_alt = imagestl
        
        img_src = imagenes[i % len(imagenes)]
        img_alt_text = imagen_alt[i % len(imagen_alt)]
        
        html_content += f'''
					<div class="content-section">
						<h2>{seccion['subtitulo']}</h2>
						<img src="{img_src}" alt="{img_alt_text}" class="content-image">
						<p>
							{seccion['contenido']}
						</p>
					</div>
'''
    
    return html_content

def crear_archivo_php(datos_articulo, plantilla_php, images, imagestl ):
    """Crea el archivo PHP final con el contenido del artículo"""
    
    # Generar contenido HTML de las secciones
    contenido_secciones = generar_contenido_html(datos_articulo['secciones'], images, imagestl)
    
    # Obtener fecha actual
    fecha_actual = datetime.now().strftime('%M %d, %Y')
    
    # Reemplazos en la plantilla
    replacements = {
        # Meta descripción
        '<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">': 
        f'<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">\n\t\t<meta name="description" content="{datos_articulo["meta_descripcion"]}">',
        
        # Título de la página
        '<title>Blog Details - <?php echo $site_name; ?></title>': 
        f'<title>{datos_articulo["titulo"]} - <?php echo $site_name; ?></title>',
        
        # Título principal en el banner
        '''<h1 style="color: white;">Cuidado Profesional de Salud en el Hogar</h1>''': 
        f'''<h1 style="color: white;">{datos_articulo["titulo"]}</h1>''',
        
        # Intro del blog (usando el párrafo introductorio)
        '''<div class="blog-intro">
						En el panorama actual de la salud en Guatemala, el cuidado profesional en el hogar se ha convertido en una alternativa esencial y efectiva para brindar atención médica de calidad. Nuestros servicios especializados combinan la comodidad del hogar con la experiencia profesional, ofreciendo una solución integral que mejora significativamente la calidad de vida de nuestros pacientes y sus familias.
					</div>''': 
        f'''<div class="blog-intro">
						{datos_articulo['intro']}
					</div>''',
                    

        '''<div class="feature-banner section-spacing">
						<div class="opacity">
							<div class="container">
								<h2>Nuestras enfermeras pueden atender a tus seres queridos llegando a tu casa</h2>
								<a href="https://wa.me/50256867560" class="theme-button-one" >Escribenos al whatsapp</a>
							</div> <!-- /.container -->
						</div> <!-- /.opacity -->
					</div> ''': 
        f'''<div class="feature-banner section-spacing">
						<div class="opacity">
							<div class="container">
								<h2>Nuestras enfermeras pueden atender a tus seres queridos llegando a tu casa</h2>
								<a href="https://wa.me/50256867560" class="theme-button-one" >Escribenos al whatsapp</a>
							</div> <!-- /.container -->
						</div> <!-- /.opacity -->
					</div> ''',
        
        # Reemplazar todas las secciones de contenido
        '''<div class="content-section">
						<h2>Cuidadoras de Salud: Compañía y Apoyo Integral</h2>
						<img src="images/services/cuidadora-salud.jpg" alt="Cuidadora de Salud Profesional" class="content-image">
						<p>
							Nuestras cuidadoras de salud ofrecen un servicio personalizado que va más allá del cuidado básico. Estas profesionales capacitadas brindan compañía, asistencia en actividades diarias, administración de medicamentos bajo supervisión, y monitoreo constante del bienestar general del paciente. Su presencia reconfortante y su atención dedicada crean un ambiente seguro y cálido que promueve la recuperación y el bienestar emocional.
						</p>
					</div>

					<div class="content-section">
						<h2>Auxiliares de Enfermería: Cuidado Técnico Especializado</h2>
						<img src="images/services/auxiliar-enfermeria.jpg" alt="Auxiliar de Enfermería" class="content-image">
						<p>
							Los auxiliares de enfermería constituyen el pilar técnico de nuestros servicios de salud domiciliar. Con formación especializada en procedimientos médicos básicos, estos profesionales realizan curaciones, control de signos vitales, administración de medicamentos, fisioterapia básica y apoyo en la rehabilitación. Su expertise técnico combinado con un enfoque humano garantiza una atención médica de calidad en la comodidad del hogar.
						</p>
					</div>

					<div class="content-section">
						<h2>Enfermeras Profesionales: Excelencia en Atención Médica</h2>
						<img src="images/services/enfermera-profesional.jpg" alt="Enfermera Profesional" class="content-image">
						<p>
							Nuestras enfermeras profesionales representan el más alto nivel de atención médica domiciliar. Con licenciatura en enfermería y experiencia clínica comprobada, estas especialistas están capacitadas para manejar casos complejos, administrar tratamientos avanzados, coordinar con médicos tratantes, y proporcionar educación sanitaria a pacientes y familias. Su liderazgo profesional asegura estándares de calidad equiparables a los de instituciones hospitalarias.
						</p>
					</div>

					<div class="content-section">
						<h2>Ventajas del Cuidado de Salud en el Hogar</h2>
						<img src="images/services/cuidado-hogar.jpg" alt="Beneficios del Cuidado en Casa" class="content-image">
						<p>
							El cuidado de salud en el hogar ofrece múltiples beneficios que impactan positivamente en la recuperación y calidad de vida. Entre las principales ventajas se encuentran: la reducción del riesgo de infecciones hospitalarias, el mantenimiento del entorno familiar que acelera la recuperación emocional, la atención personalizada uno a uno, la flexibilidad en horarios y tratamientos, y la significativa reducción de costos comparado con hospitalizaciones prolongadas. Además, permite que las familias mantengan su rutina diaria mientras aseguran el mejor cuidado para sus seres queridos.
						</p>
					</div>''': contenido_secciones
    }
    
    # Aplicar reemplazos
    nuevo_php = plantilla_php
    for buscar, reemplazar in replacements.items():
        nuevo_php = nuevo_php.replace(buscar, reemplazar)
    
    # Crear nombre de archivo
    nombre_archivo = os.path.join('blogs', f"{datos_articulo['slug']}.php")
    
    # Guardar archivo
    try:
        with open(nombre_archivo, 'w', encoding='utf-8') as file:
            file.write(nuevo_php)
        print(f"✅ Archivo creado exitosamente: {nombre_archivo}")
        return nombre_archivo
    except Exception as e:
        print(f"❌ Error al crear archivo: {e}")
        return None

def procesar_output_chatgpt(contenido_chatgpt,  images, imagestl ):
    """Función principal que procesa el output de ChatGPT y genera el archivo PHP"""
    
    print("🔄 Procesando contenido de ChatGPT...")
    
    # Extraer datos del artículo
    datos_articulo = extraer_datos_articulo(contenido_chatgpt)
    
    print(f"📌 Título extraído: {datos_articulo['titulo']}")
    print(f"📝 Intro extraída: {datos_articulo['intro'][:100]}...")
    print(f"📂 Slug: {datos_articulo['slug']}")
    print(f"📋 Secciones encontradas: {len(datos_articulo['secciones'])}")
    
    # Leer plantilla PHP
    plantilla_php = leer_plantilla_php()
    if not plantilla_php:
        return None
    
    # Crear archivo PHP
    nombre_archivo = crear_archivo_php(datos_articulo, plantilla_php,  images, imagestl )
    
    if nombre_archivo:
        print(f"🎉 ¡Blog generado exitosamente!")
        print(f"📁 Archivo: {nombre_archivo}")
        print(f"🌐 URL sugerida: /{datos_articulo['slug']}")
    
    return nombre_archivo

# Ejemplo de uso
# if __name__ == "__main__":
#     # Output de ejemplo de ChatGPT con el nuevo formato corregido
#     output_chatgpt = '''<h1>Enfermera en casa: cuidados profesionales en la comodidad de tu hogar</h1>

# <p>Si estás buscando una <a href="https://homecare.global">enfermera en casa</a> para brindar cuidados profesionales a un ser querido en la comodidad de tu hogar, has llegado al lugar indicado. En <a href="https://homecare.global/contactanos">Homecare Global</a> contamos con un equipo de enfermeras altamente capacitadas y comprometidas con el bienestar de nuestros pacientes.</p>   

# <h2>Atención personalizada de una enfermera en casa</h2>
# <p>Nuestras enfermeras en casa ofrecen una atención personalizada y especializada, adaptada a las necesidades de cada paciente. Realizan curas, administran medicamentos, controlan signos vitales y brindan apoyo emocional, garantizando un cuidado integral y de calidad. En <a href="https://homecare.global">Homecare Global</a> nos preocupamos por la salud y el bienestar de nuestros pacientes, por eso contamos con un equipo de enfermeras altamente calificadas.</p>

# <h2>Servicios de enfermería a domicilio</h2>
# <p>Contar con una <a href="https://homecare.global">enfermera en casa</a> brinda una serie de ventajas, como la comodidad de recibir cuidados en el hogar, la atención personalizada y la tranquilidad de saber que un profesional de la salud está velando por el bienestar del paciente. En <a href="https://homecare.global/contactanos">Homecare Global</a> ofrecemos servicios de enfermería a domicilio de calidad, con un enfoque humano y cálido.</p>

# <h2>Beneficios de contratar una enfermera en casa</h2>
# <p>Los beneficios de contratar una enfermera en casa son múltiples, ya que se garantiza una atención personalizada, profesional y de calidad en el entorno familiar del paciente. En <a href="https://homecare.global">Homecare Global</a> nos esforzamos por brindar un servicio de enfermería 
# a domicilio que cumpla con los más altos estándares de calidad y excelencia.</p>

# <h2>Equipo de enfermeras en casa altamente capacitadas</h2>
# <p>Nuestro equipo de enfermeras en casa está conformado por profesionales altamente capacitadas, con experiencia en el cuidado de pacientes en el hogar. En <a href="https://homecare.global/contactanos">Homecare Global</a> nos comprometemos a brindar un servicio de enfermería a domicilio 
# que garantice la seguridad, comodidad y bienestar de nuestros pacientes en todo momento.</p>    

# <p>Frase Clave: como-ayuda-una-enfermera-en-casa</p>

# <meta name="description" content="Enfermera en casa: encuentra cuidados profesionales y personalizados en la comodidad de tu hogar con Homecare Global. Contáctanos para más información."> '''
    
#     # Procesar el contenido
#     procesar_output_chatgpt(output_chatgpt)
    
#     print("\n" + "="*50)
#     print("💡 Para usar este script:")
#     print("1. Asegúrate de tener el archivo 'blog-details.php' en la misma carpeta")
#     print("2. Ejecuta: procesar_output_chatgpt(tu_contenido_de_chatgpt)")
#     print("3. El archivo PHP se generará automáticamente")
#     print("4. Ahora busca correctamente el formato: <p>Frase Clave: tu-slug-aqui</p>")

