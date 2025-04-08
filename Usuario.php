<?php

require_once 'database.php';

class Usuario
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function listarUsuarios()
    {
        // Lógica para obtener todos los usuarios
    }

    private function calcularEdad($fechaNacimiento): int
    {
        $fecha = new DateTime($fechaNacimiento);
        $hoy = new DateTime();
        $edad = $hoy->diff($fecha)->y;
        return $edad;
    }

    public function obtenerUsuario($id)
    {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            $usuario['edad'] = $this->calcularEdad($usuario['fecha_nacimiento']);
            unset($usuario['fecha_nacimiento']);
            return $usuario;
        } else {
            return false;
        }
    }

    public function crearUsuario()
    {
        // Lógica para insertar usuario
    }

    public function actualizarUsuario()
    {
        // Lógica para actualizar un usuario
    }

    public function eliminarUsuario($id)
    {
        // Lógica para eliminar un usuario
    }
}
