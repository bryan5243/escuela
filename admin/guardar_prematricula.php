<?php
include_once '../model/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = conectarBaseDeDatos();

    try {
        $pdo->beginTransaction();

        // Obtener datos del formulario de Estudiante
        $cedulaEstudiante = $_POST['cedula'];
        $apellidosEstudiante = $_POST['apellidos'];
        $nombresEstudiante = $_POST['nombres'];
        $direccionEstudiante = $_POST['direccion'];
        $condicionEstudiante = ($_POST['discapacidad'] == 'si') ? 1 : 0; // Convert 'si' to 1, 'no' to 0

        // Insertar datos en la tabla Estudiante
        $stmtEstudiante = $pdo->prepare("INSERT INTO estudiante (cedula, apellidos, nombres, direccion, condicion) VALUES (?, ?, ?, ?, ?)");
        $stmtEstudiante->execute([
            $cedulaEstudiante,
            $apellidosEstudiante,
            $nombresEstudiante,
            $direccionEstudiante,
            $condicionEstudiante
        ]);

        $idEstudiante = $pdo->lastInsertId();

        // Verificar si el estudiante tiene discapacidad
        if ($_POST['discapacidad'] == 'si') {
            $tipoDiscapacidad = $_POST['tipoDiscapacidad'];
            $porcentajeDiscapacidad = $_POST['porcentajeDiscapacidad'];

            // Insertar datos en la tabla Discapacidad
            $stmtDiscapacidad = $pdo->prepare("INSERT INTO discapacidad (tipo, porcentaje, id_estudiante) VALUES (?, ?, ?)");
            $stmtDiscapacidad->execute([
                $tipoDiscapacidad,
                $porcentajeDiscapacidad,
                $idEstudiante
            ]);
        }

        // Insertar datos en la tabla Persona y Rol para Mamá
        guardarPersonaRol($pdo, 'Madre', $idEstudiante);

        // Insertar datos en la tabla Persona y Rol para Papá
        guardarPersonaRol($pdo, 'Padre', $idEstudiante);

        // Insertar datos en la tabla Persona y Rol para Representante
        guardarPersonaRol($pdo, 'Representante', $idEstudiante);

        $pdo->commit();

        echo "La prematrícula se ha guardado exitosamente.";
        exit();
    } catch (Exception $e) {
        $pdo->rollback();
        echo "Error al procesar la matrícula: " . $e->getMessage();
        exit();
    }
}

function guardarPersonaRol($pdo, $rol, $idEstudiante)
{
    $cedulaPersona = $_POST['cedula_' . ucfirst($rol)];
    $apellidosNombresPersona = $_POST['apellidosNombres_' . ucfirst($rol)];
    $telefonoPersona = $_POST['telefono_' . ucfirst($rol)];

    $stmtPersona = $pdo->prepare("INSERT INTO persona (cedula, apellidos_nombres, telefono, id_estudiante) VALUES (?, ?, ?, ?)");
    $stmtPersona->execute([
        $cedulaPersona,
        $apellidosNombresPersona,
        $telefonoPersona,
        $idEstudiante
    ]);

    $idPersona = $pdo->lastInsertId();
    $stmtRol = $pdo->prepare("INSERT INTO rol (rol, id_persona) VALUES (?, ?)");
    $stmtRol->execute([$rol, $idPersona]);
}
?>