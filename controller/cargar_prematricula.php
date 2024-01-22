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
     CASE WHEN e.condicion = 1 THEN 'SI' ELSE 'NO' END AS discapacidades,
     p.id,
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
    $preestudiante_cedula = $estudiante['cedula'];
    $preestudiante_apellidos = $estudiante['apellidos'];
    $preestudiante_nombres = $estudiante['nombres'];
    $preestudiante_direccion = $estudiante['direccion'];
    $preestudiante_discapacidad = $estudiante['discapacidades'];
    $prerepre_cedula = $estudiante['cedula_repre'];
    $prerepre_apellidos = $estudiante['apellidos_repre'];
    $prerepre_telefono = $estudiante['telefono_repre'];
    $prerepre_id = $estudiante['id'];


    $tipoDiscapacidad = ''; // Inicializamos las variables fuera del bloque de condición
    $porcentajeDiscapacidad = '';

    if ($estudiante['discapacidades'] == 'SI') {
        $query = "SELECT
    d.tipo,
    d.porcentaje
  FROM discapacidad d
  JOIN estudiante e on e.id = d.id_estudiante
  WHERE d.id_estudiante = :id AND e.condicion = 1;";


        $statement = $conn->prepare($query);
        $statement->bindParam(':id', $idEstudiante);
        $statement->execute();

        $discapacidad = $statement->fetch(PDO::FETCH_ASSOC);

        $tipoDiscapacidad = $discapacidad['tipo'];
        $porcentajeDiscapacidad = $discapacidad['porcentaje'];

    }






    $query = "SELECT
    p.id,
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
    $mama_apellidos = $mama['apellidos_nombres'];
    $mama_cedula = $mama['cedula'];
    $mama_telefono = $mama['telefono'];
    $idMama = $mama['id'];





    $query = "SELECT
    p.id,
    p.apellidos_nombres,
    p.cedula,
    p.telefono,
    r.id_persona as id_papa
    FROM persona p
    JOIN estudiante e on e.Id = p.id_estudiante
    JOIN rol r on p.Id = r.id_persona
    WHERE r.rol = 'Padre' AND e.Id = :id;";

    $statement = $conn->prepare($query);
    $statement->bindParam(':id', $idEstudiante);
    $statement->execute();

    $papa = $statement->fetch(PDO::FETCH_ASSOC);

    $datospapa = $papa['apellidos_nombres'];
    $cedulaPapa = $papa['cedula'];
    $telefonoPapa = $papa['telefono'];
    $idPapa = $papa['id'];





    $conn = null;



}
$conn = null;
try {
    if (isset($_POST["btnregistrarestudiante"])) {


        // Obtener el id del estudiante desde el formulario
        $conn = conectarBaseDeDatos();
        $idEstudiante = $_POST['id'];
        $conn->beginTransaction();
        $usuario = $_SESSION['nombre'];

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
            id_paralelo = :id_paralelo_estudiante,
            created_by = :usuario";

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
        $stmt_update_estudiante->bindParam(':usuario', $usuario);


        $stmt_update_estudiante->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
        imagedestroy($originalImage);
        imagedestroy($newImage);

        $stmt_update_estudiante->execute();
        echo "guardado con exito";
        // Confirmar la primera transacción
        $conn->commit();



        $conn->beginTransaction();
        // Obtener el ID del periodo cuyo estado sea 1
        $idPeriodo = $conn->query("SELECT id FROM periodo WHERE estado = 1")->fetch(PDO::FETCH_ASSOC)['id'];

        // Obtener el último número de matrícula
        $ultimoNumeroMatricula = $conn->query("SELECT MAX(numero) as ultimo_numero FROM matricula")->fetch(PDO::FETCH_ASSOC)['ultimo_numero'];

        // Incrementar el número de matrícula
        $nuevoNumeroMatricula = $ultimoNumeroMatricula + 1;

        // Preparar la consulta de inserción
        $matricula = "INSERT INTO matricula (numero, id_estudiante, id_periodo) VALUES (:numeroMatricula, :id, :idPeriodo)";
        $statement_matricula = $conn->prepare($matricula);

        // Asignar valores a los parámetros
        $statement_matricula->bindParam(':numeroMatricula', $nuevoNumeroMatricula);
        $statement_matricula->bindParam(':id', $idEstudiante);
        $statement_matricula->bindParam(':idPeriodo', $idPeriodo);

        // Ejecutar la consulta
        $statement_matricula->execute();
        $conn->commit();
        echo "El matricula exitosa.";

        //discapacidad



        if ($condicion_estudiante == 1) {
            $conn->beginTransaction();

            $tipo_discapacidad = $_POST['tipo_discapacidad'];
            $porcentaje_discapacidad = $_POST['porcentaje_discapacidad'];
            $carnet_discapacidad = $_POST['carnet_discapacidad'];

            // Preparar la consulta de inserción en la tabla discapacidad
            $sql_update_discapacidad = "UPDATE discapacidad set
             tipo = :tipo_discapacidad,
             porcentaje = :porcentaje_discapacidad,
             carnet = :carnet_discapacidad
             where id_estudiante =:id";
            $stmt_discapacidad = $conn->prepare($sql_update_discapacidad);


            $stmt_update_discapacidad->bindParam(':tipo_discapacidad', $tipo_discapacidad);
            $stmt_update_discapacidad->bindParam(':porcentaje_discapacidad', $porcentaje_discapacidad);
            $stmt_update_discapacidad->bindParam(':carnet_discapacidad', $carnet_discapacidad);
            $stmt_update_discapacidad->bindParam(':id', $idEstudiante);

            // Ejecutar la consulta
            $stmt_update_discapacidad->execute();
            $conn->commit();
            echo "condicion actualizada";
        }

        try {
            $conn->beginTransaction();

            $cedula_padre = $_POST['cedula_papa'];
            $apellidos_nombres_padre = $_POST['apellidos_nombres_papa'];
            $direccion_padre = $_POST['direccion_papa'];
            $ocupacion_padre = $_POST['ocupacion_papa'];
            $telefono_padre = $_POST['telefono_papa'];
            $correo_padre = $_POST['correo_papa'];

            // Procesar los datos para el padre
            $imagePathPadre = $_FILES['imagen_papa']["tmp_name"];
            $originalImagePadre = imagecreatefromstring(file_get_contents($imagePathPadre));
            $newImagePadre = imagecreatetruecolor(148, 178);
            imagecopyresampled($newImagePadre, $originalImagePadre, 0, 0, 0, 0, 148, 178, imagesx($originalImagePadre), imagesy($originalImagePadre));

            ob_start();
            imagejpeg($newImagePadre, NULL, 100);
            $newImageContentPadre = ob_get_contents();
            ob_end_clean();

            $sql_update_padre = "UPDATE persona SET
            cedula = :cedula_padre,
            apellidos_nombres = :apellidos_nombres_padre,
            direccion = :direccion_padre,
            ocupacion = :ocupacion_padre,
            telefono = :telefono_padre,
            correo = :correo_padre,
            created_by = :usuario
            foto = :foto
            WHERE id_estudiante = :id AND id= :idPapa"; // Ajustar a la columna que identifica al padre

            $stmt_update_padre = $conn->prepare($sql_update_padre);

            // Vincular parámetros para el padre
            $stmt_update_padre->bindParam(':cedula_padre', $cedula_padre);
            $stmt_update_padre->bindParam(':apellidos_nombres_padre', $apellidos_nombres_padre);
            $stmt_update_padre->bindParam(':direccion_padre', $direccion_padre);
            $stmt_update_padre->bindParam(':ocupacion_padre', $ocupacion_padre);
            $stmt_update_padre->bindParam(':telefono_padre', $telefono_padre);
            $stmt_update_padre->bindParam(':correo_padre', $correo_padre);
            $stmt_update_padre->bindParam(':foto', $newImageContentPadre, PDO::PARAM_LOB);
            $stmt_update_padre->bindParam(':id', $idEstudiante);
            $stmt_update_padre->bindParam(':idPapa', $idPapa); // Vincular el parámetro idPapa
            $stmt_update_padre->bindParam(':usuario', $usuario);


            $stmt_update_padre->execute();

            imagedestroy($originalImagePadre);
            imagedestroy($newImagePadre);
            $conn->commit();




            $conn->beginTransaction();

            $cedula_mama = $_POST['cedula_mama'];
            $apellidos_nombres_mama = $_POST['apellidos_nombres_mama'];
            $direccion_mama = $_POST['direccion_mama'];
            $ocupacion_mama = $_POST['ocupacion_mama'];
            $telefono_mama = $_POST['telefono_mama'];
            $correo_mama = $_POST['correo_mama'];

            $imagePathMama = $_FILES['imagen_mama']["tmp_name"];
            $originalImageMama = imagecreatefromstring(file_get_contents($imagePathMama));
            $newImageMama = imagecreatetruecolor(148, 178);
            imagecopyresampled($newImageMama, $originalImageMama, 0, 0, 0, 0, 148, 178, imagesx($originalImageMama), imagesy($originalImageMama));

            ob_start();
            imagejpeg($newImageMama, NULL, 100);
            $newImageContentMama = ob_get_contents();
            ob_end_clean();
            // Procesar los datos según el rol (papa, mama, representante)
            $sql_update_mama = "UPDATE persona SET
            cedula = :cedula_mama,
            apellidos_nombres = :apellidos_nombres_mama,
            direccion = :direccion_mama,
            ocupacion = :ocupacion_mama,
            telefono = :telefono_mama,
            correo = :correo_mama,
            created_by = :usuario,
            foto = :foto
            WHERE id_estudiante = :id AND id = :idMama";

            $stmt_update_mama = $conn->prepare($sql_update_mama);
            // Vincular parámetros
            $stmt_update_mama->bindParam(':cedula_mama', $cedula_mama);
            $stmt_update_mama->bindParam(':apellidos_nombres_mama', $apellidos_nombres_mama);
            $stmt_update_mama->bindParam(':direccion_mama', $direccion_mama);
            $stmt_update_mama->bindParam(':ocupacion_mama', $ocupacion_mama);
            $stmt_update_mama->bindParam(':telefono_mama', $telefono_mama);
            $stmt_update_mama->bindParam(':correo_mama', $correo_mama);
            $stmt_update_mama->bindParam(':foto', $newImageContentMama, PDO::PARAM_LOB);
            $stmt_update_mama->bindParam(':id', $idEstudiante);
            $stmt_update_mama->bindParam(':idMama', $idMama);
            $stmt_update_mama->bindParam(':usuario', $usuario);

             // Ajustar el nombre del parámetro según tu estructura de base de datos


            $stmt_update_mama->execute();

            imagedestroy($originalImageMama);
            imagedestroy($newImageMama);

            $conn->commit();

            // Puedes agregar más líneas según se

            // representante
            $conn->beginTransaction();

            $cedula_representante = $_POST['cedula_representante'];
            $apellidos_nombres_representante = $_POST['apellidos_nombres_representante'];
            $direccion_representante = $_POST['direccion_representante'];
            $ocupacion_representante = $_POST['ocupacion_representante'];
            $telefono_representante = $_POST['telefono_representante'];
            $correo_representante = $_POST['correo_representante'];

            $imagePathRepresentante = $_FILES['imagen_representante']["tmp_name"];
            $originalImageRepresentante = imagecreatefromstring(file_get_contents($imagePathRepresentante));
            $newImageRepresentante = imagecreatetruecolor(148, 178);
            imagecopyresampled($newImageRepresentante, $originalImageRepresentante, 0, 0, 0, 0, 148, 178, imagesx($originalImageRepresentante), imagesy($originalImageRepresentante));

            ob_start();
            imagejpeg($newImageRepresentante, NULL, 100);
            $newImageContentRepresentante = ob_get_contents();
            ob_end_clean();
            // Procesar los datos según el rol (papa, mama, representante)
// Aquí p
            $sql_update_representante = "UPDATE persona SET
            cedula = :cedula_representante,
            apellidos_nombres = :apellidos_nombres_representante,
            direccion = :direccion_representante,
            ocupacion = :ocupacion_representante,
            telefono = :telefono_representante,
            correo = :correo_representante,
            created_by = :usuario
            foto = :foto
            WHERE id_estudiante = :id AND id = :idRepresentante"; // Ajustar a la columna que identifica al representante

            $stmt_update_representante = $conn->prepare($sql_update_representante);
            // Vincular parámetros
            $stmt_update_representante->bindParam(':cedula_representante', $cedula_representante);
            $stmt_update_representante->bindParam(':apellidos_nombres_representante', $apellidos_nombres_representante);
            $stmt_update_representante->bindParam(':direccion_representante', $direccion_representante);
            $stmt_update_representante->bindParam(':ocupacion_representante', $ocupacion_representante);
            $stmt_update_representante->bindParam(':telefono_representante', $telefono_representante);
            $stmt_update_representante->bindParam(':correo_representante', $correo_representante);
            $stmt_update_representante->bindParam(':foto', $newImageContentRepresentante, PDO::PARAM_LOB);
            $stmt_update_representante->bindParam(':id', $idEstudiante);
            $stmt_update_representante->bindParam(':idRepresentante', $prerepre_id);
            $stmt_update_representante->bindParam(':usuario', $usuario);
            // Ajustar el nombre del parámetro según tu estructura de base de datos

            $stmt_update_representante->execute();
            imagedestroy($originalImageRepresentante);
            imagedestroy($newImageRepresentante);

            $conn->commit();
            echo "representante fue actualizado Y SUS DATOS.";

        } catch (PDOException $e) {
            // Retrocede en caso de un error
            $conn->rollBack();
            echo "Error: " . $e->getMessage();
        }

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
    //throw $th;
}
