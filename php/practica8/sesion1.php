<?php

//voy crear (inicio)
session_start(); //solicita que mande la llave de la boveda

$datos = [
'correo' => 'luis17@gmail.com',
'password' => '1234'
];



// preguntar si hay un envio a traves del metodo POST
if($_SERVER['REQUEST_METHOD'] === 'POST') {

// limpiando con trim y guardado en variables lo que viaja en el formulario
$correo = trim($_POST['email'] ?? ''); 
$password = trim($_POST['password'] ?? ''); 

if($correo === $datos['correo'] && $password === $datos['password']) {
  // GUARDAR INFORMACION EN LA BOVEDA
 $_SESSION['usuario'] = $correo;
 $_SESSION['rol'] = 'usuario';
 
 header("Location: sesion2.php"); //redireccionamos a la siguiente vista
 exit; // detener la ejecucion de un script
  
  

} else {

}



}


?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
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
        .login-container {
            background-color: #ffffff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 360px;
            box-sizing: border-box;
        }
        h2 {
            margin: 0 0 24px 0;
            color: #2c3e50;
            text-align: center;
            font-size: 24px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            color: #555555;
            font-size: 14px;
            font-weight: 600;
        }
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #cccccc;
            border-radius: 6px;
            box-sizing: border-box;
            font-size: 14px;
            transition: border-color 0.2s;
        }
        input:focus {
            border-color: #3498db;
            outline: none;
        }
        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 13px;
        }
        .options a {
            color: #3498db;
            text-decoration: none;
        }
        .options a:hover {
            text-decoration: underline;
        }
        button {
            width: 100%;
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.2s;
        }
        button:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>

<div class="login-container">
    <h2>Iniciar Sesión</h2>
    <form action="sesion1.php" method="POST">
        <div class="form-group">
            <label for="email">Correo Electrónico</label>
            <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com">
        </div>
        
        <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" id="password" name="password" required placeholder="••••••••">
        </div>
        
        <div class="options">
            <label>
                <input type="checkbox" name="remember"> Recordarme
            </label>
            <a href="#">¿Olvidaste tu contraseña?</a>
        </div>
        
        <button type="submit">Ingresar</button>
    </form>
</div>

</body>
</html>
