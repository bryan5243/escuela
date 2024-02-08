<?php
include_once '../model/conexion.php';

$cedula = '';  // Definir la variable $cedula con un valor predeterminado

if (isset($_POST['id'])) {
    $idEstudiante = $_POST['id'];
    $conn = conectarBaseDeDatos();

    $query1 = "SELECT cedula FROM estudiante WHERE id = :id";
    $statement1 = $conn->prepare($query1);
    $statement1->bindParam(':id', $idEstudiante);
    $statement1->execute();
    $estudiante = $statement1->fetch(PDO::FETCH_ASSOC);

    // Verificar si $estudiante no es nulo antes de acceder a sus valores
    $cedula = $estudiante['cedula'];



    $query = "SELECT
    r.id as id_responsable,
        r.nombre,
        r.telefono,
        r.parentesco,
        r.telefono,
        r.foto
        FROM responsables r
        JOIN estudiante e on e.Id=r.id_estudiante
        WHERE e.Id= :id";

    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();
    $responsablesArray = array();

    while ($responsables = $statement->fetch(PDO::FETCH_ASSOC)) {
        // Almacena cada conjunto de datos en el arreglo asociativo
        $responsablesArray[] = $responsables;
    }

    // Ahora $responsablesArray contiene los datos de los tres responsables en índices separados

    // Puedes acceder a los datos individualmente, por ejemplo:
    $responsable1 = $responsablesArray[0];
    $responsable2 = $responsablesArray[1];
    $responsable3 = $responsablesArray[2];

    // Luego, puedes acceder a los datos de cada responsable de la siguiente manera:
    $idResponsable1 = $responsable1['id_responsable'];
    $nombre1 = $responsable1['nombre'];
    $telefono1 = $responsable1['telefono'];
    $parentesco1 = $responsable1['parentesco'];
    $imagen1 = $responsable1['foto'];

    if ($imagen1) {
        $imageData1 = base64_encode($imagen1);
        $imageSrc1 = "data:image/png;base64," . $imageData1;
    } else {
        echo "No se encontró la imagen del responsable 1";
    }


    $idResponsable2 = $responsable2['id_responsable'];

    $nombre2 = $responsable2['nombre'];
    $telefono2 = $responsable2['telefono'];
    $parentesco2 = $responsable2['parentesco'];
    $imagen2 = $responsable2['foto'];

    if ($imagen2) {
        $imageData2 = base64_encode($imagen2);
        $imageSrc2 = "data:image/png;base64," . $imageData2;
    } else {
        echo "No se encontró la imagen del responsable 2";
    }
    $idResponsable3 = $responsable3['id_responsable'];

    $nombre3 = $responsable3['nombre'];
    $telefono3 = $responsable3['telefono'];
    $parentesco3 = $responsable3['parentesco'];
    $imagen3 = $responsable3['foto'];

    if ($imagen3) {
        $imageData3 = base64_encode($imagen3);
        $imageSrc3 = "data:image/png;base64," . $imageData3;
    } else {
        echo "No se encontró la imagen del responsable 3";
    }




    $query2 = "SELECT
    t.traslado,
    t.transporte,
    t.conductor,
    t.telefono_conductor
    FROM traslado t
    JOIN estudiante e on e.Id=t.id_estudiante
    WHERE e.id = :id";
    $statement2 = $conn->prepare($query2);
    $statement2->bindParam(':id', $idEstudiante);
    $statement2->execute();

    $traslado = $statement2->fetch(PDO::FETCH_ASSOC);

    // Verificar si $estudiante no es nulo antes de acceder a sus valores
    $traslado_estudiante = $traslado['traslado'];
    $transporte = $traslado['transporte'];
    $conductor = $traslado['conductor'];
    $telefono_conductor = $traslado['telefono_conductor'];


    $conn = null;
}

