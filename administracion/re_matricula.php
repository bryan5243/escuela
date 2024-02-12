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
        <input type="file" name="imagen" id="fileInput1" class="custom-file-input" onchange="validarImagen(event, 'imagen-preview1', 'mensaje-error1')" required>
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
        <input class="input" type="text" id="cedula" name="cedula_estudiante" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" id="cedula" oninput="verificarCedula()" required>
        <span class="input-border"></span>
        <div id="mensaje"></div>

    </div>
</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">

    <div class="form">
        <label for="apellidos_estudiante">
            <p>2. Apellidos del Estudiante</p>
        </label>
        <input class="input" type="text" id="apellidos_estudiante" name="apellidos_estudiante" oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="nombres_estudiante">
            <p>3. Nombres del Estudiante</p>
        </label>
        <input type="text" class="input" id="nombres_estudiante" name="nombres_estudiante" oninput="validarTexto(this)" required>
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
        <select class="input" id="condicion_estudiante" name="condicion_estudiante" required onchange="habilitarCampos()">
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
    $(document).ready(function() {
        // Función para verificar la cédula en tiempo real
        function verificarCedula() {
            var cedula = $("#cedula").val();

            // Realizar una solicitud AJAX para verificar la existencia en la base de datos
            $.ajax({
                type: "POST",
                url: "../admin/verificar_cedula.php",
                data: {
                    cedula: cedula
                },
                success: function(response) {
                    if (response.trim() === "existente") {
                        $("#mensaje").html("<span style='color:red;'>Estudiante ya inscrito</span>");
                    } else {
                        // Si la cédula no está registrada, realizar la validación ecuatoriana
                        validarCedulaEcuatoriana(cedula);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                    // Manejar errores según sea necesario
                }
            });
        }

        // Agregar el evento oninput al campo de cédula
        $("#cedula").on("input", verificarCedula);

        // Función para validar la cédula ecuatoriana
        function validarCedulaEcuatoriana(cedula) {
            var mensajeDiv = $("#mensaje");

            // Verificar si la cédula tiene 10 dígitos
            if (cedula.length === 10) {
                // Coeficientes para el cálculo del dígito verificador
                var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

                // Calcular el dígito verificador
                var total = 0;
                for (var i = 0; i < 9; i++) {
                    var digito = parseInt(cedula[i]);
                    var resultado = digito * coeficientes[i];
                    total += (resultado > 9) ? resultado - 9 : resultado;
                }

                var verificadorCalculado = (total % 10 === 0) ? 0 : 10 - (total % 10);

                // Verificar que el dígito verificador coincida
                if (verificadorCalculado !== parseInt(cedula[9])) {
                    mensajeDiv.html("<span style='color:red;'>Numero de cedula no valido.</span>");
                } else {
                    mensajeDiv.html("<span style='color:green;'>Cédula válida</span>");
                }
            } else {
                mensajeDiv.html('La cédula debe tener 10 dígitos.');
            }
        }
    });
</script>


<script>
    function habilitarCampos() {
        var condicionEstudiante = document.getElementById("condicion_estudiante");
        var camposDiscapacidad = document.querySelectorAll('.form-container input[type="text"][name^="tipo_discapacidad"], .form-container input[type="text"][name^="porcentaje_discapacidad"], .form-container input[type="text"][name^="carnet_discapacidad"]');

        // Habilitar o deshabilitar los campos de discapacidad según la selección
        camposDiscapacidad.forEach(function(campo) {
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
        console.log('cargarParalelos() se ejecutó');

        var selectedGrado = document.getElementById('grado').value;

        // Realizar una solicitud Fetch para obtener los paralelos
        fetch("../controller/obtener_paralelos.php?grado=" + encodeURIComponent(selectedGrado))
            .then(response => {
                if (!response.ok) {
                    throw new Error('La red no respondió correctamente');
                }
                return response.json();
            })
            .then(paralelos => {
                // Obtener el select de paralelos
                var paraleloSelect = document.getElementById('id_paralelo_estudiante');

                // Limpiar las opciones actuales
                paraleloSelect.innerHTML = "";

                // Llenar el select con las opciones recibidas del servidor
                paralelos.forEach(paralelo => {
                    var option = document.createElement('option');
                    option.value = paralelo.id;
                    option.text = paralelo.paralelo;
                    paraleloSelect.add(option);
                });
            })
            .catch(error => {
                console.error('Error:', error.message);
                // Manejar el error de manera adecuada, por ejemplo, mostrando un mensaje al usuario.
            });
    }
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para verificar la cédula en tiempo real
        function verificarCedula() {
            var cedula = $("#cedula_estudiante").val();

            // Realizar una solicitud AJAX para verificar la existencia en la base de datos
            $.ajax({
                type: "POST",
                url: "../admin/verificar_cedula.php",
                data: {
                    cedula: cedula
                },
                success: function(response) {
                    if (response.trim() === "existente") {
                        $("#mensaje").html("<span style='color:red;'>Estudiante ya inscrito</span>");
                    } else {
                        $("#mensaje").html("<span style='color:green;'>Cédula válida</span>");
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                    // Manejar errores según sea necesario
                }
            });
        }

        // Agregar el evento oninput al campo de cédula_estudiante
        $("#cedula_estudiante").on("input", verificarCedula);
    });
</script>

<br><br>