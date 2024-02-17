<?php
session_start();

use PgSql\Connection\Connection;

include_once "../layout/plantilla.php";
include_once "../administracion/menu.php";
include_once "../model/conexion.php";

if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("Location: login.php");
    exit();
}

?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" crossorigin="anonymous" />
<link rel="stylesheet" href="../css/inputs.css">


<style>
    :root {
        --color-dark-variant: #222425;
        --border-before-color: rgba(255, 255, 255);
        --color-text: #222425;
        --color-modal: #e0e0e0;
    }

    .dark-theme-variables {
        --color-dark-variant: #ffffff;
        --border-before-color: rgba(254, 251, 251, 0.39);
        --color-text: #222425;
        --color-modal: rgba(0, 0, 0, 0.7)
    }




    .dt-button.ui-button.ui-corner-all.buttons-excel.buttons-html5::before {
        content: '\f1c3';
        /* Código Unicode del icono de Excel en Font Awesome */
        font-family: 'Font Awesome 5 Free';
        /* Nombre de la fuente de iconos */
        margin-right: 5px;
        /* Espacio a la derecha del ícono */
        font-weight: bold;
        /* Puedes ajustar el peso de la fuente según tus preferencias */
        font-size: 15px;
        /* Puedes ajustar el tamaño del ícono según tus preferencias */
        color: green;
        /* Cambia el color del ícono según tus preferencias */
    }

    /* Estilos adicionales para el texto del botón si es necesario */
    .dt-button.ui-button.ui-corner-all.buttons-excel.buttons-html5 {
        background-color: transparent;
        color: green;
        /* Cambia el color del texto según tus preferencias */
        font-weight: bold;
        /* Puedes ajustar el peso de la fuente según tus preferencias */
        font-size: 15px;
        /* Puedes ajustar el tamaño del texto según tus preferencias */
    }

    .dt-button.ui-button.ui-corner-all.buttons-pdf.buttons-html5::before {
        content: '\f1c1';
        /* Código Unicode del icono de PDF en Font Awesome */
        font-family: 'Font Awesome 5 Free';
        /* Nombre de la fuente de iconos */
        margin-right: 5px;
        /* Espacio a la derecha del ícono */
        font-weight: bold;
        /* Puedes ajustar el peso de la fuente según tus preferencias */
        font-size: 15px;
        /* Puedes ajustar el tamaño del ícono según tus preferencias */
        color: red;
        /* Cambia el color del ícono según tus preferencias */
    }

    /* Estilos adicionales para el texto del botón si es necesario */
    .dt-button.ui-button.ui-corner-all.buttons-pdf.buttons-html5 {
        background-color: transparent;
        color: red;
        /* Cambia el color del texto según tus preferencias */
        font-weight: bold;
        /* Puedes ajustar el peso de la fuente según tus preferencias */
        font-size: 15px;
        /* Puedes ajustar el tamaño del texto según tus preferencias */
    }


    th.sorting_asc.ui-state-default,
    th.sorting.ui-state-default {
        background-color: transparent;
        /* Cambia el color del fondo según tus preferencias */
    }

    .fg-button.ui-button.ui-state-default.ui-state-disabled {
        background-color: transparent;
        font-size: 15px;
        /* Cambia el color del fondo según tus preferencias para un estado deshabilitado */
        /* Cambia el color del texto según tus preferencias para un estado deshabilitado */

    }

    #example_filter {
        margin-bottom: 10px;
    }

    select,
    option,
    p,
    label,
    input,
    li,
    ul,
    button,
    i,
    td,
    th,
    ul,
    tr,
    nav,
    thead,
    h2,
    span,
    .dt-buttons.ui-buttonset button,
    .dt-buttons.ui-buttonset span,
    .dt-button.ui-button.ui-corner-all.buttons-collection.buttons-colvis,

    .sorting.ui-state-default,
    th.sorting_asc.ui-state-default,
    th.sorting_asc.ui-state-default span,
    .dataTables_paginate .fg-buttonset.ui-buttonset a,
    .dataTables_paginate .fg-buttonset-multi.ui-buttonset-multi a,
    .fg-button.ui-button.ui-state-default.ui-state-disabled,

    #example,
    #example_previous,
    #example_paginate,
    #example_info,
    #example_next {
        color: var(--color-dark-variant);
    }




    /* Cambiar el color del texto del botón */

    .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: none;
        color: #fff;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
    }

    .btn i {
        margin-right: 5px;
    }

    .hand-cursor {
        cursor: pointer;
    }

    @media screen and (max-width:768px) {

        aside {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 250px;
            /* Ancho del menú lateral */
            overflow-y: auto;
        }
    }


    #menu-btn {
        cursor: pointer;
    }

    #close-btn {
        cursor: pointer;
    }

    .dt-buttons .buttons-html5 {
        background: none;
        border: none;
        box-shadow: none;
    }

    .dt-buttons .buttons-html5:hover {
        background: none;
        border: none;
        box-shadow: none;
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        color: var(--color-text);

    }

    .modal {
        background-color: var(--color-modal);
        color: var(--color-text);

        padding: 20px;
        border-radius: 5px;
        text-align: center;
        position: relative;
        border-radius: 5%;
        /* Añade posición relativa para posicionar el botón */


    }

    .modal-button {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        width: 30px;
        height: 30px;
        padding: 0;
        background-color: red;
        color: white;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        /* Cambia el cursor al pasar sobre el botón */
        border-radius: 50%;
        /* Para que el botón sea circular */
        z-index: 1;

    }

    .modal-button:hover {
        background-color: darkred;
        /* Cambia el color al pasar sobre el botón */
        transform: scale(1.1);
        /* Hace el botón ligeramente más grande al pasar sobre él */
    }

    .btn-modal {
        cursor: pointer;
        font-size: 16px;
        /* Ajusta el tamaño de la fuente según tus preferencias */
        padding: 10px 15px;
        margin-top: 10px;
        /* Ajusta el padding para hacer el botón más grande */
        border-radius: 10px;
        /* Bordes redondeados */
        background-color: #4CAF50;
        /* Color de fondo */
        color: white;
        /* Color del texto */
        border: none;
        /* Quita el borde */
        cursor: pointer;
        display: flex;
        align-items: center;
        margin-left: 20px;

    }

    /* Estilos generales del modal */
    .modal-container {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        position: relative;
    }

    /* Estilos para cerrar la ventana modal */
    .modal-content .close-button {
        cursor: pointer;
        position: absolute;
        top: 10px;
        right: 10px;
    }

    #modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: white;
        padding: 20px;
        border: 1px solid #ccc;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        z-index: 999;
    }

    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 998;
    }


    /* Estilos para la ventana flotante */
    .ventana-flotante {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        /* Fondo semi-transparente */
        z-index: 1000;
    }

    .contenido {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #fff;
        width: 700px;
        max-height: 700px;
        /* Ancho de la ventana flotante */
        padding: 40px;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: center;
        /* Centrar el contenido en la ventana */
        color: black;
    }

    /* Estilos para el botón de cerrar en la esquina derecha */
    .cerrar-ventana {
        position: absolute;
        top: 10px;
        right: 10px;
        background: none;
        border: none;
        cursor: pointer;
        font-size: 20px;
        color: #167bae;
        z-index: 1000;

    }

    #overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        /* Fondo semitransparente */
        z-index: 10;
        /* Asegura que esté encima de otros elementos */
    }

    #ventanaFlotante {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 900px;
        transform: translate(-50%, -50%);
        z-index: 1000;
        /* Asegura que esté encima del overlay */
        background-color: var(--color-modal);
        padding: 20px;
        border-radius: 8px;
        z-index: 15;

    }

    .modal-button2 {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 30px;
        width: 30px;
        height: 30px;
        padding: 0;
        background-color: red;
        color: white;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        /* Cambia el cursor al pasar sobre el botón */
        border-radius: 50%;
        /* Para que el botón sea circular */
        z-index: 18;
        margin-left: 20px;
    }

    .modal-button2:hover {
        background-color: darkred;
        /* Cambia el color al pasar sobre el botón */
        transform: scale(1.1);
        /* Hace el botón ligeramente más grande al pasar sobre él */
    }

    .responsable-container {
        display: inline-block;
        margin: 0;
        padding: 0;
        padding-left: 25px;
        vertical-align: top;

    }

    .responsable-info {
        text-align: center;
        padding-top: 8px;
    }

    .responsable-image {
        width: 200px;
        height: 200px;
        object-fit: cover;
        border-radius: 5px;
        margin: auto;
    }

    @media only screen and (max-width: 600px) {
        #ventanaFlotante {
            width: 60%;
            max-width: none;
        }

        .modal-button2 {

            top: 10px;
            right: 10px;
            font-size: 20px;
            width: 20px;
            height: 20px;
            padding: 0;

            margin-left: 20px;
        }

        /* Puedes agregar estilos adicionales para dispositivos móviles si es necesario */
    }

    .overlaypasar {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 1;
    }

    .modalpasar {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        width: 550px;
        transform: translate(-50%, -50%);
        background-color: var(--color-modal);
        padding: 20px;
        z-index: 2;
    }
