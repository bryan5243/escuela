<?php
session_start(); // Inicia la sesión

include_once '../model/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $grado_id = $_POST['grado'];
    $paralelo = $_POST['paralelo'];
    $usuario = $_SESSION['nombre'];

    $conn = conectarBaseDeDatos();

    try {
        // Realiza la inserción en la base de datos
        $sql = "INSERT INTO paralelo (id_grados, paralelo, created_by) VALUES (:grado_id, :paralelo, :usuario)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':grado_id', $grado_id);
        $stmt->bindParam(':paralelo', $paralelo);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        // Asegúrate de que la respuesta sea un JSON válido
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit();
    } catch (PDOException $e) {
        // Maneja cualquier error de la base de datos
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        exit();
    }
}

$conn = null;
?>