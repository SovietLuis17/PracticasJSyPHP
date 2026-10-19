<?php
 
 // conexion con la base de datos
 $dsn = "mysql:host=localhost;dbname=tareas_db;charset=utf8mb4";
 $user = 'root';
 $password = '';

 try {
  $conexion = new PDO($dsn,$user,$password);
  $conexion->setAttribute(PDO::ATTR_ERRMODE , PDO::ERRMODE_EXCEPTION);
  $conexion->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
  $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
 // echo "Conexion exitosa";
 } catch(PDOException $e) {
   die("Error al conectar con la base de datos ".$e->getMessage()); 
 }


 //VARIABLES DECLARACION
 $id_editar = null;
 $titulo_editar = '';
 $descripcion_editar = '';
 $fecha_editar = '';
 $estado_editar = ' Pendiente';

 // procesar  ACCIONES
 //eliminar tarea
  if (isset($_GET['action']) && $_GET['action'] === 'eliminar' &&isset($_GET['id'])) {
   $stmt = $conexion->prepare("DELETE FROM tareas WHERE id = :id");
   $stmt->execute([':id' => $_GET['id']]);
   header("Location: index.php");
   exit;
  }

  //cargar tarea para editar
    if (isset($_GET['action']) && $_GET['action'] === 'editar' &&isset($_GET['id'])) {
    $stmt = $conexion->prepare("SELECT * FROM tareas WHERE id = :id");
    $stmt->execute([':id' => $_GET['id']]);
    $tarea = $stmt->fetch();
    if ($tarea) {
        $id_editar = $tarea['id'];
        $titulo_editar = $tarea['titulo'];
        $descripcion_editar = $tarea['descripcion'];
        $fecha_Editar = $tarea['fecha_limite'];
        $estado_editar = $tarea['estado'];
    }
  }

  //cambio rapido de estado (completar tarea)
  if (isset($_GET['action']) && $_GET['action'] === 'completar' &&isset($_GET['id'])) {
    $stmt = $conexion->prepare("UPDATE tareas SET estado = 'Completada' WHERE id = :id ");
    $stmt->execute([':id' => $_GET['id']]);
     header("Location: index.php");
     exit;
  }

  //CREAR O ACTUALIZAR  

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  //gaurdamos en variables lo que viene del formulario
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_limite = $_POST['fecha_limite'];
    $estado = $_POST['estado'];
    $id = $_POST['id'] ?? null;

    if (!empty($titulo) && !empty($fecha_limite)) {
      if ($id) { 
        // UPDATE / ACTUALIZAR
        $sqlActualizar = "UPDATE tareas SET titulo = :titulo ,descripcion = :descripcion, fecha_limite = :fecha_limite, estado = :estado WHERE id = id:";
       $stmt = $conexion->prepare($sqlActualizar);
       $stmt->execute([
         ':titulo' => $titulo,
         ':descripcion' => $descripcion,
         ':fecha_limite' => $fecha_limite,
         ':estado' => $estado,
         ':id' => $id
       ]);
      } else {
      $sqlInsercion = "INSERT INTO tareas(titulo,descripcion,fecha_limite,estado) VALUES (:titulo, :descripcion, :fecha_limite, :estado)";
      $stmt = $conexion->prepare($sqlInsercion);
       $stmt->execute([
         ':titulo' => $titulo,
         ':descripcion' => $descripcion,
         ':fecha_limite' => $fecha_limite,
         ':estado' => $estado
       ]);
      }

      header("Location: index.php");
      exit;
    }
  }

  //CONSULTA GLOBLAL
  $stmt=$conexion->query("SELECT * FROM tareas ORDER BY fecha_limite ASC");
  $tareas = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Practica | CRUD BASICO CON PDO</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">
        <h2>Control de Tareas y Pendientes</h2>
        <form action="index.php" method="POST">

            <h3><?= $id_editar ? 'Editar Tarea' : 'Nueva Tarea'; ?></h3>

            <?php if ($id_editar): ?>
                <input type="hidden" name="id" value="<?= $id_editar ?>">
            <?php endif; ?>

            <label for="titulo">Titulo de la tarea</label>
            <input type="text" name="titulo" value="<?= htmlspecialchars($titulo_editar) ?>">

            <label for="descripcion">Descripcion : </label>
            <textarea name="descripcion" rows="3" value="<?= htmlspecialchars($descripcion_editar) ?>"></textarea>

            <label for="fecha">Fecha limite : </label>
            <input type="date" name="fecha_limite" value="<?= htmlspecialchars($fecha_editar) ?>" required>

            <label for="estado">Estado : </label>
            <select name="estado">
                <option value="Pendiente" <?= $estado_editar === 'Pendiente' ? 'selected' : '' ?>>Pendiente</option>
                <option value="En Proceso" <?= $estado_editar === 'En Proceso' ? 'selected' : '' ?>>En Proceso</option>
                <option value="Completada" <?= $estado_editar === 'Completada' ? 'selected' : '' ?>>Completada</option>
            </select>

            <button type="submit" class="btn-submit">
                <?= $id_editar ? 'Actualizar Tarea' : 'Guardar Tarea' ?>
            </button>

            <?php if ($id_editar): ?>
                <a href="index.php" style="margin-left: 10px "> Cancelar</a>
            <?php endif; ?>
        </form>

        <!-- TABLA -->
        <h3>Listado de tareas</h3>
        <table>
            <thead>
                <tr>
                    <th>Titulo</th>
                    <th>Descripcion</th>
                    <th>Fecha Limite</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
           <tbody>
            <?php if (count($tareas) > 0): ?>
                <?php foreach ($tareas as $t): ?>
                    <tr>
                        <td><strong><?= htmlspecialchars($t['titulo']) ?></strong></td>
                        <td><?= htmlspecialchars($t['descripcion']) ?></td>
                        <td><?= date('d/m/Y', strtotime($t['fecha_limite'])) ?></td>
                        <td>
                            <?php 
                                $clase = 'bg-pendiente';
                                if ($t['estado'] === 'En Proceso') $clase = 'bg-proceso';
                                if ($t['estado'] === 'Completada') $clase = 'bg-completada';
                            ?>
                            <span class="badge <?= $clase ?>"><?= $t['estado'] ?></span>
                        </td>
                        <td>
                            <?php if ($t['estado'] !== 'Completada'): ?>
                                <a href="index.php?action=completar&id=<?= $t['id'] ?>" class="btn btn-done" title="Marcar como Completada">✓</a>
                            <?php endif; ?>
                            <a href="index.php?action=editar&id=<?= $t['id'] ?>" class="btn btn-edit">Editar</a>
                            <a href="index.php?action=eliminar&id=<?= $t['id'] ?>" class="btn btn-delete" onclick="return confirm('¿Eliminar esta tarea?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">No hay tareas registradas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
        </table>
    </div>

</body>

</html>