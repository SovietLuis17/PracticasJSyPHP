<?php

require_once 'conexion.php';

// arreglos para el proceso de registro y inicio de sesion
$erroresLogin = [];
$erroresRegistro = [];
$exitoRegistro = [];

// procesar registro de usuario

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'registro' ) {

$nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''),ENT_QUOTES, 'UTF-8');
$email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

// VALIDACIONES back end

$patronNombre = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u';
if (empty($nombre) || strlen($nombre) <3  || !preg_match($patronNombre,$nombre)) { 
 $erroresRegistro[] = 'El nombre es obligatorio, sin numeros y minimo 3 caracteres';
}

if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
$erroresRegistro[] = 'Ingrese un correo valido';
}

if(empty($password) || strlen($password) < 6) {
$erroresRegistro[] = 'La contraseña debe tener al menos 6 caracteres';
}

// SI NO HAY ERRORES 

if (empty($erroresRegistro)) {
 try {
    $passHash = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO usuarios(nombre,email,password) VALUES (:nombre,:email,:password)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
    ':nombre' => $nombre,
    ':email' => $email,
    ':password' => $passHash 
    ]);
    $exitoRegistro = "Registro exitoso! Ya puedes inciiar sesion!";

 } catch(PDOException $e) {
   if ($e->getCode() === 23000) {
  $erroresRegistro[] = "El correo electronico ya se encuentra registro";
   }
   else {
    $erroresRegistro[] = "Error al registrar el usuario";
   }
 }
}
}


// PROCESAR INICIAR SESION
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login' ) {

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$password = $_POST['password'] ?? '';

//validamos
if (!filter_var($email,FILTER_VALIDATE_EMAIL) || empty($password)) {
$erroresLogin[] = 'Por favor ingresa credenciales valida';
}
else {
    $sql = "SELECT * FROM usuarios WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);
    $usuario = $stmt->fetch();

    //usando funcion password_verify()

    if($usuario && password_verify($password, $usuario['password'])) {
      header('Location: dashboard.php?usuario=id'.$usuario['id']);
      exit; 
    }
    else {
        $erroresLogin[] = 'Credenciales incorrectas';
    }
}

}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso al Sistema</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row g-4 justify-content-center">
        
        <!-- Login -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Iniciar Sesión</h3>

                <!--AQUI VA ALGO -->
                <?php if (!empty($erroresLogin)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($erroresLogin as $err): ?>
                                <div><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="login">
                        
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Registro -->
        <div class="col-md-5">
            <div class="card shadow-sm border-0">
                <div class="card-body p-4">
                    <h3 class="card-title text-center mb-4">Registro de Usuario</h3>

           <!-- AQUI VA ALGO-->
            <?php if (!empty($exitoRegistro)): ?>
                        <div class="alert alert-success"><?= htmlspecialchars($exitoRegistro, ENT_QUOTES, 'UTF-8') ?></div>
                    <?php endif; ?>

                    <!-- Sanitizacion al renderizar errores de Registro -->
                    <?php if (!empty($erroresRegistro)): ?>
                        <div class="alert alert-danger">
                            <?php foreach ($erroresRegistro as $err): ?>
                                <div><?= htmlspecialchars($err, ENT_QUOTES, 'UTF-8') ?></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                   

                    <form action="index.php" method="POST">
                        <input type="hidden" name="action" value="registro">

                        <div class="mb-3">
                            <label class="form-label">Nombre Completo</label>
                            <input type="text" name="nombre" class="form-control" required minlength="3" pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$" placeholder="Ej. Pedro Pérez">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" required placeholder="correo@ejemplo.com">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control" required minlength="6">
                        </div>

                        <button type="submit" class="btn btn-success w-100">Registrarse</button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>