<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir el archivo de conexión a la base de datos si no lo has hecho antes
    include_once '../model/conexion.php'; // Reemplaza con la ruta correcta de tu archivo de conexión
    $conn = conectarBaseDeDatos();

    // Asegúrate de que $_SESSION['nombre'] esté definido antes de usarlo
    if (isset($_SESSION['nombre'])) {
        $grado = strtoupper($_POST['grados']);
        $usuario = $_SESSION['nombre']; // Obtener el nombre de usuario de la sesión

        try {
            // Preparar la consulta de inserción
            $stmt = $conn->prepare("INSERT INTO grado (grado, created_by) VALUES (:grado, :usuario)");

            // Bind de los parámetros
            $stmt->bindParam(':grado', $grado);
            $stmt->bindParam(':usuario', $usuario);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                echo "Nuevo grado insertado correctamente";
            } else {
                echo "Error al insertar grado";
            }
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
        } finally {
            // Cerrar conexión
            $conn = null;
        }
    } else {
        echo "La variable de sesión 'nombre' no está definida.";
    }
}
?>