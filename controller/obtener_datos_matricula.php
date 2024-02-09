<?php
// obtener_datos_medicina.php
include_once '../Model/conexionn.php';

// Conecta a la base de datos y realiza la consulta SQL, reemplaza estos valores por los tuyos
$conn = conectarBaseDeDatos();
$pacienteId = $_GET['id'];

// Consulta SQL
$sql = "SELECT
    MAX(che.fecha) AS fecha,
    MAX(desa.medicamentos) AS desa_medicamentos,
    MAX(desa.dosis) AS desa_dosis,
    MAX(me.medicamentos) AS me_medicamentos,
    MAX(me.dosis) AS me_dosis
    FROM chequeomedico AS che
    INNER JOIN desayuno AS desa ON che.id_paciente = desa.id_paciente
    LEFT JOIN merienda AS me ON che.id_paciente = me.id_paciente
    WHERE che.id_paciente = :pacienteId
    GROUP BY che.fecha
    ORDER BY che.fecha DESC
    LIMIT 1";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':pacienteId', $pacienteId, PDO::PARAM_INT);
$stmt->execute();

// Obtén los valores de los inputs de grado
$grado = ''; // Inicializa la variable
if (isset($_POST['grado'])) {
    $grado = $_POST['grado'];
}

// Genera la salida HTML con los datos
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Resto del código para obtener los datos de medicina

    // Integra los inputs de grado en el código HTML resultante
    echo '<div class="form">';
    echo '<label for="id_grado_estudiante">';
    echo '<p>9. Grado del Estudiante</p>';
    echo '</label>';
    echo '<select type="text" class="input" id="grado" name="grado" required onchange="cargarParalelos()">';
    echo '<option value="" selected disabled>Seleccione un grado</option>';

    $conn = conectarBaseDeDatos();
    try {
        // Consulta para obtener los grados desde la base de datos
        $sql = "SELECT id, grado FROM grado";
        $result = $conn->query($sql);

        // Llenar las opciones del select con los datos de la base de datos
        if ($result->rowCount() > 0) {
            foreach ($result as $row) {
                $selected = ($row["id"] == $grado) ? "selected" : "";
                echo "<option style='color:#000000' value='" . $row["id"] . "' $selected>" . $row["grado"] . "</option>";
            }
        } else {
            echo "<option value=''>No hay grados disponibles</option>";
        }
    } catch (PDOException $e) {
        echo "Error de conexión: " . $e->getMessage();
    }
    $conn = null;

    echo '</select>';
    echo '<span class="input-border"></span>';
    echo '</div>';

    // Resto del código para mostrar los datos de medicina
} else {
    echo 'No se encontraron datos de medicina para este paciente.';
}
