<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<center>
    <h2><b>DATOS DEL LOS RESPONSABLES</b></h2>
</center>


<div class="form" style="margin-top: 20px;">
    <label for="cedulaEstudiante">
        <p>Ingrese la cédula del estudiante:</p>
    </label>
    <input class="input" type="text"  id="cedulaEstudiante" required name="cedulaEstudiante">
    <span class="input-border"></span>

    <!-- Contenedor para mostrar sugerencias -->
    <div id="sugerencias"></div>
</div>

<!-- Bloque de Imagen 1 -->
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto1">
            <h3>Foto del Responsable 1:</h3><br>
        </label>
        <input type="file" name="imagen1" id="fileInput1" class="custom-file-input"
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
        <label for="apellidos_nombres1">
            <p>1. Apellidos y Nombres</p>
        </label>
        <input class="input" type="text" id="apellidos_nombres1" name="apellidos_nombres1"  oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="telefono1">
            <p>2. Telefono</p>
        </label>
        <input class="input" type="text" id="telefono1" name="telefono1" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="parentesco1">
            <p>3. Parentesco</p>
        </label>
        <input class="input" type="text" id="parentesco1" name="parentesco1" oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>


</div>
<!-- Bloque de Imagen 2 -->
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto2">
            <h3>Foto del Responsable 2:</h3><br>
        </label>
        <input type="file" name="imagen2" id="fileInput2" class="custom-file-input"
            onchange="validarImagen(event, 'imagen-preview2', 'mensaje-error2')" required>
        <label for="fileInput2" class="custom-file-label">Seleccionar archivo</label>
        <br>
        <div id="mensaje-error2" style="display: none; color: red;"></div>
        <br><br>
        <img id="imagen-preview2" class="preview" style="display: none; width: 148px; height: 184px;">
        <span class="input-border"></span>
    </div>
</div>


<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="apellidos_nombres2">
            <p>4. Apellidos y Nombres</p>
        </label>
        <input class="input" type="text" id="apellidos_nombres2" name="apellidos_nombres2"  oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="telefono2">
            <p>5. Telefono</p>
        </label>
        <input class="input" type="text" id="telefono2" name="telefono2" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="parentesco2">
            <p>6. Parentesco</p>
        </label>
        <input class="input" type="text" id="parentesco2" name="parentesco2"  oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>

</div>


<!-- Bloque de Imagen 3 -->
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto3">
            <h3>Foto del Responsable 3:</h3><br>
        </label>
        <input type="file" name="imagen3" id="fileInput3" class="custom-file-input"
            onchange="validarImagen(event, 'imagen-preview3', 'mensaje-error3')" required>
        <label for="fileInput3" class="custom-file-label">Seleccionar archivo</label>
        <br>
        <div id="mensaje-error3" style="display: none; color: red;"></div>
        <br><br>
        <img id="imagen-preview3" class="preview" style="display: none; width: 148px; height: 184px;">
        <span class="input-border"></span>
    </div>
</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="apellidos_nombres2">
            <p>5. Apellidos y Nombres</p>
        </label>
        <input class="input" type="text" id="apellidos_nombres3" name="apellidos_nombres3"  oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="telefono3">
            <p>6. Telefono</p>
        </label>
        <input class="input" type="text" id="telefono3" name="telefono3"  oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="parentesco3">
            <p>7. Parentesco</p>
        </label>
        <input class="input" type="text" id="parentesco3" name="parentesco3"  oninput="validarTexto(this)" required>
        <span class="input-border"></span>
    </div>

</div>



<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>



<script>
    $(document).ready(function () {
        // Evento keyup para detectar cambios en el input
        $('#cedulaEstudiante').keyup(function () {
            // Obtener el valor del input
            var cedula = $(this).val();

            // Realizar una solicitud AJAX para obtener sugerencias de la base de datos
            $.ajax({
                type: 'POST',
                url: '../controller/obtener_sugerencias.php', // Reemplaza esto con la URL de tu script PHP
                data: { cedula: cedula },
                success: function (response) {
                    // Mostrar las sugerencias en el contenedor
                    $('#sugerencias').html(response);
                }
            });
        });
    });

    function cargarCedula(cedula) {
        // Cargar la cédula en el campo correspondiente
        document.getElementById('cedulaEstudiante').value = cedula;

        // Limpiar el contenedor de sugerencias
        $('#sugerencias').html("");
    }
</script>




<script>
    function validarImagen(event, previewId, errorMessageId) {
        var input = event.target;
        var archivo = input.files[0];

        if (archivo) {
            var extension = archivo.name.split('.').pop().toLowerCase();
            if (extension === 'jpeg' || extension === 'jpg' || extension === 'png') {
                var imagenPreview = document.getElementById(previewId);
                imagenPreview.src = URL.createObjectURL(archivo);
                imagenPreview.style.display = "block";

                var mensajeError = document.getElementById(errorMessageId);
                mensajeError.style.display = "none";
            } else {
                var mensajeError = document.getElementById(errorMessageId);
                mensajeError.innerText = "Solo se permiten archivos JPEG y PNG.";
                mensajeError.style.display = "block";

                var imagenPreview = document.getElementById(previewId);
                imagenPreview.style.display = "none";
                input.value = "";
            }
        }
    }
</script>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>