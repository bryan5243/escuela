<?php
if (isset($_POST['id'])) {
    $idEstudiante = $_POST['id'];
    $conn = conectarBaseDeDatos();

    $query = "SELECT
    e.cedula,
    e.apellidos,
    e.nombres,
    e.direccion,
     CASE WHEN e.condicion = 1 THEN 'SI' ELSE 'NO' END AS discapacidad,
     p.cedula as cedula_repre,
     p.apellidos_nombres as apellidos_repre,
    p.telefono as telefono_repre
    FROM estudiante e
    JOIN persona p on e.Id=p.id_estudiante
    JOIN rol r on p.Id=r.id_persona
    WHERE r.rol='representante' AND e.Id=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $estudiante = $statement->fetch(PDO::FETCH_ASSOC);
    $preestudiante = $estudiante['cedula'];
    $preestudiante = $estudiante['apellidos'];
    $preestudiante = $estudiante['nombres'];
    $preestudiante = $estudiante['direccion'];
    $preestudiante = $estudiante['discapacidad'];
    $prerepre_cedula = $estudiante['cedula_repre'];
    $prerepre_apellidos = $estudiante['apellidos_repre'];
    $prerepre_telefono = $estudiante['telefono_repre'];




    $query = "SELECT
    p.apellidos_nombres,
    p.cedula,
    p.telefono
     FROM persona p
     JOIN estudiante e on e.Id=p.id_estudiante
     JOIN rol r on p.Id=r.id_persona
     WHERE r.rol='mama' AND e.Id=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $mama = $statement->fetch(PDO::FETCH_ASSOC);
    $datosmama = $mama['apellidos_nombres'];
    $datosmama = $mama['cedula'];
    $datosmama = $mama['telefono'];





    $query = "SELECT
    p.apellidos_nombres,
    p.cedula,
    p.telefono
     FROM persona p
     JOIN estudiante e on e.Id=p.id_estudiante
     JOIN rol r on p.Id=r.id_persona
     WHERE r.rol='papa' AND e.Id=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $papa = $statement->fetch(PDO::FETCH_ASSOC);
    $datospapa = $papa['apellidos_nombres'];
    $datospapa = $papa['cedula'];
    $datospapa = $papa['telefono'];






}