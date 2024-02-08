<?php
include_once '../model/conexion.php';
// Archivo: obtener_datos_responsables.php
$idEstudiante = $_GET['id'];
$conn = conectarBaseDeDatos();

$query = "SELECT
    r.id as id_responsable,
    r.nombre,
    r.telefono,
    r.parentesco,
    r.foto
    FROM responsables r
    JOIN estudiante e on e.Id=r.id_estudiante
    WHERE e.Id= :id";

$statement = $conn->prepare($query);
$statement->bindParam(':id', $idEstudiante);
$statement->execute();
$responsablesArray = array();

while ($responsables = $statement->fetch(PDO::FETCH_ASSOC)) {
    $responsablesArray[] = $responsables;
}

// Devolver los datos en formato JSON
echo json_encode($responsablesArray);
