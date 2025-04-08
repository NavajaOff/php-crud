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

    public function actualizarUsuario($id, $datos)
    {
        $sql = "UPDATE usuarios SET 
                primer_nombre = :primer_nombre,
                segundo_nombre = :segundo_nombre,
                primer_apellido = :primer_apellido,
                segundo_apellido = :segundo_apellido,
                fecha_nacimiento = :fecha_nacimiento,
                telefono = :telefono,
                correo = :correo,
                direccion = :direccion
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $datos[':id'] = $id;

        return $stmt->execute([
            ':primer_nombre' => $datos['primer_nombre'],
            ':segundo_nombre' => $datos['segundo_nombre'],
            ':primer_apellido' => $datos['primer_apellido'],
            ':segundo_apellido' => $datos['segundo_apellido'],
            ':fecha_nacimiento' => $datos['fecha_nacimiento'],
            ':telefono' => $datos['telefono'],
            ':correo' => $datos['correo'],
            ':direccion' => $datos['direccion'],
            ':id' => $id
        ]);
    }

    public function eliminarUsuario($id)
    {
        // Lógica para eliminar un usuario
    }
}
