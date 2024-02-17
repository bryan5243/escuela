<?php

if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("location: login.php");
    exit();
}

include_once '../model/roles_menu.php';


?>

<style>
    .logo {
        display: center;
        justify-content: center;
        align-items: center;
    }

    .card {
        border: 0px solid #ccc;
        border-radius: 8px;
        padding: 0px;
    }
</style>

<div class="container">
    <aside>
        <div class="top">
            <div class="card">
                <div class="logo"><img src="../img/logo23.png"></div>
                <h2 class="logo-name"><span class="divina">LAS ÁGUILAS</span><span class="mise"> DEL SABER</span></h2>
            </div>
            <div class="close" id="close-btn">
                <span class="material-icons-sharp">close</span>
            </div>
        </div>

        <div class="sidebar">
            <?php if (isOptionAllowed('dashboard', $_SESSION['rol'])) { ?>
                <a href="dashboard.php" class="default-active">
                    <span class="las la-home"></span>
                    <h3>Inicio</h3>
                </a>
            <?php } ?>

            <?php if (isOptionAllowed('matricula', $_SESSION['rol'])) { ?>
                <a href="re_matriculacion.php">
                    <span class="material-symbols-outlined">
                        group_add
                    </span>
                    <h3>Matricula</h3>
                </a>
            <?php } ?>
            <?php if (isOptionAllowed('responsables', $_SESSION['rol'])) { ?>

                <a href="tabresponsable.php">
                    <span class="material-symbols-outlined">
                        supervised_user_circle
                    </span>
                    <h3>Responsables</h3>
                </a>
            <?php } ?>
            <?php if (isOptionAllowed('matriculados', $_SESSION['rol'])) { ?>

                <a href="estudiantes.php">
                    <span class="material-symbols-outlined">
                        location_away
                    </span>
                    <h3>Matriculados</h3>
                </a>
            <?php } ?>


            <?php if (isOptionAllowed('listado', $_SESSION['rol'])) { ?>

                <a href="listado_estudiantes.php">
                    <span class="material-symbols-outlined">
                        patient_list
                    </span>
                    <h3>Listado Estudiantes</h3>
                </a>
            <?php } ?>

            <?php if (isOptionAllowed('culminados', $_SESSION['rol'])) { ?>

                <a href="periodos_culminados.php">
                    <span class="material-symbols-outlined">
                        content_paste_off
                    </span>
                    <h3>Períodos Culminados</h3>
                </a>
            <?php } ?>

            <?php if (isOptionAllowed('inactivos', $_SESSION['rol'])) { ?>

                <a href="inactivos.php">
                    <span class="material-symbols-outlined">
                    no_accounts
                    </span>
                    <h3>Estudiantes Inactivos</h3>
                </a>
            <?php } ?>


            <?php if (isOptionAllowed('opciones', $_SESSION['rol'])) { ?>
                <a href="tab_opciones.php">
                    <span class="material-symbols-outlined">
                        settings
                    </span>
                    <h3>Opciones</h3>
                </a>
            <?php } ?>

            <a href="../model/cerrar_session.php" class="logout-button">
                <span class="material-icons-sharp">logout</span>
                <h3>Salir</h3>
            </a>

        </div>
    </aside>
