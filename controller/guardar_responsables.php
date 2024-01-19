<?php
include_once '../model/conexion.php';

try {
    if (isset($_POST["btnregistrar"])) {
        $cedulaEstudiante = $_POST['cedulaEstudiante'];

        $conn = conectarBaseDeDatos();

        // Iniciar transacción
        $conn->beginTransaction();

        // Obtener el ID del estudiante
        $sql = "SELECT id FROM estudiante WHERE cedula = :cedula";
        $statement = $conn->prepare($sql);
        $statement->bindParam(':cedula', $cedulaEstudiante);
        $statement->execute();
        $idEstudiante = $statement->fetchColumn();

        // Insertar responsables
        $sql1 = "INSERT INTO responsables (nombre, telefono, parentesco, id_estudiante, foto) VALUES (:nombre, :telefono, :parentesco, :id_estudiante, :foto)";
        $statement1 = $conn->prepare($sql1);

        for ($i = 1; $i <= 3; $i++) {
            $nombre = $_POST["apellidos_nombres$i"];
            $telefono = $_POST["telefono$i"];
            $parentesco = $_POST["parentesco$i"];
            $imagePath = $_FILES["imagen$i"]["tmp_name"];

            $originalImage = imagecreatefromstring(file_get_contents($imagePath));
            $newImage = imagecreatetruecolor(148, 178);
            imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 148, 178, imagesx($originalImage), imagesy($originalImage));
            // Obtener el contenido de la nueva imagen como un flujo de bytes
            ob_start();
            imagejpeg($newImage, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
            $newImageContent = ob_get_contents();
            ob_end_clean();
            // Resto del código...

            $statement1->bindParam(':nombre', $nombre);
            $statement1->bindParam(':telefono', $telefono);
            $statement1->bindParam(':parentesco', $parentesco);
            $statement1->bindParam(':id_estudiante', $idEstudiante);
            $statement1->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
            $statement1->execute();
        }

        // Confirmar transacción
        $conn->commit();

        echo "Guardado con éxito";
        imagedestroy($originalImage);
        imagedestroy($newImage);
        $conn = null;
    }
} catch (Exception $e) {
    // Manejar errores y revertir transacción si es necesario
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
?>