try {
    if (isset($_POST["btnactualizarestudianteres"])) {

        try {

            // Obtener el id del estudiante desde el formulario
            $conn = conectarBaseDeDatos();
            $idEstudiante = $_POST['id'];

            $conn->beginTransaction();

            $nombre1 = $_POST['apellidos_nombres1'];
            $telefono1 =  $_POST['telefono1'];
            $parentesco1 =  $_POST['parentesco1'];
            $idResponsable1 = $_POST['id1']; // Asegúrate de tener un campo id1 en tu formulario


            // Verificar si se ha cargado una nueva imagen
            if (!empty($_FILES['imagen1']['tmp_name'])) {
                // Obtener la ruta temporal de la imagen subida
                $imagePath1 = $_FILES['imagen1']['tmp_name'];

                // Crear una nueva imagen a partir de la original
                $originalImage1 = imagecreatefromstring(file_get_contents($imagePath1));
                $newImage1 = imagecreatetruecolor(148, 178);

                // Redimensionar la imagen a la nueva resolución
                imagecopyresampled($newImage1, $originalImage1, 0, 0, 0, 0, 148, 178, imagesx($originalImage1), imagesy($originalImage1));

                // Obtener el contenido de la nueva imagen como un flujo de bytes
                ob_start();
                imagejpeg($newImage1, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
                $newImageContent1 = ob_get_contents();
                ob_end_clean();
            }

            $sql_update_responsable1 = "UPDATE responsables SET
            nombre = :nombre,
            telefono = :telefono,
            parentesco = :parentesco";

            if (!empty($_FILES['imagen1']['tmp_name'])) {
                $sql_update_responsable1 .= ", foto = :foto";
            }
            // Conservar la foto existente
            $sql_update_responsable1 .= " WHERE id_estudiante = :id AND  id= :idResponsable1";


            $sql_update_responsable1 = $conn->prepare($sql_update_responsable1);
            // Vincular parámetros
            $sql_update_responsable1->bindParam(':nombre', $nombre1);
            $sql_update_responsable1->bindParam(':telefono', $telefono1);
            $sql_update_responsable1->bindParam(':parentesco', $parentesco1);
            $sql_update_responsable1->bindParam(':id', $idEstudiante);
            $sql_update_responsable1->bindParam(':idResponsable1',  $idResponsable1);


            if (!empty($_FILES['imagen1']['tmp_name'])) {
                $sql_update_responsable1->bindParam(':foto', $newImageContent1, PDO::PARAM_LOB);
                imagedestroy($originalImage1);
                imagedestroy($newImage1);
            }
            $sql_update_responsable1->execute();
            // Confirmar la primera transacción
            $conn->commit();





            $conn->beginTransaction();

            $nombre2 = $_POST['apellidos_nombres2'];
            $telefono2 =  $_POST['telefono2'];
            $parentesco2 =  $_POST['parentesco2'];
            $idResponsable2 = $_POST['id2']; // Asegúrate de tener un campo id1 en tu formulario


            // Verificar si se ha cargado una nueva imagen
            if (!empty($_FILES['imagen2']['tmp_name'])) {
                // Obtener la ruta temporal de la imagen subida
                $imagePath2 = $_FILES['imagen2']['tmp_name'];

                // Crear una nueva imagen a partir de la original
                $originalImage2 = imagecreatefromstring(file_get_contents($imagePath2));
                $newImage2 = imagecreatetruecolor(148, 178);

                // Redimensionar la imagen a la nueva resolución
                imagecopyresampled($newImage2, $originalImage2, 0, 0, 0, 0, 148, 178, imagesx($originalImage2), imagesy($originalImage2));

                // Obtener el contenido de la nueva imagen como un flujo de bytes
                ob_start();
                imagejpeg($newImage2, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
                $newImageContent2 = ob_get_contents();
                ob_end_clean();
            }

            $sql_update_responsable2 = "UPDATE responsables SET
            nombre = :nombre,
            telefono = :telefono,
            parentesco = :parentesco";

            if (!empty($_FILES['imagen2']['tmp_name'])) {
                $sql_update_responsable2 .= ", foto = :foto";
            }
            // Conservar la foto existente
            $sql_update_responsable2 .= " WHERE id_estudiante= :id AND  id= :idResponsable2";


            $sql_update_responsable2 = $conn->prepare($sql_update_responsable2);
            // Vincular parámetros
            $sql_update_responsable2->bindParam(':nombre', $nombre2);
            $sql_update_responsable2->bindParam(':telefono', $telefono2);
            $sql_update_responsable2->bindParam(':parentesco', $parentesco2);
            $sql_update_responsable2->bindParam(':id', $idEstudiante);
            $sql_update_responsable2->bindParam(':idResponsable2',  $idResponsable2);


            if (!empty($_FILES['imagen2']['tmp_name'])) {
                $sql_update_responsable2->bindParam(':foto', $newImageContent2, PDO::PARAM_LOB);
                imagedestroy($originalImage2);
                imagedestroy($newImage2);
            }
            $sql_update_responsable2->execute();
            // Confirmar la primera transacción
            $conn->commit();





            $conn->beginTransaction();

            $nombre3 = $_POST['apellidos_nombres3'];
            $telefono3 =  $_POST['telefono3'];
            $parentesco3 =  $_POST['parentesco3'];
            $idResponsable3 = $_POST['id3']; // Asegúrate de tener un campo id3 en tu formulario


            // Verificar si se ha cargado una nueva imagen
            if (!empty($_FILES['imagen3']['tmp_name'])) {
                // Obtener la ruta temporal de la imagen subida
                $imagePath3 = $_FILES['imagen3']['tmp_name'];

                // Crear una nueva imagen a partir de la original
                $originalImage3 = imagecreatefromstring(file_get_contents($imagePath3));
                $newImage3 = imagecreatetruecolor(148, 178);

                // Redimensionar la imagen a la nueva resolución
                imagecopyresampled($newImage3, $originalImage3, 0, 0, 0, 0, 148, 178, imagesx($originalImage3), imagesy($originalImage3));

                // Obtener el contenido de la nueva imagen como un flujo de bytes
                ob_start();
                imagejpeg($newImage3, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
                $newImageContent3 = ob_get_contents();
                ob_end_clean();
            }

            $sql_update_responsable3 = "UPDATE responsables SET
            nombre = :nombre,
            telefono = :telefono,
            parentesco = :parentesco";

            if (!empty($_FILES['imagen3']['tmp_name'])) {
                $sql_update_responsable3 .= ", foto = :foto";
            }
            // Conservar la foto existente
            $sql_update_responsable3 .= " WHERE id_estudiante = :id AND  id= :idResponsable3";


            $sql_update_responsable3 = $conn->prepare($sql_update_responsable3);
            // Vincular parámetros
            $sql_update_responsable3->bindParam(':nombre', $nombre3);
            $sql_update_responsable3->bindParam(':telefono', $telefono3);
            $sql_update_responsable3->bindParam(':parentesco', $parentesco3);
            $sql_update_responsable3->bindParam(':id', $idEstudiante);
            $sql_update_responsable3->bindParam(':idResponsable3',  $idResponsable3);


            if (!empty($_FILES['imagen3']['tmp_name'])) {
                $sql_update_responsable3->bindParam(':foto', $newImageContent3, PDO::PARAM_LOB);
                imagedestroy($originalImage3);
                imagedestroy($newImage3);
            }
            $sql_update_responsable3->execute();
            // Confirmar la primera transacción
            $conn->commit();



            $conn->beginTransaction();

            $traslado = $_POST['traslado'];
            $transporte =  $_POST['transporte'];
            $nombre_conductor =  $_POST['nombres_conductor'];
            $telefono_conductor = $_POST['telefono_conductor']; // Asegúrate de tener un campo id3 en tu formulario

            $sql_update_translado = "UPDATE traslado SET
            traslado = :traslado,
            transporte = :transporte,
            conductor = :nombre_conductor,
            telefono_conductor = :telefono_conductor  where id_estudiante = :id";


           $sql_update_translado = $conn->prepare($sql_update_translado);
            // Vincular parámetros
            $sql_update_translado->bindParam(':traslado', $traslado);
            $sql_update_translado->bindParam(':transporte', $transporte);
            $sql_update_translado->bindParam(':nombre_conductor', $nombre_conductor );
            $sql_update_translado->bindParam(':telefono_conductor',   $telefono_conductor);
            $sql_update_translado->bindParam(':id', $idEstudiante);
            
            $sql_update_translado->execute();

            $conn->commit();

        } catch (PDOException $e) {
            // Retrocede en caso de un error
            $conn->rollBack();
        }














        echo '<script>
        Swal.fire({
            title: "Éxito",
            text: "Los datos se han actualizado correctamente.",
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
}
