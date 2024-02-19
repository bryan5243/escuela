<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once '../model/conexion.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = conectarBaseDeDatos();

   

        // Obtener datos del formulario de Estudiante
        $cedulaEstudiante = $_POST['cedula'];
        $apellidosEstudiante = $_POST['apellidos'];
        $nombresEstudiante = $_POST['nombres'];
        $direccionEstudiante = $_POST['direccion'];
        $condicionEstudiante = ($_POST['discapacidad'] == 'si') ? 1 : 0; // Convert 'si' to 1, 'no' to 0

        // Insertar datos en la tabla Estudiante
        $stmtEstudiante = $conn->prepare("INSERT INTO estudiante (cedula, apellidos, nombres, direccion, condicion) VALUES (?, ?, ?, ?, ?)");
        $stmtEstudiante->execute([
            $cedulaEstudiante,
            $apellidosEstudiante,
            $nombresEstudiante,
            $direccionEstudiante,
            $condicionEstudiante
        ]);

        $idEstudiante = $conn->lastInsertId();

        // Verificar si el estudiante tiene discapacidad
        if ($_POST['discapacidad'] == 'si') {
            $tipoDiscapacidad = $_POST['tipoDiscapacidad'];
            $porcentajeDiscapacidad = $_POST['porcentajeDiscapacidad'];

            // Insertar datos en la tabla Discapacidad
            $stmtDiscapacidad = $conn->prepare("INSERT INTO discapacidad (tipo, porcentaje, id_estudiante) VALUES (?, ?, ?)");
            $stmtDiscapacidad->execute([
                $tipoDiscapacidad,
                $porcentajeDiscapacidad,
                $idEstudiante
            ]);
        }

        // Insertar datos en la tabla Persona y Rol para Mamá
        guardarPersonaRol($conn, 'Madre', $idEstudiante);

        // Insertar datos en la tabla Persona y Rol para Papá
        guardarPersonaRol($conn, 'Padre', $idEstudiante);

        // Insertar datos en la tabla Persona y Rol para Representante
        guardarPersonaRol($conn, 'Representante', $idEstudiante);

       

        // Resto del código de tu archivo de guardado


    $conn = null;
}

function guardarPersonaRol($conn, $rol, $idEstudiante)
{
    $cedulaPersona = $_POST['cedula_' . ucfirst($rol)];
    $apellidosNombresPersona = $_POST['apellidosNombres_' . ucfirst($rol)];
    $telefonoPersona = $_POST['telefono_' . ucfirst($rol)];

    $stmtPersona = $conn->prepare("INSERT INTO persona (cedula, apellidos_nombres, telefono, id_estudiante) VALUES (?, ?, ?, ?)");
    $stmtPersona->execute([
        $cedulaPersona,
        $apellidosNombresPersona,
        $telefonoPersona,
        $idEstudiante
    ]);

    $idPersona = $conn->lastInsertId();
    $stmtRol = $conn->prepare("INSERT INTO rol (rol, id_persona) VALUES (?, ?)");
    $stmtRol->execute([$rol, $idPersona]);
}
