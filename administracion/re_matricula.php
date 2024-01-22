<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';
?>


<center>
    <h2><b>DATOS DEL ESTUDIANTE</b></h2>
</center>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto1">
            <h3>Foto del Estudiante :</h3><br>
        </label>
        <input type="file" name="imagen" id="fileInput1" class="custom-file-input"
            onchange="validarImagen(event, 'imagen-preview1', 'mensaje-error1')" required>
        <label for="fileInput1" class="custom-file-label">Seleccionar archivo</label>
        <br>
        <div id="mensaje-error1" style="display: none; color: red;"></div>
        <br><br>
        <img id="imagen-preview1" class="preview" style="display: none; width: 148px; height: 184px;">
        <span class="input-border"></span>
    </div>
</div>


<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="cedula_estudiante">
            <p>1. Cédula del Estudiante</p>
        </label>
        <input class="input" type="text" id="cedula_estudiante" name="cedula_estudiante" pattern="[0-9]*" required>
        <span class="input-border"></span>
    </div>
</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">

    <div class="form">
        <label for="apellidos_estudiante">
            <p>2. Apellidos del Estudiante</p>
        </label>
        <input class="input" type="text" id="apellidos_estudiante" name="apellidos_estudiante" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="nombres_estudiante">
            <p>3. Nombres del Estudiante</p>
        </label>
        <input type="text" class="input" id="nombres_estudiante" name="nombres_estudiante" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="lugar_nacimiento_estudiante">
            <p>4. Lugar de Nacimiento del Estudiante</p>
        </label>
        <input type="text" class="input" id="lugar_nacimiento_estudiante" name="lugar_nacimiento_estudiante" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="residencia_estudiante">
            <p>5. Residencia del Estudiante (Ciudad)</p>
        </label>
        <input type="text" class="input" id="residencia_estudiante" name="residencia_estudiante" required>
        <span class="input-border"></span>
    </div>
</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">


    <div class="form">
        <label for="direccion_estudiante">
            <p>6. Dirección del Estudiante</p>
        </label>
        <input type="text" class="input" id="direccion_estudiante" name="direccion_estudiante" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="sector_estudiante">
            <p>7. Sector donde vive</p>
        </label>
        <input type="text" class="input" id="sector_estudiante" name="sector_estudiante" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="fecha_nacimiento_estudiante">
            <p>8. Fecha de Nacimiento del Estudiante</p>
        </label>
        <input type="date" class="input" id="fecha_nacimiento_estudiante" name="fecha_nacimiento_estudiante" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="id_grado_estudiante">
            <p>9. Grado del Estudiante</p>
        </label>
        <select type="text" class="input" id="grado" name="grado" required onchange="cargarParalelos()">
            <option value="" selected disabled>Seleccione un grado</option>
            <?php
            $conn = conectarBaseDeDatos();
            try {
                // Consulta para obtener los grados desde la base de datos
                $sql = "SELECT id, grado FROM grado";
                $result = $conn->query($sql);

                // Llenar las opciones del select con los datos de la base de datos
                if ($result->rowCount() > 0) {
                    foreach ($result as $row) {
                        echo "<option style= 'color:#000000' value='" . $row["id"] . "'>" . $row["grado"] . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay grados disponibles</option>";
                }
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
            $conn = null;

            ?>
        </select>
        <span class="input-border"></span>
    </div>

</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">


    <div class="form">
        <label for="id_paralelo_estudiante">
            <p>10. Paralelo</p>
        </label>
        <select class="input" id="id_paralelo_estudiante" name="id_paralelo_estudiante" required>
            <option value="" selected disabled>Seleccione un paralelo</option>

            <?php
            // Reiniciar la variable $result antes de realizar la segunda consulta
            $result = null;
            $conn = conectarBaseDeDatos();

            try {
                // Consulta para obtener los paralelos desde la base de datos según el grado seleccionado
                $selected_grado_id = isset($_POST['grado']) ? $_POST['grado'] : null;

                if ($selected_grado_id !== null) {
                    $sql = "SELECT id, paralelo FROM paralelo WHERE  id_grado = $selected_grado_id";
                    $result = $conn->query($sql);

                    // Llenar las opciones del select con los datos de la base de datos
                    if ($result->rowCount() > 0) {
                        foreach ($result as $row) {
                            echo "<option value='" . $row["id"] . "'>" . $row["paralelo"] . "</option>";
                        }
                    } else {
                        echo "<option value=''>No hay paralelos disponibles para este grado</option>";
                    }
                }
            } catch (PDOException $e) {
                echo "Error de conexión: " . $e->getMessage();
            }
            $conn = null;

            ?>
        </select>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="codigo_unico_estudiante">
            <p>11. Código de Servico básico (Código U Planilla de Luz)</p>
        </label>
        <input type="text" class="input" id="codigo_unico_estudiante" name="codigo_unico_estudiante" required>
        <span class="input-border"></span>
    </div>

</div>

<br><br>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="condicion_estudiante">
            <p>12. Condición del Estudiante ¿Posee Discapacidad?</p>
        </label>
        <select class="input" id="condicion_estudiante" name="condicion_estudiante" required
            onchange="habilitarCampos()">
            <option value="" selected disabled>Seleccionar</option>
            <option value="1">SI</option>
            <option value="0">NO</option>
        </select>
        <span class="input-border"></span>
    </div>

</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="tipo_discapacidad">
            <p>13. Tipo de Discapacidad</p>
        </label>
        <input type="text" class="input" id="tipo_discapacidad" name="tipo_discapacidad" required disabled>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="porcentaje_discapacidad">
            <p>14. Porcentaje de Discapacidad</p>
        </label>
        <input type="text" class="input" id="porcentaje_discapacidad" name="porcentaje_discapacidad" required disabled>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="carnet_discapacidad">
            <p>15. N° Carnet de Discapacidad</p>
        </label>
        <input type="text" class="input" id="carnet_discapacidad" name="carnet_discapacidad" required disabled>
        <span class="input-border"></span>
    </div>

</div>

<script>
    function habilitarCampos() {
        var condicionEstudiante = document.getElementById("condicion_estudiante");
        var camposDiscapacidad = document.querySelectorAll('.form-container input[type="text"][name^="tipo_discapacidad"], .form-container input[type="text"][name^="porcentaje_discapacidad"], .form-container input[type="text"][name^="carnet_discapacidad"]');

        // Habilitar o deshabilitar los campos de discapacidad según la selección
        camposDiscapacidad.forEach(function (campo) {
            campo.disabled = condicionEstudiante.value !== "1";

            // Establecer el valor en "NA" cuando se deshabilitan
            campo.value = campo.disabled ? "NA" : "";
        });
    }

    // Llamada inicial para establecer el estado inicial de los campos
    habilitarCampos();
</script>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function cargarParalelos() {
        var selectedGrado = document.getElementById('grado').value;

        // Realizar una solicitud AJAX para obtener los paralelos
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                // Parsear la respuesta JSON
                var paralelos = JSON.parse(this.responseText);

                // Obtener el select de paralelos
                var paraleloSelect = document.getElementById('id_paralelo_estudiante');

                // Limpiar las opciones actuales
                paraleloSelect.innerHTML = "";

                // Llenar el select con las opciones recibidas del servidor
                paralelos.forEach(function (paralelo) {
                    var option = document.createElement('option');
                    option.value = paralelo.id;
                    option.text = paralelo.paralelo;
                    paraleloSelect.add(option);
                });
            }
        };
        xhttp.open("GET", "../controller/obtener_paralelos.php?grado=" + selectedGrado, true);
        xhttp.send();
    }


</script>


<br><br>