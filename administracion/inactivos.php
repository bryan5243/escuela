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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-ez+oQUa5o2Y6LRpeW4tzZSsck4m4XLqf3qIrxFmUfcHA70SE1k/b1juv+7Sg1lfj+Ps6C2lG5LUdi8FwA2EwCQ==" crossorigin="anonymous" />
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
</style>

<link rel="stylesheet" href="../src/datables//Responsive-2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
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

    <br><br>
    <br>
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
            $sql = "SELECT
            e.id,
            e.cedula,
            e.apellidos,
            e.nombres,
            g.grado,
            pa.paralelo,
            MAX(m.created_at) as ultima_matricula
        FROM
            estudiante e
        JOIN
            matricula m ON e.Id = m.id_estudiante
        JOIN
            periodo pe ON pe.Id = m.id_periodo
        JOIN
            grado g ON g.id = m.id_grado
        JOIN
            paralelo pa ON g.id = pa.id_grados
        WHERE
            m.id_paralelo = pa.id AND e.estado = 0
        GROUP BY
            e.id, e.cedula, e.apellidos, e.nombres, g.grado, pa.paralelo
        ORDER BY
            ultima_matricula DESC
        LIMIT 1;";
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

                echo '<form action="" method="post" id="eliminarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-user-check" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                '</div>';
                '<td> ';
            }
            ?>

        </tbody>
    </table>


</main>
<?php
include_once "./header.php";
?>







<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>


<script src="../js/tema.js"></script>
<script src="../js/activo.js"></script>
<script src="../js/menu.js"></script>
<script src="../js/activar_estudiante.js"></script>




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