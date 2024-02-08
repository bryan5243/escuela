<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include_once '../model/conexion.php';

$id_estudiante = $_POST['id'];

$conn = conectarBaseDeDatos();

$query = "UPDATE estudiante SET estado = 0 WHERE id = :id_estudiante";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_estudiante', $id_estudiante, PDO::PARAM_INT);
$stmt->execute();

$conn = null;
?>