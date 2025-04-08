CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    primer_nombre VARCHAR(50),
    segundo_nombre VARCHAR(50),
    primer_apellido VARCHAR(50),
    segundo_apellido VARCHAR(50),
    fecha_nacimiento DATE,
    telefono VARCHAR(15),
    correo VARCHAR(100),
    direccion VARCHAR(100)
);

