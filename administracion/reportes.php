<?php
if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../model/conexion.php';
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<?php
include_once '../controller/actualizar_reporte.php'
?>
<form action="#" method="post">

    <center>
        <h2><b>Actualizar reportes</b></h2>
    </center>
    <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">

        <div class="form">
            <label for="titulo">
                <p>Iniciales del titulo del rector/a</p>
            </label>
            <input class="input" type="Text" id="titulo" oninput="capitalizarPrimeraLetra(this)" name="titulo" value="<?php echo $titulo; ?>" oninput="validarTexto(this)">
            <span class="input-border"></span>
        </div>
        <div class="form">
            <label for="nombre">
                <p>Nombres y apellidos del rector/a</p>
            </label>
            <input class="input" type="Text" id="nombre" name="nombre" value="<?php echo $rector; ?>" oninput="validarTexto(this)">
            <span class="input-border"></span>
        </div>

        <div class="form">
            <label for="genero">
                <p>Género</p>
            </label>
            <select class="input" id="genero" name="genero">
                <option value="" disabled>Seleccione un género</option>
                <option value="director" <?php echo ($genero == 'director') ? 'selected' : ''; ?>>Masculino</option>
                <option value="directora" <?php echo ($genero == 'directora') ? 'selected' : ''; ?>>Femenino</option>
            </select>
            <span class="input-border"></span>
        </div>


        <div class="form">
            <label for="correo">
                <p>Correo institucional</p>
            </label>
            <input class="input" type="email" id="correo" name="correo" value="<?php echo $correo; ?>">
            <span class="input-border"></span>
        </div>

        <div class="form">
            <label for="celular">
                <p>Celular de la institución</p>
            </label>
            <input class="input" type="text" id="celular" name="celular" value="<?php echo $celular; ?>">
            <span class="input-border"></span>
        </div>
    </div>

    <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">
        <input type="hidden" name="id" value="<?php echo $idReporte; ?>">
        <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 10px; background: #FF0000;" class="input" type="submit" name="btreporte">
            Actualizar Reportes
        </button>
    </div>
</form>
<script>
    function capitalizarPrimeraLetra(input) {
        // Obtener el valor actual del input
        let valorInput = input.value;

        // Capitalizar la primera letra
        valorInput = valorInput.charAt(0).toUpperCase() + valorInput.slice(1);

        // Actualizar el valor del input con la primera letra capitalizada
        input.value = valorInput;

        // Eliminar caracteres no permitidos (números)
        input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑüÜ ]/g, "");

        // Si el valor es completamente en mayúsculas, convertir a formato título
        if (this.value === this.value.toUpperCase()) {
            this.value = this.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
        } else {
            // Si contiene alguna minúscula, aplicar el formato normal
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        }

        // También puedes mostrar un mensaje de error si lo deseas
        if (input.validity.patternMismatch) {
            input.setCustomValidity("Solo se permiten letras y espacios");
        } else {
            input.setCustomValidity("");
        }
    }
</script>