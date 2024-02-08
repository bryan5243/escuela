<?php
// ... (código de conexión y configuración)
include_once '../model/conexion.php';

if (isset($_POST['grado']) && isset($_POST['paralelo'])) {
    $conn = conectarBaseDeDatos();
    $selectedGrado = $_POST['grado'];
    $selectedParalelo = $_POST['paralelo'];

    // Consulta para eliminar el paralelo
    $sql = "DELETE FROM paralelo WHERE id_grados = :selectedGrado AND id = :selectedParalelo";

    try {

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':selectedGrado', $selectedGrado, PDO::PARAM_INT);
        $stmt->bindParam(':selectedParalelo', $selectedParalelo, PDO::PARAM_INT);
        $stmt->execute();

        // Puedes devolver algún mensaje si es necesario
        echo "Paralelo eliminado correctamente";
    } catch (PDOException $e) {
        // Puedes devolver algún mensaje de error
        echo "Error al eliminar el paralelo: " . $e->getMessage();
    }
} else {
    // Devuelve un mensaje si los parámetros no están presentes
    echo "Parámetros de grado y paralelo no proporcionados";
}
?>