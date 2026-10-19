<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$dbName = 'prueba_pdo';
$dsn = "mysql:host=$host;dbname=$dbName;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false
];


try {

    $conexion = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    die("Error crítico de conexión: " . $e->getMessage());
}
/* 
REGISTROOOOO
*/

$errores = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'register') {


    $titulo = trim($_POST['titulo'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');

    if (empty($titulo)) {
        $errores[] = "El titulo no puede estar vacio";
    }
    if (empty($descripcion)) {
        $errores[] = "La descripcion no puede estar vacio";
    }


    if (empty($errores)) {
        try {

            $sql = "INSERT INTO tareas (titulo,descripcion) VALUES (:titulo,:descripcion)";
            $stmt = $conexion->prepare($sql);
            $stmt->execute([
                ':titulo' => $titulo,
                ':descripcion' => $descripcion
            ]);

            header("Location: index.php");
            exit;

        } catch (PDOException $e) {
            die("Error al registrar " . $e->getMessage());
        }
    }



}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica7</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="card">
        <div class="card-body">
            <?php if (!empty($errores)): ?>
                <div class="alert alert-danger">
                    <?php foreach ($errores as $err): ?>
                        <div><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <form action="index.php" method="post">
                <input type="hidden" name="action" value="register">
                <div class="mb-3">
                    <label for="titulo" class="form-label">Titulo : </label>
                    <input type="text" class="form-control" id="titulo"
                        placeholder="Titulo : Hacer practica Programación" name="titulo">
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripcion (tarea):</label>
                    <textarea class="form-control" id="descripcion" rows="3" name="descripcion"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Crear Tarea</button>
            </form>
        </div>
    </div>

    <div class="card">
        <h5 class="card-header">Tareas registradas actualmente : </h5>
        <div class="card-body">
            <ul class="list-group">

            </ul>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI"
        crossorigin="anonymous"></script>
</body>

</html>