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
    date,
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

    .modal {

        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        justify-content: center;
        align-items: center;
        color: var(--color-dark-variant);
        background-color: rgba(0, 0, 0, 0.4);
        font-size: 16px;
    }

    .modal-content {
        background-color: var(--color-modal);
        margin: 15% auto;
        padding: 10px;
        width: 18%;

    }

    .modal-button {
        top: 20px;
        right: 5px;
        font-size: 20px;
        width: 100%;
        /* Ancho al 100% del contenedor */
        height: 100%;
        /* Alto al 100% del contenedor */
        padding: 0;
        margin-top: 10px;
        background-color: red;
        color: white;
        border: none;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }


    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;

        top: 10px;
        right: 10px;
        font-size: 30px;
        width: 25px;
        height: 25px;
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
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    #fecha {
        height: 25px;
        width: 120px;
        /* Puedes ajustar el valor según tus necesidades */
        color: black;
    }
</style>
<link rel="stylesheet" href="../src/datables//Responsive-2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-..." crossorigin="anonymous">



<!-- //link de botones  -->

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.jqueryui.min.css">
</head>
<main>
    <div class="date">
        <input type="date" id="datePicker" readonly>
    </div>



    <table id="example" class="display compact nowrap" style="width:100%;min-width: 480px">
        <thead>
            <tr>

                <th>N°</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>fecha de nacimiento </th>
                <th>Grado</th>
                <th>Representante</th>
                <th>Dir.domicilio </th>
                <th>Celular Representante</th>
                <th>Opciones</th>


            </tr>
        </thead>
        <tbody>
            <?php
            $conn = conectarBaseDeDatos();
            $sql = "SELECT DISTINCT
            e.id,
            e.cedula,
            e.apellidos,
            e.nombres,
            e.fecha_nacimiento,
            g.grado,
            pa.paralelo,
            per.apellidos_nombres,
            per.direccion,
            per.telefono
            FROM
            estudiante e
            JOIN
            matricula m ON e.Id=m.id_estudiante
            JOIN periodo pe on pe.Id=m.id_periodo
            JOIN grado g on g.id=m.id_grado
            JOIN paralelo pa on g.id=pa.id_grados
            JOIN persona per on e.Id=per.id_estudiante
            JOIN rol r on r.id_persona=per.Id
            where m.id_paralelo=pa.id AND r.rol='Representante' AND pe.estado=1 AND e.estado=1";
            $result = $conn->query($sql);
            if (!$result) {
                echo "Error al obtener los datos: " . $conn->errorInfo()[2];
                exit;
            }
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                echo '<tr>
                <td>' . $row['id'] . '</td>
                <td>' . $row['cedula'] . '</td>
                <td>' . $row['nombres'] . '</td>
                <td>' . $row['apellidos'] . '</td>
                <td>' . $row['fecha_nacimiento'] . '</td>
                <td>' . $row['grado'] . '</td>
                <td>' . $row['apellidos_nombres'] . '</td>

                <td>' . $row['direccion'] . '</td>
                <td>' . $row['telefono'] . '</td>
                <td>';
                if ($_SESSION['rol'] == "admin") {

                echo '<div style="display: flex; align-items: center;" >

                <form action="./actuali_matriculacion.php" method="post" id="actForm">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button id="actualizar" class="hand-cursor" type="submit" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-pen-to-square" style="font-size: 28px; color: #ec1d17;"></i>
                    </button>
                </form>';

                    echo '<form id="form_modal' . $row['id'] . '" action="javascript:abrirModal(' . $row['id'] . ')" method="post" data-id="' . $row['id'] . '">
                <input type="hidden" id="estudiante_id" name="estudiante_id" value="' . $row['id'] . '">
                <button class="hand-cursor" name="fecha" style="background-color: var(--c);">
                    <i class="fas fa-calendar-days" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';


                    echo '<form id="form_solicitud' . $row['id'] . '"  action="../controller/solicitud_ingreso.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_solicitud" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-file-pdf" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>

            <form id="form_' . $row['id'] . '" action="../controller/reporte_estudiantes.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_reporte" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-print" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
            
                    // Verificar si hay registros en la tabla responsables para este estudiante
                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables == 0) {

                            echo '<form id="form_' . $row['id'] . '" action="../administracion/tabresponsable.php" method="get">
                        <input type="hidden" name="cedula" value="' . $row['cedula'] . '">
                        <button class="hand-cursor show-details-btn" type="submit" name="" value="' . $row['id'] . '" style="background-color: var(--c);">
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

                    // Verificar si hay registros en la tabla responsables para este estudiante
                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {
                            echo '<form id="form_acuerdo' . $row['id'] . '"  action="../controller/acuerdo_ministerial.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_acuerdo" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-book" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
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

                } elseif ($_SESSION['rol'] == "secretariado") {
                    echo '<div style="display: flex; align-items: center;" >

                <form action="./actuali_matriculacion.php" method="post" id="actForm">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button id="actualizar" class="hand-cursor" type="submit" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-pen-to-square" style="font-size: 28px; color: #ec1d17;"></i>
                    </button>
                </form>';

                    echo '<form id="form_modal' . $row['id'] . '" action="javascript:abrirModal(' . $row['id'] . ')" method="post" data-id="' . $row['id'] . '">
                <input type="hidden" id="estudiante_id" name="estudiante_id" value="' . $row['id'] . '">
                <button class="hand-cursor" name="fecha" style="background-color: var(--c);">
                    <i class="fas fa-calendar-days" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';


                    echo '<form id="form_solicitud' . $row['id'] . '"  action="../controller/solicitud_ingreso.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_solicitud" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-file-pdf" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>

            <form id="form_' . $row['id'] . '" action="../controller/reporte_estudiantes.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_reporte" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-print" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                    // Verificar si hay registros en la tabla responsables para este estudiante
                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables == 0) {

                            echo '<form id="form_' . $row['id'] . '" action="../administracion/tabresponsable.php" method="get">
                        <input type="hidden" name="cedula" value="' . $row['cedula'] . '">
                        <button class="hand-cursor show-details-btn" type="submit" name="" value="' . $row['id'] . '" style="background-color: var(--c);">
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

                    // Verificar si hay registros en la tabla responsables para este estudiante
                    $id_estudiante = $row['id'];
                    $query_responsables = "SELECT COUNT(*) as count FROM responsables WHERE id_estudiante = $id_estudiante";
                    $result_responsables = $conn->query($query_responsables);

                    if ($result_responsables) {
                        $fila_responsables = $result_responsables->fetch(PDO::FETCH_ASSOC);
                        $count_responsables = $fila_responsables['count'];
                        if ($count_responsables > 0) {
                            echo '<form id="form_acuerdo' . $row['id'] . '"  action="../controller/acuerdo_ministerial.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_acuerdo" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-book" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
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
                } elseif ($_SESSION['rol'] == "rectorado") {
                    echo '<div style="display: flex; align-items: center;" >


                    <form id="form_solicitud' . $row['id'] . '"  action="../controller/solicitud_ingreso.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_solicitud" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-file-pdf" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>

            <form id="form_' . $row['id'] . '" action="../controller/reporte_estudiantes.php" method="post" target="_blank">
                <button class="hand-cursor" type="submit" name="generar_reporte" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-print" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
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
                            echo '<form id="form_acuerdo' . $row['id'] . '"  action="../controller/acuerdo_ministerial.php" method="post" target="_blank">
             <button class="hand-cursor" type="submit" name="generar_acuerdo" value="' . $row['id'] . '" style="background-color: var(--c);">
                 <i class="fas fa-book" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
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
                }
                echo '</td>';
            }

            ?>

        </tbody>
    </table>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h2 style="margin-left: 15px;margin-bottom: 10px;">Cambiar fecha de solicitud</h2>

            <label for="fecha" style="margin-left: 15px;">Seleccione una fecha:</label>
            <input type="date" id="fecha" name="fecha" onclick="validarFecha()" onchange="validarFecha()">

            <button class="modal-button" onclick="guardarFecha()">Guardar</button>
        </div>
    </div>

</main>
<?php
include_once "./header.php";
?>

<script src="../js/tema.js"></script>
<script src="../js/activo.js"></script>
<script src="../js/menu.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        validarFecha(); // Llamar a validarFecha() al cargar la página
    });

    function validarFecha() {
        var fechaInput = document.getElementById("fecha");
        var fechaActual = new Date().toISOString().split('T')[0];
        fechaInput.setAttribute('max', fechaActual);

        if (fechaInput.value > fechaActual) {
            alert("No puedes seleccionar una fecha mayor a la actual");
            fechaInput.value = fechaActual; // Establecer la fecha actual
        }
    }
