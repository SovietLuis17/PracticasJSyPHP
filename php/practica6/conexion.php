<?php
// conexion.php
$host    = 'localhost';
$dbName  = 'ejercicio';
$user    = 'root';
$pass    = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
    echo "Conexion establecida";
} catch (PDOException $e) {
    die("Error crítico de conexión: " . $e->getMessage());
}


