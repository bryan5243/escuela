<?php
// Conexión a la base de datos y otras configuraciones necesarias
include_once "../model/conexion.php";  // Asegúrate de incluir el archivo de conexión si no lo has hecho

// ... (código de conexión y configuración)

if (isset($_GET['grado'])) {
    $conn = conectarBaseDeDatos();
    $selectedGrado = $_GET['grado'];

    // Consulta para obtener los paralelos según el grado seleccionado
    $sql = "SELECT id, paralelo FROM paralelo WHERE id_grado = :selectedGrado";

    try {
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':selectedGrado', $selectedGrado, PDO::PARAM_INT);
        $stmt->execute();

        // Construir un array con los datos
        $paralelos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los datos en formato JSON
        echo json_encode($paralelos);
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al ejecutar la consulta']);
    }
}

?>