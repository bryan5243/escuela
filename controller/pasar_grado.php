<?php
include_once '../model/conexion.php';
$estudianteId = $_REQUEST['id'];
$conn = conectarBaseDeDatos();

$query = "SELECT DISTINCT
m.id_estudiante,
m.id_paralelo,
m.id_grado,
    g.grado,
    p.paralelo
FROM
    matricula m 
JOIN
    estudiante e ON m.id_estudiante = e.Id
JOIN
    grado g ON g.id = m.id_grado
JOIN
    paralelo p ON p.id_grados = g.id
WHERE
    m.id_paralelo = p.id AND e.Id =:id
    ORDER BY
        m.created_at DESC
    LIMIT 1;";

$statement = $conn->prepare($query);
$statement->bindParam(':id', $estudianteId);
$statement->execute();

$estudiante = $statement->fetch(PDO::FETCH_ASSOC);
$id_paralelo = $estudiante['id_paralelo'];
$id_grado = $estudiante['id_grado'];
$idEstudiante = $estudiante['id_estudiante'];

$grado = $estudiante['grado'];
$paralelo = $estudiante['paralelo'];

// Al final de tu archivo pasar_grado.php
echo json_encode(['grado' => $grado, 'paralelo' => $paralelo, 'id_grado' => $id_grado, 'id_paralelo' => $id_paralelo]);
