<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';

?>

<center>
    <h2><b>DATOS DE LA MAMÁ</b></h2>
</center>

<div class="form">
    <label for="foto_mama">
        <h3>Foto de la Mamá:</h3><br>
    </label>
    <input type="file" name="foto_papa" id="foto_mama" class="custom-file-input" onchange="validarImagen(event)"
        required>
    <label for="foto_mama" class="custom-file-label">Seleccionar archivo</label>
    <br>
    <div id="mensaje-error-mama" style="display: none; color: red;"></div>
    <br><br>
    <img id="imagen-preview-mama" class="preview" style="display: none; width: 148px; height: 184px;">
    <span class="input-border"></span>
</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="cedula_mama">
            <p>22. Cédula de la Mamá</p>
        </label>
        <input type="text" class="input" id="cedula_mama" name="cedula_mama" pattern="[0-9]*"
            value="<?php echo $mama['cedula']; ?>" required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="apellidos_nombres_mama">
            <p>23. Apellidos y Nombres completos</p>
        </label>
        <input type="text" class="input" id="apellidos_nombres_mama" name="apellidos_nombres_mama"
            value="<?php echo $mama['apellidos_nombres']; ?>" required>
        <span class="input-border"></span>
    </div>

</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">

    <div class="form">
        <label for="direccion_mama">
            <p>25. Dirección de la Mamá</p>
        </label>
        <input type="text" class="input" id="direccion_mama" name="direccion_mama" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="ocupacion_mama">
            <p>26. Ocupación de la Mamá</p>
        </label>
        <input type="text" class="input" id="ocupacion_mama" name="ocupacion_mama" required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="telefono_mama">
            <p>27. Teléfono/Celular de la Mamá</p>
        </label>
        <input type="text" class="input" id="telefono_mama" name="telefono_mama" pattern="[0-9]*"
            value="<?php echo $mama['telefono']; ?>" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="correo_mama">
            <p>28. Correo de la Mamá</p>
        </label>
        <input type="email" class="input" id="correo_mama" name="correo_mama" required>
        <span class="input-border"></span>
    </div>

</div>
<br><br>