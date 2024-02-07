<?php
include_once '../model/conexion.php';
$conn = conectarBaseDeDatos();

// Obtener el valor de la cédula desde la solicitud POST
$cedula = $_POST['cedula'];

// Consulta preparada para obtener sugerencias de la base de datos
$query = "SELECT DISTINCT e.cedula, e.nombres, e.apellidos 
FROM estudiante e 
JOIN matricula m ON e.Id = m.id_estudiante
LEFT JOIN responsables r ON r.id_estudiante = e.Id
WHERE e.cedula LIKE :cedula AND m.id_estudiante IS NOT NULL AND r.id_estudiante IS NULL;";
$statement = $conn->prepare($query);
$statement->bindValue(':cedula', "$cedula%", PDO::PARAM_STR);
$statement->execute();

// Obtener resultados de la consulta
$resultados = $statement->fetchAll(PDO::FETCH_ASSOC);

// Imprimir las sugerencias
foreach ($resultados as $sugerencia) {
    $cedula = $sugerencia['cedula'];
    $nombre = $sugerencia['nombres'];
    $apellido = $sugerencia['apellidos'];

    echo "<p style='margin-bottom:10px'><a href='#' onclick='cargarCedula(\"$cedula\");'> $cedula $nombre  $apellido</a></p>";
}

// Cerrar la conexión
$conn = null;
?>