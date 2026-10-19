<?php
// index.php
// Configuración de la Base de Datos
$host    = 'localhost';
$dbName  = 'sistemaAc';
$user    = 'root';
$pass    = '';

try {
    // Conexión PDO con opciones de errores activadas
    $db = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
} catch (PDOException $e) {
    die("Error crítico de conexión a la base de datos: " . $e->getMessage());
}

// Cargar Controlador
require_once 'EstudianteController.php';
$controller = new EstudianteController($db);

// Enrutamiento básico
$action = $_GET['action'] ?? 'crear';

if ($action === 'guardar') {
    $controller->guardar();
} else {
    $controller->crear();
}