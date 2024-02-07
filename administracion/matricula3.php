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

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto_madre">
            <h3>Foto de la Madre</h3><br>
        </label>
        <input type="file" name="imagen_mama" id="fileInput3" class="custom-file-input"
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
        <label for="cedula_mama">
            <p>22. Cédula de la Mamá</p>
        </label>
        <input type="text" class="input" id="cedula_mama" name="cedula_mama" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
            value="<?php echo $mama['cedula']; ?>" required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="apellidos_nombres_mama">
            <p>23. Apellidos y Nombres completos</p>
        </label>
        <input type="text" class="input" id="apellidos_nombres_mama" name="apellidos_nombres_mama"  oninput="validarTexto(this)"
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
        <input type="text" class="input" id="telefono_mama" name="telefono_mama" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
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