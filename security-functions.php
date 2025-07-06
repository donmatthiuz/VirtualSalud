<?php
/**
 * Security Functions for Charles Business Consulting Website
 * This file contains common security functions used across the site
 */

// Prevent direct access
if (!defined('SECURE_ACCESS')) {
    die('Direct access not permitted');
}

/**
 * Sanitize output data to prevent XSS attacks
 * @param string $data The data to sanitize
 * @return string Sanitized data
 */
function sanitize_output($data) {
    if (is_array($data)) {
        return array_map('sanitize_output', $data);
    }
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

/**
 * Sanitize input data
 * @param string $data The data to sanitize
 * @return string Sanitized data
 */
function sanitize_input($data) {
    if (is_array($data)) {
        return array_map('sanitize_input', $data);
    }
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Generate CSRF token
 * @return string CSRF token
 */
function generate_csrf_token() {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * @param string $token Token to verify
 * @return bool True if valid, false otherwise
 */
function verify_csrf_token($token) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Validate email address
 * @param string $email Email to validate
 * @return bool True if valid, false otherwise
 */
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

/**
 * Validate phone number (basic validation)
 * @param string $phone Phone number to validate
 * @return bool True if valid, false otherwise
 */
function validate_phone($phone) {
    return preg_match('/^[\+]?[0-9\s\-$$$$]{10,20}$/', $phone);
}

/**
 * Rate limiting function
 * @param string $identifier Unique identifier (IP, user ID, etc.)
 * @param int $max_attempts Maximum attempts allowed
 * @param int $time_window Time window in seconds
 * @return bool True if within limits, false if exceeded
 */
function check_rate_limit($identifier, $max_attempts = 5, $time_window = 300) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    
    $key = 'rate_limit_' . md5($identifier);
    $current_time = time();
    
    if (!isset($_SESSION[$key])) {
        $_SESSION[$key] = [];
    }
    
    // Remove old attempts outside the time window
    $_SESSION[$key] = array_filter($_SESSION[$key], function($timestamp) use ($current_time, $time_window) {
        return ($current_time - $timestamp) < $time_window;
    });
    
    // Check if limit exceeded
    if (count($_SESSION[$key]) >= $max_attempts) {
        return false;
    }
    
    // Add current attempt
    $_SESSION[$key][] = $current_time;
    return true;
}

/**
 * Set security headers
 */
function set_security_headers() {
    header('X-Content-Type-Options: nosniff');
    header('X-Frame-Options: DENY');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Content-Security-Policy: default-src \'self\'; script-src \'self\' \'unsafe-inline\' https://maps.googleapis.com; style-src \'self\' \'unsafe-inline\'; img-src \'self\' data:; font-src \'self\';');
}

/**
 * Log security events
 * @param string $event Event description
 * @param string $level Log level (info, warning, error)
 */
function log_security_event($event, $level = 'info') {
    $log_entry = date('Y-m-d H:i:s') . " [{$level}] " . $event . " - IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
    error_log($log_entry, 3, 'logs/security.log');
}
?>
