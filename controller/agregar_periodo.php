<?php
session_start();
include_once '../model/conexion.php'; // Reemplaza con la ruta correcta de tu archivo de conexión
$conn = conectarBaseDeDatos();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grado_id = $_POST['grado'];
    $paralelo = $_POST['paralelo'];
    $usuario = $_SESSION['nombre'];

    // Agrega esto para verificar los datos recibidos
    echo "Grado ID: $grado_id, Paralelo: $paralelo, Usuario: $usuario";

    try {
        // Preparar la consulta de inserción
        $sql = "INSERT INTO paralelo (grado_id, paralelo, created_by) VALUES (:grado_id, :paralelo, :usuario);";


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