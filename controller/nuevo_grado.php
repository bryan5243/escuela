<?php
include_once '../model/conexion.php';
$conn = conectarBaseDeDatos();

$idEstudiante = $_POST['idEstudiante'];
$idGrado = $_POST['idGrado'];
$idParalelo = $_POST['idParalelo'];
$idPeriodo = $conn->query("SELECT id FROM periodo WHERE estado = 1")->fetch(PDO::FETCH_ASSOC)['id'];
$ultimoNumeroMatricula = $conn->query("SELECT MAX(numero) as ultimo_numero FROM matricula")->fetch(PDO::FETCH_ASSOC)['ultimo_numero'];

$nuevoNumeroMatricula = $ultimoNumeroMatricula + 1;

$sql_matricula = "INSERT INTO matricula (numero, id_estudiante, id_periodo,id_grado,id_paralelo) VALUES (:numeroMatricula, :idEstudiante, :idPeriodo,:id_grado_estudiante,:id_paralelo_estudiante)";

$statement_matricula = $conn->prepare($sql_matricula);

// Asignar valores a los parámetros
$statement_matricula->bindParam(':numeroMatricula', $nuevoNumeroMatricula);
$statement_matricula->bindParam(':idEstudiante', $idEstudiante);
$statement_matricula->bindParam(':idPeriodo', $idPeriodo);
$statement_matricula->bindParam(':id_grado_estudiante', $idGrado);
$statement_matricula->bindParam(':id_paralelo_estudiante', $idParalelo);
// Ejecutar la consulta
$statement_matricula->execute();


// Respuesta del servidor
$response = [
    'success' => true,
    'message' => 'Estudiante avanzó al siguiente grado'
];

// Enviar la respuesta como JSON
header('Content-Type: application/json');
echo json_encode($response);
