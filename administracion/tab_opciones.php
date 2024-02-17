<?php
session_start();
include_once "../layout/plantilla.php";
include_once "../administracion/menu.php";
include_once '../model/conexion.php';


if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}


?>

<link rel="stylesheet" href="../css/tabs.css">
<link rel="stylesheet" href="../css/inputs.css">
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






    <div>
        <ul class="tabs">
            <li class="tab active" onclick="changeTab(0)">
                <h3>Registrar Usuarios</h3>
            </li>
            <li class="tab" onclick="changeTab(1)">
                <h3>Actualizar Reporte
                </h3>
            </li>
            <li class="tab" onclick="changeTab(2)">
                <h3>Administración de usuarios
                </h3>
            </li>


        </ul>

        <div class="tab-content">
            <div id="tab1" style="display: block;">

                <?php include_once("./usuarios.php"); ?>

            </div>
            <div id="tab2" style="display: none;">
                <?php include_once("./reportes.php"); ?>


            </div>
            <div id="tab3" style="display: none;">
                <?php include_once("./administracion_usuarios.php"); ?>


            </div>

            <br><br>


            <div class="navigation-buttons">
                <button type="button" class="custom-tab-label" onclick="changeTab('previous')">Anterior</button>
                <button type="button" class="custom-tab-label" onclick="changeTab('next')">Siguiente</button>

                <br><br>
            </div>
        </div>




</main>

<?php
include("header.php")
?>
<script src="../js/menu.js"></script>
<script src="../js/tabs.js"></script>
<script src="../js/tema.js"></script>
<script src="../js/re_estudiante.js"></script>