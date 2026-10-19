<?php

//variables para la conexion con PDO
$host = 'localhost';
$user = 'root';
$password = '';
$charset = 'utf8mb4';
$dbname = 'practica1';

// dsn
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

//arreglo con opciones de configuracion 
$opciones = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES => false
];

// instanciar la clase PDO con try-catch
try {
  $conexion = new PDO($dsn, $user, $password, $opciones);
} catch (PDOException $e) {
  die("<h2> Error al connectar con la Base de datos </h2>" . $e->getMessage());
}

$mensaje = '';
$error = '';

//procesar informacion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre = strip_tags(trim($_POST['nombre'] ?? ''));
  $apellido = strip_tags(trim($_POST['apellido'] ?? ''));
  $correo = trim($_POST['email'] ?? '');

  $correoLimpio = filter_var($correo,FILTER_SANITIZE_EMAIL);

  if (!empty($nombre) && !empty($apellido) && !empty($correo)) {
     
   $stmt = $conexion->prepare('INSERT INTO usuario (nombre,apellido,email) VALUES (:nombre,:apellido,:correo)');
   $stmt->execute([
    ':nombre' => $nombre,
    ':apellido' => $apellido,
    ':correo' => $correo
   ]);

  } else {
    $error = "Error datos inconpletos";
    
  }
  

}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Practica1</title>
  <link rel="stylesheet" href="style.css">
</head>

<body>

<section>

  <div class="formulario"> 
    <?php if(!empty($error)) :?>
     <div class="error">
      <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ;?></p>
     </div>
    <?php endif; ?>  

    <form action="procesar.php" method="post">
      <h2>Formulario de registro de usuario</h2>
      <label >Nombre :</label>
      <input type="text" name="nombre" required minlength="3" maxlength="100">
      <label >Apellido :</label>
      <input type="text" name="apellido" required minlength="3" maxlength="100">
      <label >Correo Electronico :</label>
      <input type="email" name="email" required maxlength="100">
      <button type="submit" class="btn-envio">Registro</button>
    </form>
  </div>
  <a href="" class="btn-footer">Footer</a>
</section>

  <div class="footer">
    <h3>Pie de Pagina | 2026</h3>
    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Sapiente maiores quasi nihil aliquid explicabo, ipsa
      neque iste cum! Dicta, laborum earum consequuntur dolorum quod aliquam rem inventore. Eveniet, omnis consequatur?
    </p>
  </div>
  <script src="prueba.js"></script>
</body>
</html>