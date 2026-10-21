<?php
header('Content-Type: application/json; charset=utf-8');

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'mensaje' => 'Método no permitido']);
    exit;
}

// Recoger datos (FormData → $_POST)
$nombre   = trim($_POST['nombre']   ?? '');
$apellido = trim($_POST['apellido'] ?? '');
$correo   = trim($_POST['correo']   ?? '');
$telefono = trim($_POST['telefono'] ?? '');

$errores = [];

// Nombre
if ($nombre === '') {
    $errores['nombre'] = 'El nombre es obligatorio';
} elseif (!preg_match('/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:\s+[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$/u', $nombre)) {
    $errores['nombre'] = 'El nombre no es válido';
}

// Apellido
if ($apellido === '') {
    $errores['apellido'] = 'El apellido es obligatorio';
} elseif (!preg_match('/^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:\s+[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$/u', $apellido)) {
    $errores['apellido'] = 'El apellido no es válido';
}

// Correo
if ($correo === '') {
    $errores['correo'] = 'El correo es obligatorio';
} elseif (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
    $errores['correo'] = 'El correo no es válido';
}

// Teléfono
if ($telefono === '') {
    $errores['telefono'] = 'El teléfono es obligatorio';
} elseif (!preg_match('/^[0-9+\s()-]{7,20}$/', $telefono)) {
    $errores['telefono'] = 'El teléfono no es válido';
}

// Si hay errores, devolverlos con código 422
if (!empty($errores)) {
    http_response_code(422);
    echo json_encode([
        'success' => false,
        'mensaje' => 'Hay errores en el formulario',
        'errores' => $errores
    ]);
    exit;
}

// ─────────────────────────────────────────────
// Aquí iría el guardado real:
//   - Insertar en base de datos con PDO
//   - Enviar un correo con mail() o PHPMailer
//   - Guardar en un archivo .txt
// ─────────────────────────────────────────────

echo json_encode([
    'success' => true,
    'mensaje' => '¡Enviado! Tus datos fueron recibidos correctamente'
]);