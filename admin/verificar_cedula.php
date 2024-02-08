<?php
// ... (código de conexión y configuración)
include_once '../model/conexion.php';

$conn = conectarBaseDeDatos();

// Obtener la cédula desde la solicitud POST
$cedula = $_POST['cedula'];

// Consultar la base de datos
$sql = "SELECT id FROM estudiante WHERE cedula = :cedula";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':cedula', $cedula);
$stmt->execute();

// Verificar si la cédula ya existe
if ($stmt->rowCount() > 0) {
    echo "existente";
} else {
    echo "no_existente";
}
$conn = null;
