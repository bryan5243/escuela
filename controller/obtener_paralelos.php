<?php
include_once "../model/conexion.php";

if (isset($_GET['grado'])) {
    $conn = conectarBaseDeDatos();
    $selectedGrado = $_GET['grado'];

    // Consulta para obtener los paralelos según el grado seleccionado
    $sql = "SELECT p.id, p.paralelo
            FROM paralelo p 
            JOIN grado g ON g.id=p.id_grados
            WHERE g.id = :selectedGrado";  // Se filtra por el grado seleccionado

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':selectedGrado', $selectedGrado, PDO::PARAM_INT);
        
        $stmt->execute();

        // Obtener directamente el array de paralelos
        $paralelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Indicar que el contenido es JSON
        header('Content-Type: application/json');

        // Devolver los datos en formato JSON
        echo json_encode($paralelos);
    } catch (PDOException $e) {
        // Imprimir mensaje de error detallado
        echo json_encode(['error' => 'Error al ejecutar la consulta: ' . $e->getMessage()]);
    }
}
?>
