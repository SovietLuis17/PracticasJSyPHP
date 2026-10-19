<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Estudiante y Matrícula</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="card">
    <h2>Registro de Estudiante y Asignación</h2>

<!-- Codigo embebido PHP que viene desde el controlador-->
    <?php if (!empty($mensajeExito)): ?>
        <div class="alert-success">
            <?= htmlspecialchars($mensajeExito, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

<!-- Codigo embebido PHP que viene desde el controlador-->
    <?php if (!empty($errores)): ?>
        <div class="alert-error">
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>


    <!-- FORMULARIO-->   
    <form id="formEstudiante" action="index.php?action=guardar" method="POST">
        
                <!--CAMPO DE TEXTO CEDULA -->
        <div class="form-group">
            <label for="cedula">Cédula:</label>

            <input type="text" 
                   id="cedula" 
                   name="cedula" 
                   required 
                   minlength="6" 
                   maxlength="12" 
                   pattern="^[VvEeJjGg]-[0-9]{6,9}$" 
                   placeholder="Ej: V-12345678">
            <span class="small-help">Formato: V-12345678</span>
        </div>

                <!-- Nombre completo-->
        <div class="form-group">
            <label for="nombre">Nombre Completo:</label>
            <input type="text" 
                   id="nombre" 
                   name="nombre" 
                   required 
                   minlength="3" 
                   maxlength="100" 
                   pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$" 
                   placeholder="Ej: Juan Pérez">
            <span class="small-help">Solo se permiten letras y espacios.</span>
        </div>


        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" 
                   id="email" 
                   name="email" 
                   pattern="^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$"
                   required 
                   placeholder="estudiante@correo.com">
        </div>

  
        <div class="form-group">
            <label for="curso_id">Asignar Asignatura Inicial:</label>
            <select name="curso_id" id="curso_id" required>
                <option value="">-- Seleccione una Asignatura --</option>
                <option value="1">Programación II</option>
                <option value="2">Bases de Datos I</option>
            </select>
        </div>

        <button type="submit" class="btn">Registrar y Matricular</button>
    </form>
</div>

<script>

document.getElementById('formEstudiante').addEventListener('submit', function(event) {
    const cedula  = document.getElementById('cedula');
    const nombre  = document.getElementById('nombre');
    const email   = document.getElementById('email');
    const cursoId = document.getElementById('curso_id');


    let camposVacios = [];

    if (cedula.value.trim() === '')  camposVacios.push('Cédula');
    if (nombre.value.trim() === '')  camposVacios.push('Nombre Completo');
    if (email.value.trim() === '')   camposVacios.push('Correo Electrónico');
    if (cursoId.value.trim() === '') camposVacios.push('Asignatura Inicial');

    if (camposVacios.length > 0) {
        event.preventDefault();
        alert('Por favor complete los siguientes campos obligatorios:\n- ' + camposVacios.join('\n- '));
        return;
    }


    const regexSoloLetras = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;
    if (!regexSoloLetras.test(nombre.value.trim())) {
        event.preventDefault();
        alert('El campo "Nombre Completo" no debe contener números ni caracteres especiales.');
        nombre.focus();
    }
});
</script>

</body>
</html>