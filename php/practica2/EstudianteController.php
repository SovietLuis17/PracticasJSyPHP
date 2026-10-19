<?php
// controllers/EstudianteController.php

require_once 'EstudianteModel.php';

class EstudianteController
{

    private $estudianteModel;

    public function __construct(PDO $db)
    {
        // Inyección de dependencia: Instanciamos el modelo con la conexión PDO
        $this->estudianteModel = new EstudianteModel($db);
    }

    public function crear()
    {
        $errores = [];
        require_once 'crear.php';
    }

    public function guardar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // 1. SANITIZACIÓN DE ENTRADAS (Métodos privados de la clase)
            $cedula = $this->sanitizarTexto($_POST['cedula'] ?? '');
            $nombre = $this->sanitizarTexto($_POST['nombre'] ?? '');
            $email = $this->sanitizarEmail($_POST['email'] ?? '');
            $cursoId = filter_var($_POST['curso_id'] ?? 0, FILTER_VALIDATE_INT);

            // 2. VALIDACIÓN ESTRICTA (BACK-END)
            $errores = [];

            // A. Cédula con Expresión Regular
            $patronCedula = '/^[VvEeJjGg]-[0-9]{6,9}$/';
            if (empty($cedula) || !preg_match($patronCedula, $cedula)) {
                $errores[] = "La cédula no cumple con el formato requerido (Ej: V-12345678).";
            }

            // B. Nombre: Mínimo 3 caracteres y SIN NÚMEROS
            $patronSoloLetras = '/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u';
            if (empty($nombre) || strlen($nombre) < 3) {
                $errores[] = "El nombre es obligatorio y debe contener al menos 3 caracteres.";
            } elseif (!preg_match($patronSoloLetras, $nombre)) {
                $errores[] = "El nombre solo debe contener letras y espacios (sin números).";
            }

            // C. Correo Electrónico
            if (!$email) {
                $errores[] = "El correo electrónico no es válido.";
            }

            // D. Selección de Asignatura
            if (!$cursoId || $cursoId <= 0) {
                $errores[] = "Debe seleccionar una asignatura válida.";
            }

            // Si hay errores de validación, volvemos a la vista sin tocar la BD
            if (!empty($errores)) {
                require_once 'crear.php';
                return;
            }

            // 3. COMUNICACIÓN CON EL MODELO (Ejecutar Transacción)
            $exito = $this->estudianteModel->registrarConMatricula([
                'cedula' => $cedula,
                'nombre' => $nombre,
                'email' => $email,
                'curso_id' => $cursoId
            ]);

            if ($exito) {
                // Redireccionar o cargar la vista con mensaje de éxito
                $mensajeExito = "¡Estudiante y matrícula registrados exitosamente!";
                require_once 'crear.php';
            } else {
                $errores[] = "Error crítico: Ocurrió un fallo en la base de datos. Operación revertida por el servidor.";
                require_once 'crear.php';
            }
        }
    }

    /* --- Métodos Helpers de Sanitización --- */

    private function sanitizarTexto(string $dato): string
    {
        return htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8');
    }

    private function sanitizarEmail(string $email): string
    {
        $emailLimpio = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
        return filter_var($emailLimpio, FILTER_VALIDATE_EMAIL) ? $emailLimpio : '';
    }
}