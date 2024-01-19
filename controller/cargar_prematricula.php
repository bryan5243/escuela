<?php
include_once '../model/conexion.php';
if (isset($_POST['id'])) {
    $idEstudiante = $_POST['id'];
    $conn = conectarBaseDeDatos();

    $query = "SELECT
    e.cedula,
    e.apellidos,
    e.nombres,
    e.direccion,
     CASE WHEN e.condicion = 1 THEN 'SI' ELSE 'NO' END AS discapacidad,
     p.cedula as cedula_repre,
     p.apellidos_nombres as apellidos_repre,
    p.telefono as telefono_repre
    FROM estudiante e
    JOIN persona p on e.Id=p.id_estudiante
    JOIN rol r on p.Id=r.id_persona
    WHERE r.rol='Representante' AND e.Id=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $estudiante = $statement->fetch(PDO::FETCH_ASSOC);
    $preestudiante = $estudiante['cedula'];
    $preestudiante = $estudiante['apellidos'];
    $preestudiante = $estudiante['nombres'];
    $preestudiante = $estudiante['direccion'];
    $preestudiante = $estudiante['discapacidad'];
    $prerepre_cedula = $estudiante['cedula_repre'];
    $prerepre_apellidos = $estudiante['apellidos_repre'];
    $prerepre_telefono = $estudiante['telefono_repre'];




    $query = "SELECT
    p.apellidos_nombres,
    p.cedula,
    p.telefono
     FROM persona p
     JOIN estudiante e on e.Id=p.id_estudiante
     JOIN rol r on p.Id=r.id_persona
     WHERE r.rol='Madre' AND e.Id=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $mama = $statement->fetch(PDO::FETCH_ASSOC);
    $datosmama = $mama['apellidos_nombres'];
    $datosmama = $mama['cedula'];
    $datosmama = $mama['telefono'];





    $query = "SELECT
    p.apellidos_nombres,
    p.cedula,
    p.telefono
    FROM persona p
    JOIN estudiante e on e.Id=p.id_estudiante
    JOIN rol r on p.Id=r.id_persona
    WHERE r.rol='Padre' AND e.Id=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $papa = $statement->fetch(PDO::FETCH_ASSOC);
    $datospapa = $papa['apellidos_nombres'];
    $datospapa = $papa['cedula'];
    $datospapa = $papa['telefono'];



    $query = "SELECT
    d.tipo,
    d.porcentaje
    FROM discapacidad d
    JOIN estudiante e on e.id=d.id_estudiante
    WHERE d.id_estudiante=:id;";
    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $discapacidad = $statement->fetch(PDO::FETCH_ASSOC);

    $tipoDiscapacidad = $discapacidad['tipo'];
    $porcentajeDiscapacidad = $discapacidad['porcentaje'];



    $conn = null;



}
try {
    if (isset($_POST["btnregistrarestudiante"])) {


        // Obtener el id del estudiante desde el formulario
        $conn = conectarBaseDeDatos();
        $idEstudiante = $_POST['id'];

        // Actualizar datos en la tabla estudiante
        $cedula_estudiante = $_POST['cedula_estudiante'];
        $apellidos_estudiante = $_POST['apellidos_estudiante'];
        $nombres_estudiante = $_POST['nombres_estudiante'];
        $lugar_nacimiento_estudiante = $_POST['lugar_nacimiento_estudiante'];
        $residencia_estudiante = $_POST['residencia_estudiante'];
        $direccion_estudiante = $_POST['direccion_estudiante'];
        $sector_estudiante = $_POST['sector_estudiante'];
        $fecha_nacimiento_estudiante = $_POST['fecha_nacimiento_estudiante'];
        $id_grado_estudiante = $_POST['grado'];
        $codigo_unico_estudiante = $_POST['codigo_unico_estudiante'];
        $condicion_estudiante = $_POST['condicion_estudiante'];
        $id_paralelo_estudiante = $_POST['id_paralelo_estudiante'];
        $imagePath = $_FILES["imagen"]["tmp_name"];

        $originalImage = imagecreatefromstring(file_get_contents($imagePath));
        $newImage = imagecreatetruecolor(148, 178);
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 148, 178, imagesx($originalImage), imagesy($originalImage));
        // Obtener el contenido de la nueva imagen como un flujo de bytes
        ob_start();
        imagejpeg($newImage, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
        $newImageContent = ob_get_contents();
        ob_end_clean();

        $sql_update_estudiante = "UPDATE estudiante SET
            cedula = :cedula_estudiante,
            apellidos = :apellidos_estudiante,
            nombres = :nombres_estudiante,
            lugar_nacimiento = :lugar_nacimiento_estudiante,
            residencia = :residencia_estudiante,
            direccion = :direccion_estudiante,
            sector = :sector_estudiante,
            fecha_nacimiento = :fecha_nacimiento_estudiante,
            estado = 1,
            id_grado = :id_grado_estudiante,
            codigo_unico = :codigo_unico_estudiante,
            condicion = :condicion_estudiante,
            id_paralelo = :id_paralelo_estudiante";

        $sql_update_estudiante .= ", foto = :foto";

        $sql_update_estudiante .= " WHERE id = :id";

        $stmt_update_estudiante = $conn->prepare($sql_update_estudiante);
        // Vincular parámetros
        $stmt_update_estudiante->bindParam(':cedula_estudiante', $cedula_estudiante);
        $stmt_update_estudiante->bindParam(':apellidos_estudiante', $apellidos_estudiante);
        $stmt_update_estudiante->bindParam(':nombres_estudiante', $nombres_estudiante);
        $stmt_update_estudiante->bindParam(':lugar_nacimiento_estudiante', $lugar_nacimiento_estudiante);
        $stmt_update_estudiante->bindParam(':residencia_estudiante', $residencia_estudiante);
        $stmt_update_estudiante->bindParam(':direccion_estudiante', $direccion_estudiante);
        $stmt_update_estudiante->bindParam(':sector_estudiante', $sector_estudiante);
        $stmt_update_estudiante->bindParam(':fecha_nacimiento_estudiante', $fecha_nacimiento_estudiante);

        $stmt_update_estudiante->bindParam(':id_grado_estudiante', $id_grado_estudiante);
        $stmt_update_estudiante->bindParam(':codigo_unico_estudiante', $codigo_unico_estudiante);
        $stmt_update_estudiante->bindParam(':condicion_estudiante', $condicion_estudiante);
        $stmt_update_estudiante->bindParam(':id_paralelo_estudiante', $id_paralelo_estudiante);
        $stmt_update_estudiante->bindParam(':id', $idEstudiante);

        $stmt_update_estudiante->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
        imagedestroy($originalImage);
        imagedestroy($newImage);

        $stmt_update_estudiante->execute();
        echo "guardado con exito";
        // Confirmar la primera transacción
        $conn->commit();


    }

} catch (Exception $e) {
    //throw $th;
}
