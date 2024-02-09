<?php
session_start();
include_once "../layout/plantilla.php";
include_once "../administracion/menu.php";
include_once '../model/conexion.php';

if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
include_once '../controller/registrar_usuario.php';



?>

<link rel="stylesheet" href="../css/tabs.css">
<link rel="stylesheet" href="../css/inputs.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<style>
    .custom-file-input {
        display: none;
    }

    .custom-file-label {
        background-color: #159f93;
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        display: inline-block;
    }

    .custom-file-label:hover {
        background-color: #159f93;
    }

    .custom-tab-label {
        background-color: #159f93;
        color: white;
        padding: 15px 25px;
        border-radius: 5px;
        cursor: pointer;
    }

    .custom-tab-label:hover {
        background-color: #12857e;
    }
</style>

<main>

    <div class="date" style="margin-bottom: 50px;">
        <input type="date" id="datePicker" readonly>
    </div>

    <form action="#" method="post">

        <center>
            <h2><b>Crear usuarios</b></h2>
        </center>
        <div class="form-container" style="display: flex; flex-wrap: wrap; margin-top: 30px;">

            <div class="form">
                <label for="usuario">
                    <p>Usuario:</p>
                </label>
                <input class="input" type="Text" id="Usuario"  oninput="validarTexto(this)" required name="usuario">
                <span class="input-border"></span>
            </div>
            <div class="form">
                <label for="contrasena">
                    <p>Contraseña:</p>
                </label>
                <input class="input" type="Text" id="contrasena" required name="contrasena">
                <span class="input-border"></span>
            </div>
            <div class="form">
                <label for="rol">
                    <p>Rol:</p>
                </label>
                <select class="input" id="rol" required name="rol">
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
</main>


<?php
include("header.php")
?>

<script src="../js/calendario.js"></script>

<script src="../js/menu.js"></script>
<script src="../js/tabs.js"></script>
<script src="../js/tema.js"></script>
<script src="../js/re_estudiante.js"></script>