<?php
include_once '../controller/registrar_usuario.php'
?>
<form action="#" method="post">

    <center>
        <h2><b>Crear usuarios</b></h2>
    </center>
    <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">

        <div class="form">
            <label for="usuario">
                <p>Usuario:</p>
            </label>
            <input class="input" type="Text" id="Usuario" oninput="validarTexto(this)" name="usuario" required>
            <span class="input-border"></span>
        </div>
        <div class="form">
            <label for="contrasena">
                <p>Contraseña:</p>
            </label>
            <input class="input" type="Text" id="contrasena" name="contrasena" required>
            <span class="input-border"></span>
        </div>
        <div class="form">
            <label for="rol">
                <p>Rol:</p>
            </label>
            <select class="input" id="rol" name="rol" required>
                <option value="" selected disabled>Seleccione un rol</option>
                <option value="admin">Administrador</option>
                <option value="rectorado">Rectorado</option>
                <option value="secretariado">Secretariado</option>
                <option value="docente">Docente</option>
                <option value="diseno">Editor</option>
            </select>
        </div>
    </div>
    <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">
        <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 10px; background: #FF0000;" class="input" type="submit" name="btnusuario">
            Registrar Usuario
        </button>
    </div>
</form>