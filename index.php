<?php

require_once 'Usuario.php';

$usuario = new Usuario();

function leer($mensaje)
{
    echo $mensaje;
    return trim(fgets(STDIN));
}

function solicitarDatosUsuario(): array
{
    do {
        $primer_nombre = readline("Primer nombre: ");
        if (empty($primer_nombre)) {
            echo "El primer nombre no puede quedar vacío.\n"; 
        }
    } while (empty($primer_nombre));
    
    $segundo_nombre = readline("Segundo nombre (opcional): ");

    do {
        $primer_apellido = readline("Primer apellido: ");
        if (empty($primer_apellido)) {
            echo "El primer apellido no puede quedar vacío.\n";
        }
    } while (empty($primer_apellido));
    

    $segundo_apellido = readline("Segundo apellido (opcional): ");

    do {
        $fecha_nacimiento = readline("Fecha de nacimiento (YYYY-MM-DD): ");
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento)) {
            echo "El año debe tener 4 digitos, el mes 2 digitos y el dia 2 digitos.\n";
        }
    } while (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento));
    do {
        $telefono = readline("Teléfono (solo números): ");
        if (!preg_match('/^\d{10,13}$/', $telefono)) {
            echo "El teléfono debe tener minimo 10 numeros y maximo 13.\n";
        }
    } while (!preg_match('/^\d{10,13}$/', $telefono));
    
    do {
        $correo = readline("Correo: ");
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo "El correo no es valido.\n";
        }
    } while (!filter_var($correo, FILTER_VALIDATE_EMAIL));

    do {
        $direccion = readline("Dirección: ");
        if (empty($direccion)) {
            echo "La dirección no puede estar vacia.\n";
        }
    } while (empty($direccion));

    return [
        'primer_nombre' => $primer_nombre,
        'segundo_nombre' => $segundo_nombre,
        'primer_apellido' => $primer_apellido,
        'segundo_apellido' => $segundo_apellido,
        'fecha_nacimiento' => $fecha_nacimiento,
        'telefono' => $telefono,
        'correo' => $correo,
        'direccion' => $direccion
    ];
}

while (true) {
    echo "\n--- MENÚ DE USUARIOS ---\n";
    echo "1. Crear usuario\n";
    echo "2. Listar usuarios\n";
    echo "3. Obtener usuario por ID\n";
    echo "4. Actualizar usuario\n";
    echo "5. Eliminar usuario\n";
    echo "6. Salir\n";

    $opcion = leer("Seleccione una opción: ");

    switch ($opcion) {
        case 1:
            echo "\n--- Crear usuario ---\n";
            $datos = solicitarDatosUsuario();
            $usuario->setDatos($datos);
            if ($usuario->crearUsuario()) {
                echo " Usuario creado correctamente.\n";
            } else {
                echo " Error al crear usuario.\n";
            }
            break;

        case 2:
            echo "\n--- Lista de usuarios ---\n";
            $usuarios = $usuario->listarUsuarios();
            foreach ($usuarios as $u) {
                echo "ID: {$u['id']}\n";
                echo "Nombre: {$u['primer_nombre']} {$u['segundo_nombre']}\n";
                echo "Apellido: {$u['primer_apellido']} {$u['segundo_apellido']}\n";
                echo "Edad: {$u['edad']} años\n";
                echo "Teléfono: {$u['telefono']}\n";
                echo "Correo: {$u['correo']}\n";
                echo "Dirección: {$u['direccion']}\n";
                echo "----------------------------\n";
            }
            break;

        case 3:
            echo "\n--- Obtener usuario ---\n";
            $id = leer("ID del usuario: ");
            $u = $usuario->obtenerUsuario($id);
            if ($u) {
                echo "ID: {$u['id']}\n";
                echo "Nombre: {$u['primer_nombre']} {$u['segundo_nombre']}\n";
                echo "Apellido: {$u['primer_apellido']} {$u['segundo_apellido']}\n";
                echo "Edad: {$u['edad']} años\n";
                echo "Teléfono: {$u['telefono']}\n";
                echo "Correo: {$u['correo']}\n";
                echo "Dirección: {$u['direccion']}\n";
            } else {
                echo "Usuario no encontrado.\n";
            }
            break;

        case 4:
            echo "\n--- Actualizar usuario ---\n";
            $id = leer("ID del usuario a actualizar: ");
            $datos = solicitarDatosUsuario();
            if ($usuario->actualizarUsuario($id, $datos)) {
                echo " Usuario actualizado correctamente.\n";
            } else {
                echo " Error al actualizar usuario.\n";
            }
            break;

        case 5:
            echo "\n--- Eliminar usuario ---\n";
            $id = leer("ID del usuario a eliminar: ");
            if ($usuario->eliminarUsuario($id)) {
                echo " Usuario eliminado correctamente.\n";
            } else {
                echo " Error al eliminar usuario.\n";
            }
            break;

        case 6:
            echo " Saliendo del programa...\n";
            exit;

        default:
            echo " Opción no válida. Intente nuevamente.\n";
            break;
    }
}