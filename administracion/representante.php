<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';
?>
<form method="post" action="ruta_de_guardar_matricula.php">
<main>
    <center>
        <h2><b>DATOS DEL REPRESENTANTE</b></h2>
    </center>

    <br><br>

    <div class="form">
        <label for="foto_representante">
            <h3>Foto del Representante:</h3><br>
        </label>
        <input type="file" name="foto_representante" id="foto_representante" class="custom-file-input" onchange="validarImagen(event)" required>
        <label for="foto_representante" class="custom-file-label">Seleccionar archivo</label>
        <br>
        <div id="mensaje-error-representante" style="display: none; color: red;"></div>
        <br><br>
        <img id="imagen-preview-representante" class="preview" style="display: none; width: 148px; height: 184px;">
        <span class="input-border"></span>
    </div>

    <div class="form-container" style="display: flex; flex-wrap: wrap;">
        <div class="form">
            <label for="cedula_representante">
                <p>22. Cédula del Representante</p>
            </label>
            <input type="text" class="input" id="cedula_representante" name="cedula_representante" pattern="[0-9]*" required>
            <span class="input-border"></span>
        </div>
    </div>
    <div class="form-container" style="display: flex; flex-wrap: wrap;">
        <div class="form">
            <label for="apellidos_nombes_">
                <p>23. Apellidos y Nombres completos</p>
            </label>
            <input type="text" class="input" id="apellidos_nombres" name="apellidos_nombres_representante" required>
            <span class="input-border"></span>
        </div>
    </div>

    <div class="form-container" style="display: flex; flex-wrap: wrap;">
        <div class="form">
            <label for="direccion_representante">
                <p>25. Dirección del Representante</p>
            </label>
            <input type="text" class="input" id="direccion_representante" name="direccion_representante" required>
            <span class="input-border"></span>
        </div>

        <div class="form">
            <label for="ocupacion_representante">
                <p>26. Ocupación del Representante</p>
            </label>
            <input type="text" class="input" id="ocupacion_representante" name="ocupacion_representante" required>
            <span class="input-border"></span>
        </div>
    </div>
    <div class="form-container" style="display: flex; flex-wrap: wrap;">
        <div class="form">
            <label for="telefono_representante">
                <p>27. Teléfono/Celular del Representante</p>
            </label>
            <input type="text" class="input" id="telefono_representante" name="telefono_representante" pattern="[0-9]*" required>
            <span class="input-border"></span>
        </div>
        <div class="form">
            <label for="correo_representante">
                <p>28. Correo del Representante</p>
            </label>
            <input type="email" class="input" id="correo_representante" name="correo_representante" required>
            <span class="input-border"></span>
        </div>
    </div>
    <<div class="form-container" style="display: flex; flex-wrap: wrap;">
        <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 10px; background: #FF0000;" class="input" type="submit" name="btnregistrarestudiante" value="">
            Ingresar
        </button>
    </div>
    </form>
    <br><br>

</main>
