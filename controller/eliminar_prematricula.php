<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include_once '../model/conexion.php';

$id_estudiante = $_POST['id'];

try {
    $conn = conectarBaseDeDatos();
    $conn->beginTransaction(); // Inicia una transacción

    // Eliminar los registros de discapacidad asociados al estudiante
    $sql_delete_discapacidad = "DELETE FROM discapacidad WHERE id_estudiante = :id_estudiante";
    $stmt_delete_discapacidad = $conn->prepare($sql_delete_discapacidad);
    $stmt_delete_discapacidad->bindParam(':id_estudiante', $id_estudiante);
    $stmt_delete_discapacidad->execute();

    // Eliminar registros relacionados en la tabla 'rol'
    $sql_delete_rol = "DELETE FROM rol WHERE id_persona IN (SELECT Id FROM persona WHERE id_estudiante = :id_estudiante)";
    $stmt_delete_rol = $conn->prepare($sql_delete_rol);
    $stmt_delete_rol->bindParam(':id_estudiante', $id_estudiante);
    $stmt_delete_rol->execute();

    // Eliminar registros en la tabla 'persona' asociados al estudiante
    $sql_delete_persona = "DELETE FROM persona WHERE id_estudiante = :id_estudiante";
    $stmt_delete_persona = $conn->prepare($sql_delete_persona);
    $stmt_delete_persona->bindParam(':id_estudiante', $id_estudiante);
    $stmt_delete_persona->execute();

    // Eliminar el estudiante de la tabla 'estudiante'
    $sql_delete_estudiante = "DELETE FROM estudiante WHERE id = :id_estudiante";
    $stmt_delete_estudiante = $conn->prepare($sql_delete_estudiante);
    $stmt_delete_estudiante->bindParam(':id_estudiante', $id_estudiante);
    $stmt_delete_estudiante->execute();

    $conn->commit(); // Confirma la transacción si todo ha ido bien


} catch (Exception $e) {
    $conn->rollBack(); // Revierte la transacción en caso de error
    // Mostrar mensaje de error con SweetAlert2
    echo '<script>
    Swal.fire({
        icon: "error",
        title: "Error",
        text: "' . $e->getMessage() . '"
    });
    </script>';
}
?>