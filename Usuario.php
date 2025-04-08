<?php

require_once 'database.php';

class Usuario
{
    private $primer_nombre;
    private $segundo_nombre;
    private $primer_apellido;
    private $segundo_apellido;
    private $fecha_nacimiento;
    private $telefono;
    private $correo;
    private $direccion;

    private PDO $conn;


    public function setDatos($datos)
    {
        $this->primer_nombre = $datos['primer_nombre'];
        $this->segundo_nombre = $datos['segundo_nombre'];
        $this->primer_apellido = $datos['primer_apellido'];
        $this->segundo_apellido = $datos['segundo_apellido'];
        $this->fecha_nacimiento = $datos['fecha_nacimiento'];
        $this->telefono = $datos['telefono'];
        $this->correo = $datos['correo'];
        $this->direccion = $datos['direccion'];
    }


    public function __construct()
    {
        $this->conn = (new Database())->getConnection();
    }

    public function listarUsuarios()
    {
        $sql = "SELECT * FROM usuarios";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($usuarios as &$usuario) {
            $usuario['edad'] = $this->calcularEdad($usuario['fecha_nacimiento']);
        }

        return $usuarios;
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
        $sql = "INSERT INTO usuarios (primer_nombre, segundo_nombre,primer_apellido,segundo_apellido,fecha_nacimiento,telefono,correo,direccion)
        VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$this->primer_nombre, $this->segundo_nombre, $this->primer_apellido, $this->segundo_apellido, $this->fecha_nacimiento, $this->telefono, $this->correo, $this->direccion]);
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
        $sql = "DELETE FROM usuarios WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