</script>


<script>
    // Función para abrir la ventana modal
    function abrirModal(id) {
        console.log("ID del estudiante:", id);

        // Aquí puedes realizar acciones adicionales antes de abrir el modal, si es necesario
        document.getElementById('myModal').style.display = 'block';
    }

    // Función para cerrar la ventana modal
    function cerrarModal() {
        document.getElementById('myModal').style.display = 'none';
    }

    function guardarFecha() {
        var estudianteId = document.getElementById('estudiante_id').value;
        var nuevaFecha = document.getElementById('fecha').value;

        // Realizar una solicitud AJAX al servidor para actualizar la fecha
        fetch('actualizar_fecha.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    estudianteId: estudianteId,
                    nuevaFecha: nuevaFecha,
                }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('La solicitud no fue exitosa');
                }
                return response.json();
            })
            .then(data => {
                // Manejar la respuesta del servidor si es necesario
                console.log(data);

                // Mostrar SweetAlert2 con mensaje de éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Fecha actualizada con éxito!',
                    showConfirmButton: false,
                    timer: 1500 // Duración del mensaje en milisegundos
                });

                cerrarModal(); // Cerrar el modal después de la actualización
            })
            .catch(error => {
                console.error('Error:', error);

                // Mostrar SweetAlert2 con mensaje de error
                Swal.fire({
                    icon: 'error',
                    title: '¡Error al actualizar la fecha!',
                    text: 'Ha ocurrido un error al intentar actualizar la fecha.',
                });

                cerrarModal(); // Cerrar el modal en caso de error
            });
    }
