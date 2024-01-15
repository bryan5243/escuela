<?php

include_once '../model/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = conectarBaseDeDatos();

    try {
        $pdo->beginTransaction();

        // Obtener datos del formulario de Estudiante
        $cedulaEstudiante = $_POST['cedula_estudiante'];
        $apellidosEstudiante = $_POST['apellidos_estudiante'];
        $nombresEstudiante = $_POST['nombres_estudiante'];
        $lugarNacimientoEstudiante = $_POST['lugar_nacimiento_estudiante'];
        $residenciaEstudiante = $_POST['residencia_estudiante'];
        $direccionEstudiante = $_POST['direccion_estudiante'];
        $sectorEstudiante = $_POST['sector_estudiante'];
        $fechaNacimientoEstudiante = $_POST['fecha_nacimiento_estudiante'];
        
        
       // $fotoEstudiante = $rutaCompletaEstudiante;//

        $estadoEstudiante = '1'; // Estado activo
        $idGradoEstudiante = $_POST['id_grado_estudiante'];
        $idParaleloEstudiante = $_POST['id_paralelo_estudiante'];
        $codigoUnicoEstudiante = $_POST['codigo_unico_estudiante'];
        $condicionEstudiante = $_POST['condicion_estudiante'];

        // Insertar datos en la tabla Estudiante
        $stmtEstudiante = $pdo->prepare("INSERT INTO estudiante (cedula, apellidos, nombres, lugar_nacimiento, residencia, direccion, sector, fecha_nacimiento, estado, id_grado, id_paralelo, codigo_unico, condicion) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmtEstudiante->execute([
            $cedulaEstudiante,
            $apellidosEstudiante,
            $nombresEstudiante,
            $lugarNacimientoEstudiante,
            $residenciaEstudiante,
            $direccionEstudiante,
            $sectorEstudiante,
            $fechaNacimientoEstudiante,
            //$fotoEstudiante,//
            $estadoEstudiante,
            $idGradoEstudiante,
            $idParaleloEstudiante,
            $codigoUnicoEstudiante,
            $condicionEstudiante
        ]);

        $idEstudiante = $pdo->lastInsertId();

        // Verificar si el estudiante tiene discapacidad
        if ($_POST['condicion_estudiante'] == 'SI') {
            $tipoDiscapacidad = $_POST['tipo_discapacidad'];
            $porcentajeDiscapacidad = $_POST['porcentaje_discapacidad'];
            $carnetDiscapacidad = $_POST['carnet_discapacidad'];

            // Insertar datos en la tabla Discapacidad
            $stmtDiscapacidad = $pdo->prepare("INSERT INTO discapacidad (tipo, porcentaje, carnet, id_estudiante) VALUES (?, ?, ?, ?)");
            $stmtDiscapacidad->execute([
                $tipoDiscapacidad,
                $porcentajeDiscapacidad,
                $carnetDiscapacidad,
                $idEstudiante
            ]);
        }

        // Insertar datos en la tabla Persona y Rol para Mamá
        guardarPersonaRol($pdo, 'mama', $idEstudiante);

        // Insertar datos en la tabla Persona y Rol para Papá
        guardarPersonaRol($pdo, 'papa', $idEstudiante);

        // Insertar datos en la tabla Persona y Rol para Representante
        guardarPersonaRol($pdo, 'representante', $idEstudiante);

        $pdo->commit();

        
        exit();
    } catch (Exception $e) {
        $pdo->rollback();
        echo "Error al procesar la matrícula: " . $e->getMessage();
        exit();
    }
}

function guardarPersonaRol($pdo, $rol, $idEstudiante)
{
    $cedulaPersona = $_POST['cedula_' . $rol];
    $apellidosNombresPersona = $_POST['apellidos_nombres_'. $rol];
    $direccionPersona = $_POST['direccion_' . $rol];
    $ocupacionPersona = $_POST['ocupacion_' . $rol];
    $telefonoPersona = $_POST['telefono_' . $rol];
    $correoPersona = $_POST['correo_' . $rol];
    $fotoPersona = 'img_estudiante/' . $rol; // Debes manejar la carga y almacenamiento de la foto

    $stmtPersona = $pdo->prepare("INSERT INTO persona (cedula, apellidos_nombres, direccion, ocupacion, telefono, correo, foto, id_estudiante) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmtPersona->execute([
        $cedulaPersona,
        $apellidosNombresPersona,
        $direccionPersona,
        $ocupacionPersona,
        $telefonoPersona,
        $correoPersona,
        $fotoPersona,
        $idEstudiante
    ]);

    $idPersona = $pdo->lastInsertId();
    $stmtRol = $pdo->prepare("INSERT INTO rol (rol, id_persona) VALUES (?, ?)");
    $stmtRol->execute([$rol, $idPersona]);
}
?>
