<?php
// funciones_seguridad.php - Incluir en todas las páginas

/**
 * Sanitiza datos de entrada para prevenir XSS
 */
function sanitizar_entrada($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

/**
 * Valida email
 */
function validar_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Sanitiza para mostrar en HTML
 */
function mostrar_seguro($texto) {
    return htmlspecialchars($texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Procesar formulario de contacto de forma segura
 */
function procesar_contacto_seguro() {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitizar todos los campos
        $nombre = sanitizar_entrada($_POST['name'] ?? '');
        $email = sanitizar_entrada($_POST['email'] ?? '');
        $telefono = sanitizar_entrada($_POST['phone'] ?? '');
        $sitio_web = sanitizar_entrada($_POST['web'] ?? '');
        $mensaje = sanitizar_entrada($_POST['message'] ?? '');
        
        // Validaciones
        $errores = [];
        
        if (empty($nombre)) {
            $errores[] = "El nombre es requerido";
        }
        
        if (empty($email) || !validar_email($email)) {
            $errores[] = "Email válido es requerido";
        }
        
        if (empty($mensaje)) {
            $errores[] = "El mensaje es requerido";
        }
        
        // Si no hay errores, procesar
        if (empty($errores)) {
            return enviar_email_seguro($nombre, $email, $telefono, $sitio_web, $mensaje);
        } else {
            return ['success' => false, 'errores' => $errores];
        }
    }
    return ['success' => false, 'mensaje' => 'Método no permitido'];
}

/**
 * Enviar email de forma segura
 */
function enviar_email_seguro($nombre, $email, $telefono, $sitio_web, $mensaje) {
    // Configuración del email
    $para = "tu-email@dominio.com";
    $asunto = "Nuevo mensaje de contacto - " . mostrar_seguro($nombre);
    
    // Construir el mensaje
    $cuerpo = "Nuevo mensaje de contacto:\n\n";
    $cuerpo .= "Nombre: " . $nombre . "\n";
    $cuerpo .= "Email: " . $email . "\n";
    $cuerpo .= "Teléfono: " . $telefono . "\n";
    $cuerpo .= "Sitio Web: " . $sitio_web . "\n";
    $cuerpo .= "Mensaje: " . $mensaje . "\n";
    
    // Headers seguros
    $headers = "From: " . $email . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();
    
    // Enviar email
    if (mail($para, $asunto, $cuerpo, $headers)) {
        return ['success' => true, 'mensaje' => 'Mensaje enviado correctamente'];
    } else {
        return ['success' => false, 'mensaje' => 'Error al enviar el mensaje'];
    }
}

// Función para mostrar mensajes de forma segura
function mostrar_mensaje($tipo, $mensaje) {
    $clase = $tipo === 'success' ? 'alert-success' : 'alert-danger';
    return '<div class="alert ' . $clase . '">' . mostrar_seguro($mensaje) . '</div>';
}
?>
