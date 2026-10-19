<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiante y Matriculas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

  <div class="card">

    <h2>Registro de Estudiante y Asignacion </h2>

        <?php if (!empty($mensajeExito)): ?>
        <div class="alert-success">
            <?= htmlspecialchars($mensajeExito, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>


    <?php if (!empty($errores)): ?>
        <div class="alert-error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    



  </div>
    
</body>
</html>