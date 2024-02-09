<?php
$idEstudiante = $_POST['id'];
$conn = conectarBaseDeDatos();

$query1 = "SELECT cedula FROM estudiante WHERE id = :id";
$statement1 = $conn->prepare($query1);
$statement1->bindParam(':id', $idEstudiante);
$statement1->execute();
$estudiante = $statement1->fetch(PDO::FETCH_ASSOC);

// Verificar si $estudiante no es nulo antes de acceder a sus valores
$cedula = $estudiante['cedula'];

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

// Devolver los datos como JSON
echo json_encode($responsablesArray);
http_response_code(500);
echo json_encode(array('error' => 'Error al cargar los datos del responsable: ' . $e->getMessage()));
