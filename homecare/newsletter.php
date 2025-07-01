<?php
// Include configuration and security functions
require_once 'config.php';

// Function to sanitize output
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Function to sanitize input
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

$message = '';
$message_type = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check rate limiting
    $client_ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    if (!check_rate_limit($client_ip, 3, 300)) {
        $message = 'Too many requests. Please try again later.';
        $message_type = 'error';
        log_security_event("Newsletter rate limit exceeded for IP: $client_ip", 'warning');
    } else {
        // Verify CSRF token
        if (!isset($_POST['csrf_token']) || !verify_csrf_token($_POST['csrf_token'])) {
            $message = 'Security token mismatch. Please try again.';
            $message_type = 'error';
            log_security_event("Newsletter CSRF token mismatch for IP: $client_ip", 'warning');
        } else {
            // Validate and sanitize form data
            $name = sanitize_input($_POST['name'] ?? '');
            $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
            
            // Validate required fields
            if (empty($name) || empty($email)) {
                $message = 'Please fill in all required fields.';
                $message_type = 'error';
            } elseif (!validate_email($email)) {
                $message = 'Please enter a valid email address.';
                $message_type = 'error';
            } else {
                // Here you would typically save to database or send to email service
                // For now, we'll just show a success message
                $message = 'Thank you for subscribing to our newsletter!';
                $message_type = 'success';
                log_security_event("Newsletter subscription: $email", 'info');
                
                // Generate new CSRF token for security
                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
            }
        }
    }
}

// Redirect back to referring page with message
$referer = $_SERVER['HTTP_REFERER'] ?? 'index.php';
$redirect_url = $referer . (strpos($referer, '?') !== false ? '&' : '?') . 
                'newsletter_message=' . urlencode($message) . 
                '&newsletter_type=' . urlencode($message_type);

header('Location: ' . $redirect_url);
exit;
?>
