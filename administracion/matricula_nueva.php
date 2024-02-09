<?php
include_once '../model/conexion.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['id'])) {
        $conn = conectarBaseDeDatos();
        $studentId = $_POST['id'];
        $query = "SELECT 
        pa.id as id_paralelo,
        g.id as  id_grado
        FROM estudiante e
        JOIN matricula m on e.Id=m.id_estudiante
        JOIN grado g on g.id=m.id_grado
        JOIN paralelo pa on pa.id_grados=g.id
        WHERE  m.id_paralelo=pa.id  AND e.Id=:id;";
        $statement = $conn->prepare($query);
        $statement->bindParam(':id', $studentId);
        $statement->execute();

        $matricula = $statement->fetch(PDO::FETCH_ASSOC);

        $preestudiante_grado = $matricula['id_grado'];
        $preestudiante_paralelo = $matricula['id_paralelo'];


        $data = array(
            'id' => $studentId,
            'id_grado' => $preestudiante_grado ,
            'id_paralelo' =>$preestudiante_paralelo,
        );






        // Devuelve los datos en formato JSON
        echo json_encode($data);
        exit; // Detener la ejecución después de enviar la respuesta al cliente
    }
}

?>
