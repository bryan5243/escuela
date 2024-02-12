<?php
include_once '../model/conexion.php';

if (isset($_REQUEST['id'])) {
    $estudianteId = $_REQUEST['id'];
    $conn = conectarBaseDeDatos();

    $query = "SELECT DISTINCT
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
        m.id_paralelo = p.id AND e.Id = :id;";
    
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $estudianteId);
    $statement->execute();

    $estudiante = $statement->fetch(PDO::FETCH_ASSOC);

    // Devolver la información en formato JSON
    header('Content-Type: application/json');
    echo json_encode($estudiante);

    $conn = null;
} else {
    // Manejar el caso en que no se proporciona el ID del estudiante
    header('Content-Type: application/json');
    echo json_encode(array('error' => 'ID del estudiante no proporcionado'));
}
?>
