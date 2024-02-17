<?php

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
    <center>
        <h1>Administracion de usuarios</h1>
    </center>
    <table id="example" class="display compact nowrap" style="width:100%;min-width: 480px">
        <thead>
            <tr>

                <th>N°</th>
                <th>Usuario</th>
                <th>Contraseña</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Opciones</th>


            </tr>
        </thead>
        <tbody>
            <?php
            $conn = conectarBaseDeDatos();
            $sql = "SELECT DISTINCT
            id,
            usuario,
            contrasena,
            rol,
            estado,
            CASE
                WHEN estado = 1 THEN 'Activo'
                WHEN estado = 0 THEN 'Inactivo'
                ELSE 'Estado no definido'
            END AS estado_descripcion
        FROM usuarios
        LIMIT 18446744073709551615 OFFSET 1;";
            $result = $conn->query($sql);
            if (!$result) {
                echo "Error al obtener los datos: " . $conn->errorInfo()[2];
                exit;
            }
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['usuario'] . '</td>
                <td>' . $row['contrasena'] . '</td>
                <td>' . $row['rol'] . '</td>
                <td>' . $row['estado_descripcion'] . '</td>
                <td>';
                echo '<div style="display: flex; align-items: center;" >';

                if ($row['estado'] == 1) {

                    echo '<form action="" method="post" id="eliminarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-user-slash" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                }else {
                    echo '<form action="" method="post" id="activarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_activar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-user-check" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';

                }
                echo  '</div>';
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
<script src="../js/desactivar_usuario.js"></script>
<script src="../js/activar_usuario.js"></script>






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
            language: {
                url: '../src/datables/español.json',
            },
            responsive: true,
            autoWidth: true,

        });
    });
</script>