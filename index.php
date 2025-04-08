<?php

require_once 'Usuario.php';

$usuario = new Usuario();

function leer($mensaje) {
    echo $mensaje;
    return trim(fgets(STDIN));
}

function solicitarDatosUsuario(): array
{
    do {
        $primer_nombre = readline("Primer nombre: ");
    } while (empty($primer_nombre));

    $segundo_nombre = readline("Segundo nombre (opcional): ");

    do {
        $primer_apellido = readline("Primer apellido: ");
    } while (empty($primer_apellido));

    $segundo_apellido = readline("Segundo apellido (opcional): ");

    do {
        $fecha_nacimiento = readline("Fecha de nacimiento (YYYY-MM-DD): ");
    } while (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha_nacimiento));

    do {
        $telefono = readline("Teléfono (solo números): ");
    } while (!preg_match('/^\d{7,15}$/', $telefono));
    

    do {
        $correo = readline("Correo: ");
    } while (!filter_var($correo, FILTER_VALIDATE_EMAIL));

    do {
        $direccion = readline("Dirección: ");
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
            $usuario->listarUsuarios();
            break;

        case 3:
            echo "\n--- Obtener usuario ---\n";
            $id = leer("ID del usuario: ");
            $usuario->obtenerUsuario($id);
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