<?php
/**
 * Configuration file for Charles Business Consulting Website
 */

// Define secure access constant
define('SECURE_ACCESS', true);

// Include security functions
require_once 'security-functions.php';

// Set security headers
set_security_headers();

// Database configuration (if needed)
define('DB_HOST', 'localhost');
define('DB_NAME', 'charles_consulting');
define('DB_USER', 'your_db_user');
define('DB_PASS', 'your_db_password');

// Site configuration
define('SITE_NAME', 'Charles Business Consulting');
define('SITE_URL', 'https://yoursite.com');
define('ADMIN_EMAIL', 'admin@yoursite.com');

// Security settings
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_TIMEOUT', 300); // 5 minutes
define('SESSION_TIMEOUT', 3600); // 1 hour

// File upload settings
define('MAX_FILE_SIZE', 5242880); // 5MB
define('ALLOWED_FILE_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

// Start session with secure settings
if (session_status() == PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', 1);
    ini_set('session.cookie_secure', 1);
    ini_set('session.use_strict_mode', 1);
    session_start();
}

// Regenerate session ID periodically
if (!isset($_SESSION['last_regeneration'])) {
    $_SESSION['last_regeneration'] = time();
} elseif (time() - $_SESSION['last_regeneration'] > 300) {
    session_regenerate_id(true);
    $_SESSION['last_regeneration'] = time();
}
?>
