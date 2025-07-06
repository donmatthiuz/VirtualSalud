from xml.etree.ElementTree import Element, SubElement, tostring
from xml.dom import minidom
from datetime import datetime
import os
from dotenv import load_dotenv


load_dotenv()
BASE_URL = os.getenv("BASE_URL")

def generar_sitemap_url(loc, changefreq="weekly", priority="0.8", lastmod=None):
    url = Element("url")
    SubElement(url, "loc").text = loc
    if lastmod:
        SubElement(url, "lastmod").text = lastmod
    SubElement(url, "changefreq").text = changefreq
    SubElement(url, "priority").text = priority
    return url


def guardar_sitemap(nombre_archivo, urls):
    urlset = Element("urlset", xmlns="http://www.sitemaps.org/schemas/sitemap/0.9")
    for url in urls:
        urlset.append(url)
    xml_str = minidom.parseString(tostring(urlset)).toprettyxml(indent="  ")
    with open(nombre_archivo, "w", encoding="utf-8") as f:
        f.write(xml_str)


def generar_post_sitemap():
    urls = []
    exclude_dirs = {"inc"}

    ruta_blogs = "./blogs"
    for root, dirs, files in os.walk(ruta_blogs):
        dirs[:] = [d for d in dirs if d not in exclude_dirs]
        for file in files:
            if file.endswith(".php") and not file.startswith("_"):
                rel_path = os.path.relpath(os.path.join(root, file), ".")
                url = BASE_URL + rel_path.replace("\\", "/").replace(".php", "")
                lastmod = datetime.utcfromtimestamp(os.path.getmtime(os.path.join(root, file))).strftime("%Y-%m-%d")
                urls.append(generar_sitemap_url(url, lastmod=lastmod))

    guardar_sitemap("post-sitemap.xml", urls)
    print("📄 post-sitemap.xml generado con", len(urls), "entradas")


def generar_page_sitemap():
    urls = []
    exclude_dirs = {"blogs", "vendor", "__pycache__", "output", ".git", ".venv", "phphtml", "PHPMailer", "PMIAL", "inc"}
    exclude_files = {"generate_sitemap.py", "config.php", "consultation.php", "security-functions.php", "generate_csrf.php"}  # si aplica

    for root, dirs, files in os.walk("."):
        # Omitir carpetas no deseadas
        dirs[:] = [d for d in dirs if d not in exclude_dirs]

        for file in files:
            if file.endswith(".php") and file not in exclude_files and not file.startswith("_"):
                full_path = os.path.join(root, file)
                rel_path = os.path.relpath(full_path, ".").replace("\\", "/")
                url = BASE_URL + rel_path.replace(".php", "")
                lastmod = datetime.utcfromtimestamp(os.path.getmtime(full_path)).strftime("%Y-%m-%d")
                urls.append(generar_sitemap_url(url, lastmod=lastmod))

    guardar_sitemap("page-sitemap.xml", urls)
    print("📄 page-sitemap.xml generado con", len(urls), "entradas")


def generar_sitemap_index():
    index = Element("sitemapindex", xmlns="http://www.sitemaps.org/schemas/sitemap/0.9")
    hoy = datetime.utcnow().strftime("%Y-%m-%d")

    for nombre in ["page-sitemap.xml", "post-sitemap.xml"]:
        sitemap = SubElement(index, "sitemap")
        SubElement(sitemap, "loc").text = BASE_URL + nombre
        SubElement(sitemap, "lastmod").text = hoy

    xml_str = minidom.parseString(tostring(index)).toprettyxml(indent="  ")
    with open("sitemap_index.xml", "w", encoding="utf-8") as f:
        f.write(xml_str)

    print("🗂️ sitemap_index.xml generado con referencias a los 2 sitemaps")


def generar_todos_los_sitemaps():
    generar_page_sitemap()
    generar_post_sitemap()
    generar_sitemap_index()


if __name__ == "__main__":
    generar_todos_los_sitemaps()

