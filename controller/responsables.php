<?php
// obtener_informacion.php
include_once '../model/conexion.php';
$conn = conectarBaseDeDatos();

$idEstudiante = $_GET['id'];
$query = "SELECT
    r.id as id_responsable,
    r.nombre,
    r.telefono,
    r.parentesco,
    r.foto
    FROM responsables r
    JOIN estudiante e on e.Id=r.id_estudiante
    WHERE e.Id = :id";

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

echo '<div class="responsable-container">';
echo '<div class="responsable-info" >';
echo '<img  class="responsable-image" src="' . $imageSrc1 . '" alt="Imagen del responsable">';
echo "<p class='responsable-info'>Nombre: $nombre1</p>";
echo "<p>Teléfono: $telefono1</p>";
echo "<p>Parentesco: $parentesco1</p>";
echo "</div>";
echo "</div>";

echo '<div class="responsable-container">';
echo '<div class="responsable-info">';
echo '<img class="responsable-image" src="' . $imageSrc2 . '" alt="Imagen del responsable">';
echo "<p class='responsable-info'>Nombre: $nombre2</p>";
echo "<p>Teléfono: $telefono2</p>";
echo "<p>Parentesco: $parentesco2</p>";
echo "</div>";
echo "</div>";

echo '<div class="responsable-container">';
echo '<div class="responsable-info">';
echo '<img  class="responsable-image" src="' . $imageSrc3 . '" alt="Imagen del responsable">';
echo "<p class='responsable-info'>Nombre: $nombre3</p>";
echo "<p>Teléfono: $telefono3</p>";
echo "<p>Parentesco: $parentesco3</p>";
echo "</div>";
echo "</div>";
