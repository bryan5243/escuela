<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include_once '../model/conexion.php';
    $conn = conectarBaseDeDatos();

    $grado = strtoupper($_POST['grado']);

    try {
        $stmt = $conn->prepare("DELETE FROM grado WHERE id=:grado");
        $stmt->bindParam(':grado', $grado);

        if ($stmt->execute()) {
            echo "Grado eliminado correctamente";
        } else {
            echo "Error al eliminar grado";
        }
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    } finally {
        if (isset($conn)) {
            $conn = null;
        }
    }
}
?>