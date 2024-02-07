<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';

?>

<center>
    <h2><b>DATOS DEL PAPÁ</b></h2>
</center>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto_padre">
            <h3>Foto del Padre</h3><br>
        </label>
        <input type="file" name="imagen_papa" id="fileInput2" class="custom-file-input"
            onchange="validarImagen(event, 'imagen-preview2', 'mensaje-error2')" >
        <label for="fileInput2" class="custom-file-label">Seleccionar archivo</label>
        <br>
        <div id="mensaje-error2" style="display: none; color: red;"></div>
        <br><br>
        <?php if (isset($imageSrc1)) : ?>
            <img id="imagen-preview2" src="<?php echo $imageSrc1; ?>" class="preview" style="width: 148px; height: 184px;">
        <?php else : ?> 
            <p>No se encontró la imagen</p>
        <?php endif; ?>
        <span class="input-border"></span>
    </div>

</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="cedula_papa">
            <p>16. Cédula del Papá</p>
        </label>
        <input type="text" class="input" id="cedula_papa" name="cedula_papa" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
            value="<?php echo $papa['cedula']; ?>" required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="apellidos_nombres_papa">
            <p>17. Apellidos y Nombres completos</p>
        </label>
        <input type="text" class="input" id="apellidos_nombres_papa" name="apellidos_nombres_papa"  oninput="validarTexto(this)"
            value="<?php echo $papa['apellidos_nombres']; ?>" required>
        <span class="input-border"></span>
    </div>

</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">

    <div class="form">
        <label for="direccion_papa">
            <p>18. Dirección del Papá</p>
        </label>
        <input type="text" class="input" id="direccion_papa" name="direccion_papa"  value="<?php echo $papa['direccion']; ?>" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="ocupacion_papa">
            <p>19. Ocupación del Papá</p>
        </label>
        <input type="text" class="input" id="ocupacion_papa" name="ocupacion_papa"  value="<?php echo $papa['ocupacion']; ?>"  oninput="validarTexto(this)"  required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="telefono_papa">
            <p>20. Teléfono/Celular del Papá</p>
        </label>
        <input type="text" class="input" id="telefono_papa" name="telefono_papa" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
            value="<?php echo $papa['telefono']; ?>" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="correo_papa">
            <p>21. Correo del Papá</p>
        </label>
        <input type="email" class="input" id="correo_papa" name="correo_papa"  value="<?php echo $papa['correo']; ?>" required>
        <span class="input-border"></span>
    </div>

</div>

<br><br>