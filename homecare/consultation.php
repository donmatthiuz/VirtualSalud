<?php
session_start();

// Verificar token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    die('Error de seguridad: Token CSRF inválido');
}

// Función para limpiar datos
function sanitize_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para sanitizar salida (debe estar definida en tu sistema)
function sanitize_output($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}

// Verificar que sea una petición POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Validar y sanitizar datos
    $name = sanitize_input($_POST['name']);
    $phone = sanitize_input($_POST['phone']);
    $email = sanitize_input($_POST['email']);
    $service = sanitize_input($_POST['service']);
    $message = sanitize_input($_POST['message']);
    
    // Validaciones básicas
    $errors = [];
    
    if (empty($name) || strlen($name) > 50) {
        $errors[] = "El nombre es requerido y debe tener máximo 50 caracteres";
    }
    
    if (empty($phone) || strlen($phone) > 20) {
        $errors[] = "El teléfono es requerido y debe tener máximo 20 caracteres";
    }
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) > 100) {
        $errors[] = "El correo electrónico es requerido y debe ser válido";
    }
    
    if (empty($service)) {
        $errors[] = "Debe seleccionar un servicio";
    }
    
    if (strlen($message) > 1000) {
        $errors[] = "El mensaje debe tener máximo 1000 caracteres";
    }
    
    // Mapear servicios para mostrar nombres legibles
    $services_map = [
        'business' => 'Atención Domiciliar',
        'consumer' => 'Cuidado Adulto Mayor',
        'financial' => 'Cuidados Paliativos',
        'software' => 'Post Operatorios' // Nota: tienes dos opciones con el mismo valor
    ];
    
    $service_name = isset($services_map[$service]) ? $services_map[$service] : $service;
    
    // Si no hay errores, proceder con el envío
    if (empty($errors)) {
        
        // Configuración del correo
        $to = "mathewcordero100@hotmail.com"; // Cambia por tu email
        $subject = "Nueva Consulta - Servicios de Cuidado Médico";
        
        // Cuerpo del mensaje
        $email_body = "
        <html>
        <head>
            <title>Nueva Consulta</title>
        </head>
        <body>
            <h2>Nueva Consulta Recibida</h2>
            <p><strong>Nombre:</strong> $name</p>
            <p><strong>Teléfono:</strong> $phone</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Servicio solicitado:</strong> $service_name</p>
            <p><strong>Mensaje:</strong></p>
            <p>" . nl2br($message) . "</p>
            <hr>
            <p><small>Enviado desde el formulario de consulta el " . date('d/m/Y H:i:s') . "</small></p>
        </body>
        </html>
        ";
        
        // Cabeceras del correo
        $headers = array(
            'MIME-Version' => '1.0',
            'Content-type' => 'text/html; charset=UTF-8',
            'From' => $email,
            'Reply-To' => $email,
            'X-Mailer' => 'PHP/' . phpversion()
        );
        
        // Convertir headers a string
        $headers_string = '';
        foreach($headers as $key => $value) {
            $headers_string .= $key . ': ' . $value . "\r\n";
        }
        
        // Enviar correo
        if (mail($to, $subject, $email_body, $headers_string)) {
            // Éxito - redirigir o mostrar mensaje
            $success_message = "¡Gracias por contactarnos! Su consulta ha sido enviada exitosamente. Nos pondremos en contacto con usted pronto.";
            
            // Opcional: Enviar correo de confirmación al cliente
            $client_subject = "Confirmación de Consulta - Servicios de Cuidado Médico";
            $client_body = "
            <html>
            <head>
                <title>Confirmación de Consulta</title>
            </head>
            <body>
                <h2>Gracias por contactarnos, $name</h2>
                <p>Hemos recibido su consulta sobre nuestros servicios de <strong>$service_name</strong>.</p>
                <p>Nos pondremos en contacto con usted en las próximas 24 horas al teléfono: $phone</p>
                <p>Si tiene alguna pregunta urgente, no dude en llamarnos.</p>
                <br>
                <p>Saludos cordiales,<br>
                Equipo de Servicios de Cuidado Médico</p>
            </body>
            </html>
            ";
            
            $client_headers = array(
                'MIME-Version' => '1.0',
                'Content-type' => 'text/html; charset=UTF-8',
                'From' => $to,
                'X-Mailer' => 'PHP/' . phpversion()
            );
            
            $client_headers_string = '';
            foreach($client_headers as $key => $value) {
                $client_headers_string .= $key . ': ' . $value . "\r\n";
            }
            
            mail($email, $client_subject, $client_body, $client_headers_string);
            
        } else {
            $error_message = "Hubo un error al enviar su consulta. Por favor, inténtelo nuevamente o contáctenos directamente.";
        }
        
    } else {
        // Hay errores de validación
        $error_message = "Por favor, corrija los siguientes errores:<br>" . implode("<br>", $errors);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultado de Consulta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .message-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .success {
            color: #28a745;
            border-left: 4px solid #28a745;
            padding-left: 15px;
        }
        .error {
            color: #dc3545;
            border-left: 4px solid #dc3545;
            padding-left: 15px;
        }
        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="message-container">
        <?php if (isset($success_message)): ?>
            <div class="success">
                <h2>✓ Consulta Enviada</h2>
                <p><?php echo $success_message; ?></p>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="error">
                <h2>✗ Error</h2>
                <p><?php echo $error_message; ?></p>
            </div>
        <?php endif; ?>
        
        <a href="javascript:history.back()" class="back-button">Volver al Formulario</a>
    </div>
</body>
</html>