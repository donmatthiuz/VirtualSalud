<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Método no permitido');
}

// Validar y sanitizar los datos
function sanitize($value) {
    return htmlspecialchars(trim($value));
}

$name = sanitize($_POST['name'] ?? '');
$phone = sanitize($_POST['phone'] ?? '');
$email = sanitize($_POST['email'] ?? '');
$service_raw = $_POST['service'] ?? '';
$message = sanitize($_POST['message'] ?? '');

// Mapear opciones del formulario a lo que espera la API
$service_map = [
    'domiciliar' => 'Enfermería a Domicilio',
    'adulto_mayor' => 'Cuidado de Adultos Mayores',
    'paliativos' => 'Cuidado Post-Operatorio',
    'medicamentos' => 'Acompañamiento Médico',
    'postoperatorios' => 'Terapia Física',
];
$service_type = $service_map[$service_raw] ?? 'Otros';

// Validación básica
if (!$name || !$phone || !$email || !$service_type) {
    http_response_code(400);
    echo json_encode(['error' => 'Faltan campos obligatorios']);
    exit;
}

// Preparar datos para FastAPI
$data = [
    'name' => $name,
    'phone' => $phone,
    'email' => $email,
    'service_type' => $service_type,
    'message' => $message,
];

// Enviar POST a FastAPI
$api_url = 'http://localhost:8000/contact';

$options = [
    'http' => [
        'header'  => "Content-Type: application/json\r\n",
        'method'  => 'POST',
        'content' => json_encode($data),
        'ignore_errors' => true
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($api_url, false, $context);

// Mostrar resultado (puedes redirigir o mostrar en pantalla)
if ($response === false) {
    echo json_encode(['error' => 'No se pudo conectar con el servidor.']);
    exit;
}

echo $response; // Devuelve lo que responde FastAPI
