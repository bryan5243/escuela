<?php
include_once '../model/conexion.php';
if (isset($_POST["btnusuario"])) {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol'];

    $conn = conectarBaseDeDatos();

    // Prepara la consulta para insertar los datos de la imagen
    $sql = "INSERT INTO usuarios (usuario, contrasena, rol, estado) VALUES (:usuario, :contrasena, :rol, 1)";
    $statement = $conn->prepare($sql);

    // Bind the parameters
    $statement->bindParam(':usuario', $usuario);
    $statement->bindParam(':contrasena', $contrasena);
    $statement->bindParam(':rol', $rol);


    $statement->execute();
    echo "<script>
        window.onload = function() {
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '¡Registro guardado!',
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