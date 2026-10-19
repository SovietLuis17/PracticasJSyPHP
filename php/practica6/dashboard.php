
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Mi Sistema Web</a>
        <div class="d-flex align-items-center">
            <span class="navbar-text me-3">

              
            </span>
            <a href="index.php" class="btn btn-outline-light btn-sm">Salir</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="row g-4">
        
        <!-- Formulario Registro de Equipo -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Registrar Nuevo Equipo</h5>

              

                    <form action="dashboard.php" method="POST">
                        <input type="hidden" name="action" value="crear_equipo">
                        <!-- Sanitización del ID renderizado en el atributo HTML -->
                        <input type="hidden" name="usuario_id" value="<?= htmlspecialchars($usuario_id, ENT_QUOTES, 'UTF-8') ?>">

                        <div class="mb-3">
                            <label class="form-label">Código de Equipo</label>
                            <input type="text" name="codigo" class="form-control" required pattern="^[EQ]-[0-9]{4,8}$" placeholder="Ej. EQ-1001">
                            <div class="form-text">Formato: EQ-1001</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nombre del Equipo</label>
                            <input type="text" name="nombre" class="form-control" required minlength="3" placeholder="Ej. Laptop Dell">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Guardar Equipo</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabla de Listado de Equipos -->
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title mb-3">Mis Equipos Registrados</h5>

                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
