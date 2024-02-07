<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';
?>

<center>
    <h2><b>DATOS DEL REPRESENTANTE</b></h2>
</center>

<br><br>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="foto_representante">
            <h3>Foto del Representante</h3><br>
        </label>
        <input type="file" name="imagen_representante" id="fileInput4" class="custom-file-input"
            onchange="validarImagen(event, 'imagen-preview4', 'mensaje-error4')" >
        <label for="fileInput4" class="custom-file-label">Seleccionar archivo</label>
        <br>
        <div id="mensaje-error4" style="display: none; color: red;"></div>
        <br><br>
        <?php if (isset($imageSrc3)) : ?>

        <img id="imagen-preview4" src="<?php echo $imageSrc3; ?>" class="preview" style=" width: 148px; height: 184px;">
        <?php else : ?> 
            <p>No se encontró la imagen</p>
        <?php endif; ?>
        <span class="input-border"></span>
    </div>

</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="cedula_representante">
            <p>22. Cédula del Representante</p>
        </label>
        <input type="text" class="input" id="cedula_representante" name="cedula_representante" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
            value="<?php echo $estudiante['cedula_repre']; ?>" required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="apellidos_nombes_">
            <p>23. Apellidos y Nombres completos</p>
        </label>
        <input type="text" class="input" id="apellidos_nombres" name="apellidos_nombres_representante"  oninput="validarTexto(this)" 
            value="<?php echo $estudiante['apellidos_repre']; ?>" required>
        <span class="input-border"></span>
    </div>
</div>

<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="direccion_representante">
            <p>25. Dirección del Representante</p>
        </label>
        <input type="text" class="input" id="direccion_representante" name="direccion_representante" value="<?php echo $estudiante['direccion_repre']; ?>" required>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="ocupacion_representante">
            <p>26. Ocupación del Representante</p>
        </label>
        <input type="text" class="input" id="ocupacion_representante" name="ocupacion_representante" value="<?php echo $estudiante['ocupacion']; ?>"  oninput="validarTexto(this)"  required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <div class="form">
        <label for="telefono_representante">
            <p>27. Teléfono/Celular del Representante</p>
        </label>
        <input type="text" class="input" id="telefono_representante" name="telefono_representante" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)"
            value="<?php echo $estudiante['telefono_repre']; ?>" required>
        <span class="input-border"></span>
    </div>
    <div class="form">
        <label for="correo_representante">
            <p>28. Correo del Representante</p>
        </label>
        <input type="email" class="input" id="correo_representante" name="correo_representante" value="<?php echo $estudiante['correo']; ?>" required>
        <span class="input-border"></span>
    </div>
</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <input type="hidden" name="id" value="<?php echo $idEstudiante; ?>">
    <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 10px; background: #FF0000;"
        class="input" type="submit" name="btnactualizarestudiante" value="">
        Actualizar
    </button>
</div>
<br><br>