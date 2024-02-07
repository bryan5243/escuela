<?php
include_once '../model/conexion.php';
try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $conn = conectarBaseDeDatos();
        $conn->beginTransaction();
        $usuario = $_SESSION['nombre'];

        $cedula_estudiante = $_POST['cedula_estudiante'];
        $apellidos_estudiante = $_POST['apellidos_estudiante'];
        $nombres_estudiante = $_POST['nombres_estudiante'];
        $lugar_nacimiento_estudiante = $_POST['lugar_nacimiento_estudiante'];
        $residencia_estudiante = $_POST['residencia_estudiante'];
        $direccion_estudiante = $_POST['direccion_estudiante'];
        $sector_estudiante = $_POST['sector_estudiante'];
        $fecha_nacimiento_estudiante = $_POST['fecha_nacimiento_estudiante'];
        $codigo_unico_estudiante = $_POST['codigo_unico_estudiante'];
        $condicion_estudiante = $_POST['condicion_estudiante'];
        $imagePath = $_FILES["imagen"]["tmp_name"];

        $originalImage = imagecreatefromstring(file_get_contents($imagePath));
        $newImage = imagecreatetruecolor(148, 178);
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 148, 178, imagesx($originalImage), imagesy($originalImage));
        // Obtener el contenido de la nueva imagen como un flujo de bytes
        ob_start();
        imagejpeg($newImage, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
        $newImageContent = ob_get_contents();
        ob_end_clean();
        $sql_insert_estudiante = "INSERT INTO estudiante (cedula, apellidos, nombres, lugar_nacimiento, residencia, direccion, sector, fecha_nacimiento, foto,  codigo_unico, condicion, created_by) VALUES (:cedula_estudiante, :apellidos_estudiante, :nombres_estudiante, :lugar_nacimiento_estudiante, :residencia_estudiante, :direccion_estudiante, :sector_estudiante, :fecha_nacimiento_estudiante, :foto,  :codigo_unico_estudiante, :condicion_estudiante, :usuario)";
        $stmt_insert_estudiante = $conn->prepare($sql_insert_estudiante);

        $stmt_insert_estudiante->bindParam(':cedula_estudiante', $cedula_estudiante);
        $stmt_insert_estudiante->bindParam(':apellidos_estudiante', $apellidos_estudiante);
        $stmt_insert_estudiante->bindParam(':nombres_estudiante', $nombres_estudiante);
        $stmt_insert_estudiante->bindParam(':lugar_nacimiento_estudiante', $lugar_nacimiento_estudiante);
        $stmt_insert_estudiante->bindParam(':residencia_estudiante', $residencia_estudiante);
        $stmt_insert_estudiante->bindParam(':direccion_estudiante', $direccion_estudiante);
        $stmt_insert_estudiante->bindParam(':sector_estudiante', $sector_estudiante);
        $stmt_insert_estudiante->bindParam(':fecha_nacimiento_estudiante', $fecha_nacimiento_estudiante);
        $stmt_insert_estudiante->bindParam(':codigo_unico_estudiante', $codigo_unico_estudiante);
        $stmt_insert_estudiante->bindParam(':condicion_estudiante', $condicion_estudiante);
        $stmt_insert_estudiante->bindParam(':usuario', $usuario);

        $stmt_insert_estudiante->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);

        // Ejecutar la consulta
        $stmt_insert_estudiante->execute();

        // Obtener el ID insertado
        $idEstudiante = $conn->lastInsertId();

        $conn->commit();
        imagedestroy($originalImage);
        imagedestroy($newImage);



        $conn->beginTransaction();

        $id_grado_estudiante = $_POST['grado'];
        $id_paralelo_estudiante = $_POST['id_paralelo_estudiante'];

        // Obtener el ID del periodo cuyo estado sea 1
        $idPeriodo = $conn->query("SELECT id FROM periodo WHERE estado = 1")->fetch(PDO::FETCH_ASSOC)['id'];

        // Obtener el último número de matrícula
        $ultimoNumeroMatricula = $conn->query("SELECT MAX(numero) as ultimo_numero FROM matricula")->fetch(PDO::FETCH_ASSOC)['ultimo_numero'];

        // Incrementar el número de matrícula
        $nuevoNumeroMatricula = $ultimoNumeroMatricula + 1;

        // Preparar la consulta de inserción
        $matricula = "INSERT INTO matricula (numero, id_estudiante, id_periodo,id_grado,id_paralelo) VALUES (:numeroMatricula, :idEstudiante, :idPeriodo,:id_grado_estudiante,:id_paralelo_estudiante)";
        $statement_matricula = $conn->prepare($matricula);

        // Asignar valores a los parámetros
        $statement_matricula->bindParam(':numeroMatricula', $nuevoNumeroMatricula);
        $statement_matricula->bindParam(':idEstudiante', $idEstudiante);
        $statement_matricula->bindParam(':idPeriodo', $idPeriodo);
        $statement_matricula->bindParam(':id_grado_estudiante', $id_grado_estudiante);
        $statement_matricula->bindParam(':id_paralelo_estudiante', $id_paralelo_estudiante);
        // Ejecutar la consulta
        $statement_matricula->execute();
        $conn->commit();

        if ($condicion_estudiante == 1) {
            $conn->beginTransaction();

            // Preparar la consulta de inserción en la tabla discapacidad
            $sql_insert_discapacidad = "INSERT INTO discapacidad (tipo, porcentaje, carnet, id_estudiante) VALUES (:tipo_discapacidad, :porcentaje_discapacidad, :carnet_discapacidad, :idEstudiante)";
            $stmt_insert_discapacidad = $conn->prepare($sql_insert_discapacidad);

            $tipo_discapacidad = $_POST['tipo_discapacidad'];
            $porcentaje_discapacidad = $_POST['porcentaje_discapacidad'];
            $carnet_discapacidad = $_POST['carnet_discapacidad'];



            $stmt_insert_discapacidad->bindParam(':tipo_discapacidad', $tipo_discapacidad);
            $stmt_insert_discapacidad->bindParam(':porcentaje_discapacidad', $porcentaje_discapacidad);
            $stmt_insert_discapacidad->bindParam(':carnet_discapacidad', $carnet_discapacidad);
            $stmt_insert_discapacidad->bindParam(':idEstudiante', $idEstudiante);

            // Ejecutar la consulta
            $stmt_insert_discapacidad->execute();
            $conn->commit();
        }


        $conn->beginTransaction();

        $cedula_papa = $_POST['cedula_papa'];
        $apellidos_nombres_papa = $_POST['apellidos_nombres_papa'];
        $direccion_papa = $_POST['direccion_papa'];
        $ocupacion_papa = $_POST['ocupacion_papa'];
        $telefono_papa = $_POST['telefono_papa'];
        $correo_papa = $_POST['correo_papa'];
        $imagePath = $_FILES['imagen_papa']["tmp_name"];
        $originalImage = imagecreatefromstring(file_get_contents($imagePath));
        $newImage = imagecreatetruecolor(148, 178);
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 148, 178, imagesx($originalImage), imagesy($originalImage));
        // Obtener el contenido de la nueva imagen como un flujo de bytes
        ob_start();
        imagejpeg($newImage, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
        $newImageContent = ob_get_contents();
        ob_end_clean();
        // Procesar los datos según el rol (papa, mama, representante)
        // Aquí puedes realizar las operaciones necesarias con los datos
        $sql_insert_papa = "INSERT INTO persona (cedula,apellidos_nombres,direccion,ocupacion,telefono,correo,foto,id_estudiante,created_by) VALUES (:cedula_papa, :apellidos_nombres_papa, :direccion_papa, :ocupacion_papa, :telefono_papa, :correo_papa,:foto,:idEstudiante,:usuario)";
        $stmt_insert_papa = $conn->prepare($sql_insert_papa);
        // Vincular parámetros
        $stmt_insert_papa->bindParam(':cedula_papa', $cedula_papa);
        $stmt_insert_papa->bindParam(':apellidos_nombres_papa', $apellidos_nombres_papa);
        $stmt_insert_papa->bindParam(':direccion_papa', $direccion_papa);
        $stmt_insert_papa->bindParam(':ocupacion_papa', $ocupacion_papa);
        $stmt_insert_papa->bindParam(':telefono_papa', $telefono_papa);
        $stmt_insert_papa->bindParam(':correo_papa', $correo_papa);
        $stmt_insert_papa->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
        $stmt_insert_papa->bindParam(':idEstudiante', $idEstudiante);
        $stmt_insert_papa->bindParam(':usuario', $usuario);

        $stmt_insert_papa->execute();
        $idpapa = $conn->lastInsertId();


        imagedestroy($originalImage);
        imagedestroy($newImage);

        // Ejemplo de cómo podrías almacenar la información en una base de datos o realizar alguna otra acción
        // mysqli_query($conexion, "INSERT INTO tabla (cedula, apellidos_nombres, direccion, ocupacion, telefono, correo) VALUES ('$cedula_persona', '$apellidos_nombres_persona', '$direccion_persona', '$ocupacion_persona', '$telefono_persona', '$correo_persona')");

        $conn->commit();

        $conn->beginTransaction();
        // Insertar en la tabla 'rol'
        $sql_insert_rolp = "INSERT INTO rol (id_persona, rol) VALUES (:id_persona, 'Padre')";
        $stmt_insert_rolp = $conn->prepare($sql_insert_rolp);
        // Vincular parámetros
        $stmt_insert_rolp->bindParam(':id_persona', $idpapa);
        $stmt_insert_rolp->execute();


        $conn->commit();


        //Datos de mama

        $conn->beginTransaction();

        $cedula_mama = $_POST['cedula_mama'];
        $apellidos_nombres_mama = $_POST['apellidos_nombres_mama'];
        $direccion_mama = $_POST['direccion_mama'];
        $ocupacion_mama = $_POST['ocupacion_mama'];
        $telefono_mama = $_POST['telefono_mama'];
        $correo_mama = $_POST['correo_mama'];
        $imagePath = $_FILES['imagen_mama']["tmp_name"];
        $originalImage = imagecreatefromstring(file_get_contents($imagePath));
        $newImage = imagecreatetruecolor(148, 178);
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 148, 178, imagesx($originalImage), imagesy($originalImage));
        // Obtener el contenido de la nueva imagen como un flujo de bytes
        ob_start();
        imagejpeg($newImage, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
        $newImageContent = ob_get_contents();
        ob_end_clean();
        // Procesar los datos según el rol (papa, mama, representante)
        // Aquí puedes realizar las operaciones necesarias con los datos
        $sql_insert_mama = "INSERT INTO persona (cedula,apellidos_nombres,direccion,ocupacion,telefono,correo,foto,id_estudiante,created_by) VALUES (:cedula_mama, :apellidos_nombres_mama, :direccion_mama, :ocupacion_mama, :telefono_mama, :correo_mama,:foto,:idEstudiante,:usuario)";
        $stmt_insert_mama = $conn->prepare($sql_insert_mama);
        // Vincular parámetros
        $stmt_insert_mama->bindParam(':cedula_mama', $cedula_mama);
        $stmt_insert_mama->bindParam(':apellidos_nombres_mama', $apellidos_nombres_mama);
        $stmt_insert_mama->bindParam(':direccion_mama', $direccion_mama);
        $stmt_insert_mama->bindParam(':ocupacion_mama', $ocupacion_mama);
        $stmt_insert_mama->bindParam(':telefono_mama', $telefono_mama);
        $stmt_insert_mama->bindParam(':correo_mama', $correo_mama);
        $stmt_insert_mama->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
        $stmt_insert_mama->bindParam(':idEstudiante', $idEstudiante);
        $stmt_insert_mama->bindParam(':usuario', $usuario);

        $stmt_insert_mama->execute();
        $idmama = $conn->lastInsertId();


        imagedestroy($originalImage);
        imagedestroy($newImage);

        // Ejemplo de cómo podrías almacenar la información en una base de datos o realizar alguna otra acción
        // mysqli_query($conexion, "INSERT INTO tabla (cedula, apellidos_nombres, direccion, ocupacion, telefono, correo) VALUES ('$cedula_persona', '$apellidos_nombres_persona', '$direccion_persona', '$ocupacion_persona', '$telefono_persona', '$correo_persona')");

        $conn->commit();

        $conn->beginTransaction();
        // Insertar en la tabla 'rol'
        $sql_insert_rolm = "INSERT INTO rol (id_persona, rol) VALUES (:id_persona, 'Madre')";
        $stmt_insert_rolm = $conn->prepare($sql_insert_rolm);
        // Vincular parámetros
        $stmt_insert_rolm->bindParam(':id_persona', $idmama);
        $stmt_insert_rolm->execute();

        $conn->commit();


        //representante
        $conn->beginTransaction();

        $cedula_representante = $_POST['cedula_representante'];
        $apellidos_nombres_representante = $_POST['apellidos_nombres_representante'];
        $direccion_representante = $_POST['direccion_representante'];
        $ocupacion_representante = $_POST['ocupacion_representante'];
        $telefono_representante = $_POST['telefono_representante'];
        $correo_representante = $_POST['correo_representante'];
        $imagePath = $_FILES['imagen_representante']["tmp_name"];
        $originalImage = imagecreatefromstring(file_get_contents($imagePath));
        $newImage = imagecreatetruecolor(148, 178);
        imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, 148, 178, imagesx($originalImage), imagesy($originalImage));
        // Obtener el contenido de la nueva imagen como un flujo de bytes
        ob_start();
        imagejpeg($newImage, NULL, 100); // 100 es la calidad, puedes ajustarla según tus necesidades
        $newImageContent = ob_get_contents();
        ob_end_clean();
        // Procesar los datos según el rol (papa, mama, representante)
        // Aquí puedes realizar las operaciones necesarias con los datos
        $sql_insert_representante = "INSERT INTO persona (cedula,apellidos_nombres,direccion,ocupacion,telefono,correo,foto,id_estudiante,created_by) VALUES (:cedula_representante, :apellidos_nombres_representante, :direccion_representante, :ocupacion_representante, :telefono_representante, :correo_representante,:foto,:idEstudiante,:usuario)";
        $stmt_insert_representante = $conn->prepare($sql_insert_representante);
        // Vincular parámetros
        $stmt_insert_representante->bindParam(':cedula_representante', $cedula_representante);
        $stmt_insert_representante->bindParam(':apellidos_nombres_representante', $apellidos_nombres_representante);
        $stmt_insert_representante->bindParam(':direccion_representante', $direccion_representante);
        $stmt_insert_representante->bindParam(':ocupacion_representante', $ocupacion_representante);
        $stmt_insert_representante->bindParam(':telefono_representante', $telefono_representante);
        $stmt_insert_representante->bindParam(':correo_representante', $correo_representante);
        $stmt_insert_representante->bindParam(':foto', $newImageContent, PDO::PARAM_LOB);
        $stmt_insert_representante->bindParam(':idEstudiante', $idEstudiante);
        $stmt_insert_representante->bindParam(':usuario', $usuario);

        $stmt_insert_representante->execute();
        $idrepresentante = $conn->lastInsertId();

        imagedestroy($originalImage);
        imagedestroy($newImage);

        // Ejemplo de cómo podrías almacenar la información en una base de datos o realizar alguna otra acción
        // mysqli_query($conexion, "INSERT INTO tabla (cedula, apellidos_nombres, direccion, ocupacion, telefono, correo) VALUES ('$cedula_persona', '$apellidos_nombres_persona', '$direccion_persona', '$ocupacion_persona', '$telefono_persona', '$correo_persona')");

        $conn->commit();

        $conn->beginTransaction();
        // Insertar en la tabla 'rol'
        $sql_insert_rolr = "INSERT INTO rol (id_persona, rol) VALUES (:id_persona, 'Representante')";
        $stmt_insert_rolr = $conn->prepare($sql_insert_rolr);
        // Vincular parámetros
        $stmt_insert_rolr->bindParam(':id_persona', $idrepresentante);
        $stmt_insert_rolr->execute();

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
                window.location.href = "../administracion/estudiantes.php"; // Reemplaza con la URL de tu página destino
            }
        });
    </script>';



    } else {
    }
} catch (Exception $e) {
    // Manejar errores y revertir transacción si es necesario

    echo "Error: " . $e->getMessage();
}
$conn = null;

?>