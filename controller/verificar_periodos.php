<?php
include_once '../model/conexion.php';
$conn = conectarBaseDeDatos();
// Consulta SQL para obtener todos los periodos
$sql = "SELECT estado FROM periodo";

// Ejecutar la consulta
$stmt = $conn->query($sql);

// Obtener los resultados como un array de objetos
$periodos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Convertir el array a formato JSON y enviarlo como respuesta
echo json_encode($periodos);

// Cerrar la conexión
$conn = null;
?>