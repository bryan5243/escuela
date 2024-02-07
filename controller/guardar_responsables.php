<?php
include_once '../model/conexion.php';

try {

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {



        $cedulaEstudiante = $_POST['cedulaEstudiante'];

        $conn = conectarBaseDeDatos();

        $sql0 = "SELECT id FROM estudiante WHERE cedula = :cedula";
        $statement0 = $conn->prepare($sql0);
        $statement0->bindParam(':cedula', $cedulaEstudiante);
        $statement0->execute();
        // Obtener el resultado
        $resultado = $statement0->fetch(PDO::FETCH_ASSOC);

        // Acceder al ID
        $idEstudiante = $resultado['id'];

        // Iniciar transacción
        $conn->beginTransaction();

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
            // Agregar vinculación para :foto
            $statement1->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
            $statement1->execute();

            // Liberar recursos de la imagen
            imagedestroy($originalImage);
            imagedestroy($newImage);
        }

        // Confirmar transacción
        $conn->commit();

        $conn->beginTransaction();

        $traslado = $_POST['traslado'];
        $transporte = $_POST['transporte'];
        $conductor = $_POST['nombres_conductor'];
        $telefono_conductor = $_POST['telefono_conductor'];

        // Insertar traslado
        $sql2 = "INSERT INTO traslado (traslado, transporte, conductor, telefono_conductor, id_estudiante) VALUES (:traslado, :transporte, :conductor, :telefono_conductor, :id_estudiante)";
        $statement2 = $conn->prepare($sql2);
        $statement2->bindParam(':traslado', $traslado);
        $statement2->bindParam(':transporte', $transporte); // Corregir aquí
        $statement2->bindParam(':conductor', $conductor);
        $statement2->bindParam(':telefono_conductor', $telefono_conductor);
        $statement2->bindParam(':id_estudiante', $idEstudiante);
        $statement2->execute();

        $conn->commit();


        echo '<script>
        Swal.fire({
            title: "Éxito",
            text: "Los datos se han guardado correctamente.",
            icon: "success",
            confirmButtonText: "Aceptar",
            showCancelButton: false
        }).then((result) => {
            // Redirige a la página después de hacer clic en "Aceptar y redirigir"
            if (result.isConfirmed) {
                window.location.href = "../administracion/listado_estudiantes.php"; // Reemplaza con la URL de tu página destino
            }
        });
    </script>';
    }
} catch (Exception $e) {
    // Manejar errores y revertir transacción si es necesario
    $conn->rollBack();
    echo "Error: " . $e->getMessage();
}
$conn = null;
