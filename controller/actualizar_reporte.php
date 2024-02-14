<?php
include_once '../model/conexion.php';
$conn = conectarBaseDeDatos();


$sql = "SELECT id, titulo,rector,genero,correo,celular FROM reportes;";
$statement = $conn->prepare($sql);
$statement->execute();
$reporte = $statement->fetch(PDO::FETCH_ASSOC);

$idReporte = $reporte['id'];

$titulo = $reporte['titulo'];
$rector = $reporte['rector'];
$genero = $reporte['genero'];
$correo = $reporte['correo'];
$celular = $reporte['celular'];


if (isset($_POST["btreporte"])) {



    $conn = conectarBaseDeDatos();

    $idReporte = $_POST['id'];
    $titulo = $_POST['titulo'];
    $rector = $_POST['nombre'];
    $genero = $_POST['genero'];
    $correo = $_POST['correo'];
    $celular = $_POST['celular'];
    // Sentencia SQL de actualización sin la cláusula WHERE
    $sql_update_reporte = "UPDATE reportes SET 
    titulo = :titulo,
    rector = :rector,
    genero = :genero,
    correo = :correo,
    celular = :celular
    where id= :id";

    $stmt_update = $conn->prepare($sql_update_reporte);

    // Bindear los parámetros
    $stmt_update->bindParam(':titulo', $titulo);
    $stmt_update->bindParam(':rector', $rector);
    $stmt_update->bindParam(':genero', $genero);
    $stmt_update->bindParam(':correo', $correo);
    $stmt_update->bindParam(':celular', $celular);
    $stmt_update->bindParam(':id', $idReporte);


    // Ejecutar la actualización
    $stmt_update->execute();
    var_dump($stmt_update);

    echo "<script>
        window.onload = function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '¡Reporte Actualizado !',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Redireccionar después de cerrar el diálogo de Swal.fire
                window.location.href = '../administracion/tab_opciones.php';
            });
        }
    </script>";

    $conn = null;
}
