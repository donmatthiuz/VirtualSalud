<?php
$baseUrl = "http://localhost/homecare/"; // Cambia a https://homecare.global/ en producción
$pages = [];
$allowed_ext = ['php'];
$exclude_files = ['generate_sitemap.php', 'config.php'];
$exclude_dirs = ['vendor', 'PMIAL', 'PHPMailer', 'phphtml']; // Ignoradas

$dir = new RecursiveDirectoryIterator(".");
$iterator = new RecursiveIteratorIterator($dir);

// 1. Escanear archivos PHP
foreach ($iterator as $file) {
    if ($file->isFile()) {
        $ext = pathinfo($file->getFilename(), PATHINFO_EXTENSION);
        $name = $file->getFilename();

        if (in_array($ext, $allowed_ext) && !in_array($name, $exclude_files) && strpos($name, '_') !== 0) {
            $relativePath = str_replace("\\", "/", $file->getPathname()); // Windows fix
            $cleanPath = ltrim($relativePath, "./");

            // Ignorar carpetas específicas
            $skip = false;
            foreach ($exclude_dirs as $dirName) {
                if (str_contains($cleanPath, "$dirName/")) {
                    $skip = true;
                    break;
                }
            }

            if (!$skip) {
                $pages[] = $baseUrl . $cleanPath;
            }
        }
    }
}

// 2. Incluir rutas de blogs.json si existe
$jsonPath = './blogs.json';
if (file_exists($jsonPath)) {
    $json = file_get_contents($jsonPath);
    $blogData = json_decode($json, true);

    if (is_array($blogData)) {
        foreach ($blogData as $entry) {
            if (isset($entry['slug'])) {
                $pages[] = $baseUrl . 'blog-details.php?slug=' . urlencode($entry['slug']);
            }
        }
    }
}

// 3. Construir XML
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
$xml .= "<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";

foreach ($pages as $url) {
    $xml .= "  <url>\n";
    $xml .= "    <loc>" . htmlspecialchars($url) . "</loc>\n";
    $xml .= "    <changefreq>weekly</changefreq>\n";
    $xml .= "    <priority>0.8</priority>\n";
    $xml .= "  </url>\n";
}

$xml .= "</urlset>";

// 4. Guardar
file_put_contents("sitemap.xml", $xml);

echo "✅ Sitemap generado: <a href='sitemap.xml' target='_blank'>Ver sitemap.xml</a>";
?>
