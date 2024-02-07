<?php
session_start();
include_once "../layout/plantilla.php";
include_once "../administracion/menu.php";
include_once '../model/conexion.php';


if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}
$usuario = $_SESSION['nombre'];

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



    <?php
    // Verificar si la solicitud proviene del formulario y tiene un valor de 'id'
    if (isset($_POST['id'])) {
        // Obtener el valor del ID del estudiante
        $idEstudiante = $_POST['id'];
        // Incluir cargar_prematricula.php solo si proviene del formulario
    }
    include_once("../controller/cargar_matricula.php");
    ?>



    <form action="#" method="post" id="myForm" enctype="multipart/form-data">

        <div>
            <ul class="tabs">
                <li class="tab active" onclick="changeTab(0)">
                    <h3>Estudiante</h3>
                </li>
                <li class="tab" onclick="changeTab(1)">
                    <h3>Papá</h3>
                </li>
                <li class="tab" onclick="changeTab(2)">
                    <h3>Mamá</h3>
                </li>
                <li class="tab" onclick="changeTab(3)">
                    <h3>Representante</h3>
                </li>
            </ul>

            <div class="tab-content">
                <div id="tab1" style="display: block;">
                    <?php include_once("./actuali_matricula.php"); ?>

                </div>
                <div id="tab2" style="display: none;">
                    <?php include_once("./actuali_matricula2.php"); ?>
                </div>
                <div id="tab3" style="display: none;">
                    <?php include_once("./actuali_matricula3.php"); ?>
                </div>
                <div id="tab4" style="display: none;">
                    <?php include_once("./actuali_representante.php"); ?>
                </div>

                <div class="navigation-buttons">
                    <button type="button" class="custom-tab-label" onclick="changeTab('previous')">Anterior</button>
                    <button type="button" class="custom-tab-label" onclick="changeTab('next')">Siguiente</button>

                    <br><br>
                </div>
            </div>


    </form>


</main>

<?php
include("header.php")
    ?>
<script src="../js/mostrarfoto.js"></script>
<script src="../js/menu.js"></script>
<script src="../js/tabs.js"></script>
<script src="../js/tema.js"></script>
<script src="../js/re_estudiante.js"></script>
