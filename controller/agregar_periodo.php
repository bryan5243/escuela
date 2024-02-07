<?php
session_start();
include_once '../model/conexion.php'; // Reemplaza con la ruta correcta de tu archivo de conexión
$conn = conectarBaseDeDatos();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $periodos = $_POST['periodos']; // Debes usar 'periodos' en lugar de 'grado' para obtener el valor correcto
    $usuario = $_SESSION['nombre'];

    // Agrega esto para verificar los datos recibidos
    if (empty($periodos)) {
        echo "Por favor, ingresa un valor en el campo de periodos.";
        exit;
    }
    try {
        // Preparar la consulta de inserción
        $sql = "INSERT INTO periodo (estado,periodo, created_by) VALUES (1,:periodos, :usuario);";

        $stmt = $conn->prepare($sql);

        // Bind de los parámetros
        $stmt->bindParam(':periodos', $periodos);
        $stmt->bindParam(':usuario', $usuario);

        // Ejecutar la consulta
        if ($stmt->execute()) {
            echo "Nuevo periodo insertado correctamente";
        } else {
            echo "Error al insertar periodo";
        }
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    } finally {
        // Cerrar conexión
        $conn = null;
    }
}
?>