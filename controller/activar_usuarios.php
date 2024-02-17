<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include_once '../model/conexion.php';

$id_usuarios = $_POST['id'];

$conn = conectarBaseDeDatos();

$query = "UPDATE usuarios SET estado = 1 WHERE id = :id_usuarios";
$stmt = $conn->prepare($query);
$stmt->bindParam(':id_usuarios', $id_usuarios, PDO::PARAM_INT);
$stmt->execute();

$conn = null;
?>