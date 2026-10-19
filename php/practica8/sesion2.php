<?php
// iniciar sesion_star()
session_start();
if (!isset($_SESSION['usuario'])) {
   header("Location: sesion1.php");
   exit;
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Usuario</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #eef2f3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .panel-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
            text-align: center;
        }
        .avatar-simulation {
            width: 70px;
            height: 70px;
            background-color: #3498db;
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 28px;
            font-weight: bold;
            margin: 0 auto 20px auto;
        }
        h2 {
            margin: 0 0 10px 0;
            color: #2c3e50;
            font-size: 24px;
            word-wrap: break-word;
        }
        p {
            color: #7f8c8d;
            font-size: 15px;
            margin: 0 0 30px 0;
        }
        .btn-logout {
            display: block;
            background-color: #e74c3c;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            transition: background-color 0.2s;
        }
        .btn-logout:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>

<div class="panel-container">
    <!-- Círculo decorativo con la inicial del usuario -->
    <div class="avatar-simulation">
        <?= strtoupper(substr(htmlspecialchars($_SESSION['usuario']), 0, 1)) ?>
    </div>

    <h2>Bienvenido, <?= htmlspecialchars($_SESSION['usuario']) ?></h2>
    <p>Has iniciado sesión correctamente.</p>
    <p>Tu rol es el siguiente : <?= htmlspecialchars($_SESSION['rol']) ?></p>

    
    <a href="logout.php" class="btn-logout">Cerrar sesión</a>
</div>

</body>
</html>
