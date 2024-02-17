<?php
include_once '../model/conexion.php';

// Recibir datos del cuerpo de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Realizar la actualización en la base de datos
// Aquí deberías usar tu lógica para actualizar la fecha en la tabla de estudiantes

// Ejemplo básico de conexión y actualización usando PDO
$estudianteId = $data['estudianteId'];
$nuevaFecha = $data['nuevaFecha'];
$conn = conectarBaseDeDatos(); // Asegúrate de que esta función devuelve una instancia de PDO

try {
    $sql = "UPDATE matricula SET created_at = ? WHERE id_estudiante = ? ORDER BY created_at DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $nuevaFecha);
    $stmt->bindParam(2, $estudianteId);
    $stmt->execute();
    $stmt->closeCursor();

    // Enviar una respuesta al cliente (puede ser un JSON indicando éxito)
    echo json_encode(['status' => 'success']);
} catch (PDOException $e) {
    // Enviar una respuesta al cliente en caso de error
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
} finally {
    // Cerrar la conexión
    $conn = null;
}
?>