</style>

<link rel="stylesheet" href="../src/datables//Responsive-2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-..." crossorigin="anonymous">
<link rel="stylesheet" href="../css/agregar.css">

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- //link de botones  -->

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.jqueryui.min.css">
</head>
<main>
    <?php if ($_SESSION['rol'] == "admin") { ?>

        <div class="button-container">
            <button class="button-model" onclick="openModal('modal1')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                </svg>
                <span>Iniciar Período</span>
            </button>

            <button class="button-model" onclick="openModal('modal2')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                </svg>
                <span>Agregar Grado</span>
            </button>

            <button class="button-model" onclick="openModal('modal3')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                </svg>
                <span>Agregar Paralelo</span>
            </button>
        </div>

    <?php } ?>
    <?php if ($_SESSION['rol'] == "rectorado") { ?>

        <div class="button-container">
            <button class="button-model" onclick="openModal('modal1')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                </svg>
                <span>Iniciar Período</span>
            </button>

            <button class="button-model" onclick="openModal('modal2')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                </svg>
                <span>Agregar Grado</span>
            </button>

            <button class="button-model" onclick="openModal('modal3')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2z"></path>
                </svg>
                <span>Agregar Paralelo</span>
            </button>
        </div>
    <?php } ?>

    <?php if ($_SESSION['rol'] == "docente") { ?>
        <br><br>
    <?php } ?>
    <?php if ($_SESSION['rol'] == "secretariado") { ?>
        <br><br>
    <?php } ?>



    <table id="example" class="display compact nowrap" style="width:100%;min-width: 480px">
        <thead>
            <tr>

                <th>N°</th>
                <th>Cedula</th>
                <th>Apellidos</th>
                <th>Nombres</th>
                <th>Grado</th>
                <th>Paralelo</th>
                <th>Opciones</th>


            </tr>
        </thead>
        <tbody>
            <?php
            $conn = conectarBaseDeDatos();
            $sql = "WITH EstudiantesConNumero AS (
                SELECT
                    e.id,
                    e.cedula,
                    e.apellidos,
                    e.nombres,
                    g.grado,
                    pa.paralelo,
                    ROW_NUMBER() OVER (PARTITION BY e.id ORDER BY m.created_at DESC) as NumeroFila
                FROM
                    estudiante e
                    JOIN matricula m ON e.Id = m.id_estudiante
                    JOIN periodo pe ON pe.Id = m.id_periodo
                    JOIN grado g ON g.id = m.id_grado
                    JOIN paralelo pa ON g.id = pa.id_grados
                WHERE
                    m.id_paralelo = pa.id AND
                    e.estado = 1
            )
            SELECT
                id,
                cedula,
                apellidos,
                nombres,
                grado,
                paralelo
            FROM
                EstudiantesConNumero
            WHERE
                NumeroFila = 1;
             ";
            $result = $conn->query($sql);
            if (!$result) {
                echo "Error al obtener los datos: " . $conn->errorInfo()[2];
                exit;
            }
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['cedula'] . '</td>
                <td>' . $row['apellidos'] . '</td>
                <td>' . $row['nombres'] . '</td>
                <td>' . $row['grado'] . '</td>
                <td>' . $row['paralelo'] . '</td>
                <td>';
                if ($_SESSION['rol'] == "admin") {

                    echo '<div style="display: flex; align-items: center;" >

                <form action="" method="post" id="actForm">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <button class="hand-cursor abrir-ventana" type="button"  data-estudiante-id="' . $row['id'] . '" style="background-color: var(--c);">
    <i class="far fa-circle-check" style="font-size: 28px; color: #ec1d17;"></i>
</button>

        </form>';



                    $conn = conectarBaseDeDatos();

                    // Verificar si hay registros en la tabla responsables para este estudiante
                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {
                            echo '<form  action="../administracion/act_tabresponsable.php" method="post" >
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor show-details-btn" type="submit" name="" value="' . $row['id'] . '" style="background-color: var(--c);" >
                    <i class="fas fa-person" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
                </form>';
                        } else {
                            // No hay registros, no mostrar el botón
                        }

                        // Liberar resultado de la consulta de responsables
                        $result_responsables->closeCursor();
                    } else {
                        echo '<td>Error al verificar los responsables: ' . $conn->errorInfo()[2] . '</td>';
                    }

                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {

                            echo '
                    <form action="" method="post">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <button class="hand-cursor" type="button" style="background-color: var(--c);" onclick="mostrarInformacion(' . $row['id'] . ')">
                            <i class="fas fa-users" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                        </button>
                    </form>';
                        } else {
                            // No hay registros, no mostrar el botón
                        }

                        // Liberar resultado de la consulta de responsables
                        $result_responsables->closeCursor();
                    } else {
                        echo '<td>Error al verificar los responsables: ' . $conn->errorInfo()[2] . '</td>';
                    }


                    echo ' <form action="" method="post" id="eliminarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-trash-alt" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                    '</div>';
                } elseif ($_SESSION['rol'] == "rectorado") {

                    echo '<div style="display: flex; align-items: center;" >

                    <form action="" method="post" id="actForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor abrir-ventana" type="button"  data-estudiante-id="' . $row['id'] . '" style="background-color: var(--c);">
        <i class="far fa-circle-check" style="font-size: 28px; color: #ec1d17;"></i>
    </button>
    
            </form>';

                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {

                            echo '
            <form action="" method="post">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" style="background-color: var(--c);" onclick="mostrarInformacion(' . $row['id'] . ')">
                    <i class="fas fa-users" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                        } else {
                            // No hay registros, no mostrar el botón
                        }

                        // Liberar resultado de la consulta de responsables
                        $result_responsables->closeCursor();
                    } else {
                        echo '<td>Error al verificar los responsables: ' . $conn->errorInfo()[2] . '</td>';
                    }

                    echo ' <form action="" method="post" id="eliminarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-trash-alt" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                    '<td> ';

                    '</div>';
                } elseif ($_SESSION['rol'] == "secretariado") {
                    echo '<div style="display: flex; align-items: center;" >

                    <form action="" method="post" id="actForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor abrir-ventana" type="button"  data-estudiante-id="' . $row['id'] . '" style="background-color: var(--c);">
        <i class="far fa-circle-check" style="font-size: 28px; color: #ec1d17;"></i>
    </button>
    
            </form>';



                    // Verificar si hay registros en la tabla responsables para este estudiante
                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {
                            echo '<form  action="../administracion/act_tabresponsable.php" method="post" >
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button class="hand-cursor show-details-btn" type="submit" name="" value="' . $row['id'] . '" style="background-color: var(--c);" >
                        <i class="fas fa-person" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                    </button>
                    </form>';
                        } else {
                            // No hay registros, no mostrar el botón
                        }

                        // Liberar resultado de la consulta de responsables
                        $result_responsables->closeCursor();
                    } else {
                        echo '<td>Error al verificar los responsables: ' . $conn->errorInfo()[2] . '</td>';
                    }

                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {

                            echo '
                    <form action="" method="post">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <button class="hand-cursor" type="button" style="background-color: var(--c);" onclick="mostrarInformacion(' . $row['id'] . ')">
                            <i class="fas fa-users" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                        </button>
                    </form>';
                        } else {
                            // No hay registros, no mostrar el botón
                        }

                        // Liberar resultado de la consulta de responsables
                        $result_responsables->closeCursor();
                    } else {
                        echo '<td>Error al verificar los responsables: ' . $conn->errorInfo()[2] . '</td>';
                    }
                    '<td> ';

                    '</div>';
                } elseif ($_SESSION['rol'] == "docente") {
                    echo '<div style="display: flex; align-items: center;" >';

                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {

                            echo '
                    <form action="" method="post">
                        <input type="hidden" name="id" value="' . $row['id'] . '">
                        <button class="hand-cursor" type="button" style="background-color: var(--c);" onclick="mostrarInformacion(' . $row['id'] . ')">
                            <i class="fas fa-users" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                        </button>
                    </form>';
                        } else {
                            // No hay registros, no mostrar el botón
                        }

                        // Liberar resultado de la consulta de responsables
                        $result_responsables->closeCursor();
                    } else {
                        echo '<td>Error al verificar los responsables: ' . $conn->errorInfo()[2] . '</td>';
                    }
                    '<td> ';
                }
            }

            ?>

        </tbody>
    </table>








    <div class="overlay" id="modal1">
        <div class="modal" style="width: 350px;">
            <h1>Iniciar periodo</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap;">
                <div class="form">
                    <label for="periodo">
                        <p>Periodos Académicos</p>
                    </label>
                    <input type="text" class="input" id="periodos" name="periodos" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 4)"  onblur="verificarPeriodo()" required>
                    <span class="input-border"></span>
                </div>

                <div class="form">
                    <button id="btn-modal-periodo" class="btn-modal" style="margin-left: 20px;">
                        Agregar nuevo periodo <i class="fas fa-check" style="padding-left:10px"></i>
                    </button>
                </div>
                <button class="modal-button" onclick="closeModal('modal1')">&times;</button>
            </div>
        </div>
    </div>


    <div class="overlay" id="modal2">
        <div class="modal" style="width: 300px;">
            <h1>Agregar grado</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap;">
                <div class="form">
                    <label for="periodo">
                        <p>Agregar grado</p>
                    </label>
                    <input type="text" class="input" id="grados" pattern="^\S*$" name="grados" required oninput="capitalizeFirstLetter()">
                    <span class="input-border"></span>
                </div>
                <div class="form">
                </div>
                <button id="btn-modal-grado" class="btn-modal" style="margin-left: 40px;">
                    Agregar grado <i class="fas fa-check" style="margin-left:10px;"></i>
                </button>
            </div>
            <button class="modal-button" onclick="closeModal('modal2')">&times;</button>
        </div>
    </div>




    <div class="overlay" id="modal3">
        <div class="modal" style="width: 320px;">
            <h1>Agregar Paralelo</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap;">
                <div class="form">
                    <label for="grado">
                        <p>Seleccionar Grado</p>
                    </label>
                    <div class="input-with-button">
                        <select type="text" class="input" id="grado" name="grado" required ">
                            <option value="" selected disabled>Seleccione un grado</option>

                            <?php
                            $conn = conectarBaseDeDatos();
                            try {
                                // Consulta para obtener los grados desde la base de datos
                                $sql = "SELECT id, grado FROM grado";
                                $result = $conn->query($sql);

                                // Llenar las opciones del select con los datos de la base de datos
                                if ($result->rowCount() > 0) {
                                    foreach ($result as $row) {
                                        echo "<option style=color:#000000 value='" . $row["id"] . "'>" . $row["grado"] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No hay grados disponibles</option>";
                                }
                            } catch (PDOException $e) {
                                echo "Error de conexión: " . $e->getMessage();
                            }
                            ?>
                        </select>
                    </div>
                    <div class=" form">
                            <label for="paralelo">
                                <p>Seleccionar Paralelo</p>
                            </label>
                            <div class="input-with-button">
                                <input type="text" class="input" id="paralelo" name="paralelo" maxlength="1" required oninput="convertToUppercase()">
                                <span class="input-border"></span>
                            </div>
                    </div>
                    <button id="btn-modal-paralelo" class="btn-modal" style="margin-left: 40px">Agregar paralelo<i class="fas fa-check" style="margin-left: 10px;"></i></button>

                </div>

                <button class="modal-button" onclick="closeModal('modal3')">&times;</button>
            </div>
        </div>
    </div>

    <div id="overlay" onclick="cerrarModal()">
        <div id="ventanaFlotante" onclick="event.stopPropagation();">
            <button class="modal-button2" style="font-size: 50;" onclick="cerrarModal()">X</button>
            <h2 class="modal-heading">Responsables del estudiante</h2>
            <!-- Contenido de la ventana flotante -->
            <div class="responsable-container"></div>
            <div class="responsable-container"></div>
            <div class="responsable-container"></div>
        </div>
    </div>

    <fieldset>
        <form method="post" action="#">
            <div class="overlaypasar">
                <div class="modalpasar">
                    <center>
                        <h1>Asignar nuevo grado y paralelo</h1>
                    </center>
                    <?php

                    // Consulta SQL para obtener el periodo académico actual
                    $sql = "SELECT periodo FROM periodo WHERE estado = 1";

                    // Preparar y ejecutar la consulta
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();

                    // Obtener el resultado
                    $periodo_actual = $stmt->fetchColumn();

                    // Verificar si se encontró un periodo académico activo
                    if ($periodo_actual) {
                        // Mostrar el periodo académico actual
                        echo "<p style='padding-top:10px;text-align: center'>Periodo académico actual: $periodo_actual</p>";
                    } else {
                        // Mostrar mensaje si no hay periodo académico activo
                        echo "<p style='padding-top:20px;text-align: center'>No hay periodo académico activo.</p>";
                    }

                    // Cerrar la conexión
                    $conn = null;
                    ?>

                    <button class="modal-button2" onclick="closeModal2()">X</button>

                    <div class="form-container" style="display: flex; flex-wrap: wrap;">

                        <div class="form">
                            <label for="id_grado_estudiante">
                                <p>Grado del Estudiante</p>
                            </label>
                            <input type="hidden" id="idGradoHidden" name="idGrado" value="">

                            <select type="text" class="input" id="grado2" name="grado" required onchange="cargarParalelosModalPasar()">
                                <?php
                                $conn = conectarBaseDeDatos();
                                try {
                                    // Consulta para obtener los grados desde la base de datos
                                    $sql = "SELECT id, grado FROM grado";
                                    $result = $conn->query($sql);

                                    // Llenar las opciones del select con los datos de la base de datos
                                    if ($result->rowCount() > 0) {
                                        foreach ($result as $row) {
                                            echo "<option style='color:#000000' value='" . $row["id"] . "'>" . $row["grado"] . "</option>";
                                        }
                                    } else {
                                        echo "<option value=''>No hay grados disponibles</option>";
                                    }
                                } catch (PDOException $e) {
                                    echo "Error de conexión: " . $e->getMessage();
                                }
                                $conn = null;
                                ?>
                            </select>
                            <span class="input-border"></span>
                        </div>
                        <div class="form">
                            <label for="id_paralelo_estudiante">
                                <p>Paralelo</p>
                            </label>
                            <input type="hidden" id="idParaleloHidden" name="idParalelo" value="">

                            <select class="input" id="id_paralelo_estudiante" name="id_paralelo_estudiante" required>
                            </select>
                        </div>
                        <input type="hidden" id="idEstudianteHidden" name="idEstudiante" value="">

                        <button style="cursor: pointer; font-size: 20px; color:white; border-radius: 20px; background: #FF0000; margin-top: 10px;" class="input" type="button" name="btnpasar" onclick="validarPeriodo()" value="">
                            Actualizar
                        </button>
                    </div>

                </div>

            </div>

        </form>
    </fieldset>



</main>
<?php
include_once "./header.php";



?>






<!-- Incluye jQuery -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




<script>
    function validarPeriodo() {
        // Realiza una petición para verificar si hay algún registro con valor 1 en la tabla periodos
        // Puedes utilizar fetch o cualquier otra técnica para hacer la petición AJAX

        // Ejemplo de código de solicitud AJAX utilizando fetch:
        fetch('../controller/verificar_periodos.php')
            .then(response => response.json())
            .then(data => {
                console.log('Data from verificar_periodos.php:', data);
                if (data.some(periodo => periodo.estado === 1)) {
                    enviarId();
                } else {
                    // Si no hay registros con valor 1, muestra la alerta
                    Swal.fire({
                        title: 'Cree un nuevo periodo',
                        icon: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => console.error('Error al obtener los datos:', error));
    }

    function enviarId() {
        // Obtener los valores del ID, grado y paralelo
        var idEstudiante = $("#idEstudianteHidden").val();
        var idGrado = $("#grado2").val();
        var idParalelo = $("#id_paralelo_estudiante").val();

        console.log(idEstudiante, idGrado, idParalelo);

        // Hacer la solicitud Ajax
        $.ajax({
            type: "POST",
            url: "../controller/nuevo_grado.php",
            data: {
                idEstudiante: idEstudiante,
                idGrado: idGrado,
                idParalelo: idParalelo
            },
            success: function(response) {
                // Manejar la respuesta del servidor
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        title: "Éxito",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Aceptar",
                        showCancelButton: false
                    }).then((result) => {
                        // Redirige a la página después de hacer clic en "Aceptar"
                        if (result.isConfirmed) {
                            window.location.href = "../administracion/listado_estudiantes.php"; // Reemplaza con la URL de tu página destino
                        }
                    });
                } else {
                    // Manejar el caso de respuesta no exitosa si es necesario
                    console.error(response.message);
                }
            },
            error: function(error) {
                console.error("Error en la solicitud Ajax: ", error);
            }
        });
    }
</script>





<script>
    $(".abrir-ventana").on("click", function() {
        var estudianteId = $(this).data("estudiante-id");
        // Asignar el ID del estudiante al input hidden
        $("#idEstudianteHidden").val(estudianteId);
        showModal(estudianteId);
    });

    function showModal(id) {
        $("#idEstudiante").val(id);

        $(".overlaypasar").show();
        $(".modalpasar").show();

        // Llamada AJAX para obtener los datos del estudiante
        $.ajax({
            type: "POST",
            url: "../controller/pasar_grado.php",
            data: {
                id: id
            },
            dataType: "json",
            success: function(response) {
                // Verificar si el ID del estudiante es el correcto antes de continuar
                if ($("#idEstudianteHidden").val() == id) {
                    $("#grado2").val(response.id_grado);
                    $("#id_paralelo_estudiante").val(response.paralelo);
                    cargarParalelosModalPasar();
                } else {
                    // Manejar el caso de ID incorrecto
                    alert("ID de estudiante incorrecto");
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Manejar errores de la llamada AJAX
                alert("Error en la llamada AJAX");
            },
        });
    }

    // Función para cerrar la ventana emergente
    function closeModal2() {
        $(".overlaypasar").hide();
        $(".modalpasar").hide();
    }
</script>






<script>
    function cargarParalelosModalPasar() {
        var selectedGrado = document.getElementById('grado2').value;

        // Realizar una solicitud Fetch para obtener los paralelos
        fetch("../controller/obtener_paralelos.php?grado=" + encodeURIComponent(selectedGrado))
            .then(response => {
                if (!response.ok) {
                    throw new Error('La red no respondió correctamente');
                }
                return response.json();
            })
            .then(paralelos => {

                // Obtener el select de paralelos
                var paraleloSelect = document.getElementById('id_paralelo_estudiante');

                // Limpiar las opciones actuales
                paraleloSelect.innerHTML = "";

                // Llenar el select con las opciones recibidas del servidor
                paralelos.forEach(paralelo => {
                    var option = document.createElement('option');
                    option.value = paralelo.id;
                    option.text = paralelo.paralelo;
                    paraleloSelect.add(option);
                });
            })
            .catch(error => {
                // Manejar el error de manera adecuada, por ejemplo, mostrando un mensaje al usuario.
            });
    }
</script>










<script>
    function convertToUppercase() {
        var paraleloInput = document.getElementById('paralelo');
        var inputValue = paraleloInput.value.toUpperCase(); // Convierte a mayúscula

        // Limita la longitud del valor a 1
        if (inputValue.length > 1) {
            inputValue = inputValue.substring(0, 1);
        }

        // Actualiza el valor del campo
        paraleloInput.value = inputValue;
    }
</script>




<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>


<script src="../js/cargar_paralelos.js"></script>

<script>
    function mostrarInformacion(id) {
        var overlay = document.getElementById("overlay");
        var ventanaFlotante = document.getElementById("ventanaFlotante");

        // Realizar petición AJAX para obtener la información del servidor
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4) {
                if (xhr.status == 200) {
                    // Manipular la respuesta y mostrar la información en la ventana flotante
                    var respuesta = xhr.responseText;

                    // Verificar si la respuesta contiene datos antes de mostrar la ventana
                    if (respuesta.trim() !== "") {
                        // Insertar el contenido en la ventana flotante
                        ventanaFlotante.innerHTML = '<button class="modal-button2" onclick="cerrarModal()">X</button>' +
                            '<h2 style="text-align: center;">Responsables del estudiante</h2>' + // Agregado el encabezado centrado
                            respuesta;

                        // Mostrar el overlay y la ventana flotante
                        overlay.style.display = "block";
                        ventanaFlotante.style.display = "block";
                    } else {
                        console.log("La respuesta del servidor está vacía.");
                    }
                } else {
                    console.log("Error en la petición AJAX. Estado: " + xhr.status);
                }
            }
        };
        xhr.open("GET", "../controller/responsables.php?id=" + id, true);
        xhr.send();
    }

    function cerrarModal() {
        var overlay = document.getElementById("overlay");
        var ventanaFlotante = document.getElementById("ventanaFlotante");

        // Ocultar el overlay y la ventana flotante al cerrar
        overlay.style.display = "none";
        ventanaFlotante.style.display = "none";
    }
</script>






<script>
    $(document).ready(function() {
        $("#btn-modal-periodo").click(function() {
            // Obtener el valor del campo de texto
            var periodos = $("#periodos").val();

            // Obtener el nombre de usuario de la sesión
            var usuario = "<?php echo $_SESSION['nombre']; ?>";


            if (periodos.trim() === "") {
                Swal.fire({
                    title: "Error",
                    text: "Por favor, Ingrese un valor en el campo periodo.",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                    showCancelButton: false
                });
                return; // Detener la ejecución 
            }
            // Realizar la solicitud AJAX
            $.ajax({
                type: "POST",
                url: "../controller/agregar_periodo.php",
                data: {
                    periodos: periodos,
                    usuario: usuario
                },
                success: function(response) {
                    Swal.fire({
                        title: "Éxito",
                        text: "Los datos se han guardado correctamente.",
                        icon: "success",
                        confirmButtonText: "Aceptar",
                        showCancelButton: false
                    }).then((result) => {
                        // Recargar la página solo si se hace clic en "Aceptar"
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    closeModal('modal1');
                },
                error: function(xhr, status, error) {
                    alert("Error al realizar la solicitud AJAX: " + error);
                }
            });
        });
    });
</script>


<script>
    $(document).ready(function() {
        $("#btn-modal-grado").click(function() {
            // Obtener el valor del campo de texto
            var grado = $("#grados").val();

            // Obtener el nombre de usuario de la sesión
            var usuario = "<?php echo $_SESSION['nombre']; ?>";

            if (grado.trim() === "") {
                Swal.fire({
                    title: "Error",
                    text: "Por favor, Ingrese un valor en el campo grado.",
                    icon: "error",
                    confirmButtonText: "Aceptar",
                    showCancelButton: false
                });
                return; // Detener la ejecución 
            }

            // Realizar la solicitud AJAX
            $.ajax({
                type: "POST",
                url: "../controller/agregar_grado.php",
                data: {
                    grados: grado,
                    usuario: usuario
                },
                success: function(response) {
                    Swal.fire({
                        title: "Éxito",
                        text: response,
                        icon: "success",
                        confirmButtonText: "Aceptar",
                        showCancelButton: false
                    }).then((result) => {
                        // Recargar la página solo si se hace clic en "Aceptar"
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    });

                    closeModal('modal2');
                },
                error: function(xhr, status, error) {
                    alert("Error al realizar la solicitud AJAX: " + error);
                }
            });
        });
    });
</script>


<script>
    document.getElementById('btn-modal-paralelo').addEventListener('click', function() {
        var gradoSeleccionado = document.getElementById('grado').value;
        var paraleloIngresado = document.getElementById('paralelo').value;

        var xhr = new XMLHttpRequest();
        var url = '../controller/agregar_paralelo.php';
        var params = 'action=agregar_paralelo&grado=' + encodeURIComponent(gradoSeleccionado) + '&paralelo=' + encodeURIComponent(paraleloIngresado);

        if (gradoSeleccionado === "") {
            Swal.fire({
                title: "Error",
                text: "Por favor,Seleccione un grado",
                icon: "error",
                confirmButtonText: "Aceptar",
                showCancelButton: false
            });
            return; // Detener la ejecución 
        }

        if (paraleloIngresado.trim() === "") {
            Swal.fire({
                title: "Error",
                text: "Por favor, Ingrese un valor en el campo paralelo.",
                icon: "error",
                confirmButtonText: "Aceptar",
                showCancelButton: false
            });
            return; // Detener la ejecución 
        }

        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                console.log('Respuesta del servidor:', xhr.responseText);

                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Utiliza SweetAlert2 en lugar de la alerta estándar
                            Swal.fire({
                                title: "Éxito",
                                text: "Paralelo agregado exitosamente.",
                                icon: "success",
                                confirmButtonText: "Aceptar",
                                showCancelButton: false
                            }).then((result) => {
                                // Recargar la página solo si se hace clic en "Aceptar"
                                if (result.isConfirmed) {
                                    location.reload();
                                }
                            });
                        } else {
                            // Utiliza SweetAlert2 en lugar de la alerta estándar
                            Swal.fire({
                                title: "Error",
                                text: "Error al agregar el paralelo: " + response.error,
                                icon: "error",
                                confirmButtonText: "Aceptar",
                                showCancelButton: false
                            });
                        }
                    } catch (e) {
                        console.error('Error parsing JSON response: ' + e.message);
                    }
                } else {
                    console.error('AJAX request failed with status: ' + xhr.status);
                }
            }
        };

        xhr.send(params);
    });
</script>

<script>
    function capitalizeFirstLetter() {
        var inputElement = document.getElementById('grados');
        var inputValue = inputElement.value.trim(); // Elimina espacios iniciales y finales

        // Verifica si hay al menos una letra en el valor ingresado
        if (inputValue.length > 0) {
            // Convierte la primera letra a mayúscula y concatena el resto del texto
            inputElement.value = inputValue.charAt(0).toUpperCase() + inputValue.slice(1);
        }
    }
</script>



<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>


<script src="../js/tema.js"></script>
<script src="../js/activo.js"></script>
<script src="../js/menu.js"></script>
<script src="../js/eliminar_estudiante.js"></script>



<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.jqueryui.min.js"></script>

<!-- DataTables Buttons -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.jqueryui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>



<script src="../src/datables/Responsive-2.4.1/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            lengthChange: false,
            buttons: ['excel', 'pdf'],
            language: {
                url: '../src/datables/español.json',
            },
            responsive: true,
            autoWidth: true,
            dom: 'Bfrtip',
        });

        table.buttons().container().insertBefore('#example_filter');
    });
</script>