</script>




<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>

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
<script src="../js/calendario.js"></script>

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
<script>
    // JavaScript to handle button click and submit the form
    document.addEventListener('DOMContentLoaded', function() {
        const reportButtons = document.querySelectorAll('button[name="generar_reporte"]');
        reportButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evita la acción de envío por defecto del botón

                const estudianteId = this.value;
                const form = document.getElementById('form_' + estudianteId); // Obtiene el formulario correspondiente por ID
                const input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'generar_reporte');
                input.setAttribute('value', estudianteId);
                form.appendChild(input);
                form.submit();
            });
        });
    });
</script>
<script>
    // JavaScript to handle button click and submit the form
    document.addEventListener('DOMContentLoaded', function() {
        const reportButtons = document.querySelectorAll('button[name="generar_solicitud"]');
        reportButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evita la acción de envío por defecto del botón

                const estudianteId = this.value;
                const form = document.getElementById('form_solicitud' + estudianteId); // Obtiene el formulario correspondiente por ID
                const input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'generar_solicitud');
                input.setAttribute('value', estudianteId);
                form.appendChild(input);
                form.submit();
            });
        });
    });
</script>

<script>
    // JavaScript to handle button click and submit the form
    document.addEventListener('DOMContentLoaded', function() {
        const reportButtons = document.querySelectorAll('button[name="generar_acuerdo"]');
        reportButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault(); // Evita la acción de envío por defecto del botón

                const estudianteId = this.value;
                const form = document.getElementById('form_acuerdo' + estudianteId); // Obtiene el formulario correspondiente por ID
                const input = document.createElement('input');
                input.setAttribute('type', 'hidden');
                input.setAttribute('name', 'generar_acuerdo');
                input.setAttribute('value', estudianteId);
                form.appendChild(input);
                form.submit();
            });
        });
    });
</script>