<?php
// models/EstudianteModel.php

class EstudianteModel {
    private $db;

    public function __construct(PDO $db) {
        $this->db = $db;
    }

    public function registrarConMatricula(array $datos): bool {
        try {
            // 1. Iniciar Transacción SQL
            $this->db->beginTransaction();

            // A. Insertar en la Tabla 1: estudiantes
            $sqlEstudiante = "INSERT INTO estudiantes (cedula, nombre, email) VALUES (:cedula, :nombre, :email)";
            $stmt1 = $this->db->prepare($sqlEstudiante);
            $stmt1->execute([
                ':cedula' => $datos['cedula'],
                ':nombre' => $datos['nombre'],
                ':email'  => $datos['email']
            ]);

            // Obtener el ID autogenerado del estudiante recién insertado
            $estudianteId = $this->db->lastInsertId();

            // B. Insertar en la Tabla 2: matriculas
            $sqlMatricula = "INSERT INTO matriculas (estudiante_id, curso_id, fecha_matricula) 
                             VALUES (:estudiante_id, :curso_id, CURDATE())";
            $stmt2 = $this->db->prepare($sqlMatricula);
            $stmt2->execute([
                ':estudiante_id' => $estudianteId,
                ':curso_id'      => $datos['curso_id']
            ]);

            // 2. Confirmar Cambios (Guardado definitivo)
            $this->db->commit();
            return true;

        } catch (PDOException $e) {
            // 3. Revertir Cambios si ocurre cualquier error SQL
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            // Registrar el error en el log interno del servidor
            error_log("Error en Transacción PDO: " . $e->getMessage());
            return false;
        }
    }
}