<?php
include '../model/conexion.php';

$conn = conectarBaseDeDatos();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el valor del periodo enviado desde JavaScript
    $periodoSeleccionado = $_POST["periodo"];

    try {
        // Actualizar el estado en la base de datos
        $sql = "UPDATE periodo SET estado = 0 WHERE id = :periodo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':periodo', $periodoSeleccionado);
        $stmt->execute();

        echo "Culminación exitosa";
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    } finally {
        // Cerrar la conexión
        $conn = null; // o utiliza unset($conn);
    }
} else {
    // Manejar el caso en que la solicitud no sea POST
    echo "Acceso no permitido";
}
?>