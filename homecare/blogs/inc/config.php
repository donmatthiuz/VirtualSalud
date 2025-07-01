<?php
// inc/config.php - Configuración general del sitio

// Configuración de sesión segura
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 1); // HTTPS habilitado
ini_set('session.use_only_cookies', 1);
session_start();

// Configuración de errores (solo en desarrollo)
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'homecare.local') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}

// Configuración del sitio
define('SITE_NAME', 'HomeCare Global');
define('SITE_URL', 'https://homecare.global');
define('SITE_EMAIL', 'contacto@homecare.global');

// Configuración de base de datos (si la necesitas más adelante)
define('DB_HOST', 'localhost');
define('DB_NAME', 'homecare_global');
define('DB_USER', 'root');
define('DB_PASS', '');

// Configuración de email
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_PORT', 587);
define('SMTP_USER', 'tu-email@gmail.com');
define('SMTP_PASS', 'tu-password-app');

// Zona horaria
date_default_timezone_set('America/Guatemala');

// Función para incluir archivos de forma segura
function incluir_archivo($archivo) {
    $ruta = __DIR__ . '/' . $archivo;
    if (file_exists($ruta)) {
        include $ruta;
    } else {
        error_log("Archivo no encontrado: " . $ruta);
    }
}

// Headers de seguridad
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: strict-origin-when-cross-origin');
// Header adicional para HTTPS
header('Strict-Transport-Security: max-age=31536000; includeSubDomains; preload');
?>
