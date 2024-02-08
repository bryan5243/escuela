<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';
include_once("../controller/actu_responsables.php");

?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


<center>
    <h2><b>DATOS DE TRASLADO</b></h2>
</center>

<div class="form-container" style="display: flex; flex-wrap: wrap;margin-top:50px">
    <div class="form">
        <label for="traslado">
            <p>El Estudiante se trasladará solo a la institución</p>
        </label>
        <select class="input" id="traslado" name="traslado" required onchange="habilitarCampos()">
            <option value="" selected disabled>Seleccionar</option>
            <option value="1" <?php echo ($traslado_estudiante == 1) ? 'selected' : ''; ?>>SI</option>
            <option value="0" <?php echo ($traslado_estudiante == 0) ? 'selected' : ''; ?>>NO</option>
        </select>
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="transporte">
            <p>Tipo de transporte</p>
        </label>
        <select class="input" id="transporte" name="transporte" required onchange="habilitarCampos()">
            <option value="" selected disabled>Seleccionar</option>
            <option value="Público" <?php echo ($transporte == "Público") ? 'selected' : ''; ?>>Público</option>
            <option value="Privado" <?php echo ($transporte == "Privado") ? 'selected' : ''; ?>>Privado</option>
            <option value="Escolar" <?php echo ($transporte == "Escolar") ? 'selected' : ''; ?>>Escolar</option>
            <option value="Sin Transporte" <?php echo ($transporte == "Sin Transporte") ? 'selected' : ''; ?>>Sin Transporte</option>
        </select>
        <span class="input-border"></span>
    </div>


    <div class="form">
        <label for="nombres_conductor">
            <p>Nombres del conductor </p>
        </label>
        <input type="text" class="input" id="nombres_conductor" name="nombres_conductor" value="<?php echo  $conductor; ?>" oninput="validarTexto(this)">
        <span class="input-border"></span>
    </div>

    <div class="form">
        <label for="telefono_conductor">
            <p>3. Telefono del conductor </p>
        </label>
        <input type="text" class="input" id="telefono_conductor" name="telefono_conductor" value="<?php echo $telefono_conductor; ?>" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)">
        <span class="input-border"></span>
    </div>

</div>
<div class="form-container" style="display: flex; flex-wrap: wrap;">
    <!-- Agrega el campo oculto dentro del formulario -->
    <input type="hidden" name="id" value="<?php echo $idEstudiante; ?>">

    <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 10px; background: #FF0000;" class="input" type="submit" name="btnactualizarestudianteres" value="">
        Actualizar
    </button>
</div>
<br><br>