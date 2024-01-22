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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha512-ez+oQUa5o2Y6LRpeW4tzZSsck4m4XLqf3qIrxFmUfcHA70SE1k/b1juv+7Sg1lfj+Ps6C2lG5LUdi8FwA2EwCQ=="
    crossorigin="anonymous" />
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
        padding: 20px;
        border-radius: 5px;
        text-align: center;
        color: var(--color-text);
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
</style>

<link rel="stylesheet" href="../src/datables//Responsive-2.4.1/css/responsive.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css"
    integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    integrity="sha384-..." crossorigin="anonymous">
<link rel="stylesheet" href="../css/agregar.css">

<!-- //link de botones  -->

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.jqueryui.min.css">
</head>
<main>

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
            $sql = "SELECT DISTINCT
            e.id,
            e.cedula,
            e.apellidos,
            e.nombres,
            g.grado,
            pa.paralelo
            FROM 
                estudiante e
            JOIN 
                grado g ON e.id_grado = g.id
            JOIN 
                matricula m ON e.id = m.id_estudiante
            JOIN 
                periodo pe ON m.id_periodo = pe.id
            JOIN 
                paralelo pa ON pa.id_grado = g.id
            WHERE 
                e.id_paralelo=pa.id;";
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
                echo '<div style="display: flex; align-items: center;" >
                <form action="" method="post" id="actForm">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button id="actualizar" class="hand-cursor" type="submit" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-pen-to-square" style="font-size: 28px; color: #ec1d17;"></i>
                    </button>
                </form>';
                echo '<form action="" method="post" id="eliminarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-trash-alt" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>';
                '</div>';
                '<td> ';

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
                    <input type="text" class="input" id="periodos" name="periodos" required>
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
                    <input type="text" class="input" id="grados" name="grados" required>
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
        <div class="modal" style="width: 350px;">
            <h1>Agregar paralelo</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap; ">
                <div class="form">
                    <label for=" grado">
                        <p>Seleccionar Grado</p>
                    </label>
                    <div class="input-with-button" style="margin-bottom: 20px;">
                        <select type="text" class="input" id="grado" name="grado" required>
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
                                        echo "<option style= 'color:#000000' value='" . $row["id"] . "'>" . $row["grado"] . "</option>";
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
                    <label for=" paralelo">
                        <p>Seleccionar Paralelo</p>
                    </label>
                    <input type="text" class="input" id="paralelo" name="paralelo" required>
                    <span class="input-border"></span>
                </div>
                <div class="form">
                    <button class="btn-modal" id="btn-modal-paralelo" style="margin-left: 40px">Agregar
                        paralelo<i class="fas fa-check" style="margin-left: 10px;"></i></button>
                </div>
                <button class="modal-button" onclick="closeModal('modal3')">&times;</button>
            </div>
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
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'flex';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>

<script>
    $(document).ready(function () {
        $("#btn-modal-periodo").click(function () {
            // Obtener el valor del campo de texto
            var periodos = $("#periodos").val();

            // Obtener el nombre de usuario de la sesión
            var usuario = "<?php echo $_SESSION['nombre']; ?>";

            if (periodos.trim() === "") {
                alert("Por favor, ingresa un valor en el campo de periodos.");
                return; // Detener la ejecución si el campo está vacío
            }
            // Realizar la solicitud AJAX
            $.ajax({
                type: "POST",
                url: "../controller/agregar_periodo.php",
                data: { periodos: periodos, usuario: usuario },
                success: function (response) {
                    alert(response);
                    closeModal('modal1');
                },
                error: function (xhr, status, error) {
                    alert("Error al realizar la solicitud AJAX: " + error);
                }
            });
        });
    });

    $(document).ready(function () {
        $("#btn-modal-grado").click(function () {
            // Obtener el valor del campo de texto
            var grado = $("#grados").val();

            // Obtener el nombre de usuario de la sesión
            var usuario = "<?php echo $_SESSION['nombre']; ?>";

            if (grado.trim() === "") {
                alert("Por favor, ingresa un valor en el campo de grado.");
                return; // Detener la ejecución si el campo está vacío
            }

            // Realizar la solicitud AJAX
            $.ajax({
                type: "POST",
                url: "../controller/agregar_grado.php",
                data: { grados: grado, usuario: usuario },
                success: function (response) {
                    alert(response);
                    closeModal('modal2');
                },
                error: function (xhr, status, error) {
                    alert("Error al realizar la solicitud AJAX: " + error);
                }
            });
        });
    });
</script>

<script>
    document.getElementById('btn-modal-paralelo').addEventListener('click', function () {
        var gradoSeleccionado = document.getElementById('grado').value;
        var paraleloIngresado = document.getElementById('paralelo').value;

        var xhr = new XMLHttpRequest();
        var url = '../controller/agregar_paralelo.php';
        var params = 'action=agregar_paralelo&grado=' + encodeURIComponent(gradoSeleccionado) + '&paralelo=' + encodeURIComponent(paraleloIngresado);

        if (gradoSeleccionado === "") {
            alert("Por favor, seleccione un grado.");
            return; // Detener la ejecución si el grado no está seleccionado
        }

        if (paraleloIngresado.trim() === "") {
            alert("Por favor, ingresa un valor en el campo de paralelo.");
            return; // Detener la ejecución si el campo está vacío
        }
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                console.log('Respuesta del servidor:', xhr.responseText);

                if (xhr.status === 200) {
                    try {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            alert('Paralelo agregado exitosamente.');
                            // Puedes realizar acciones adicionales si es necesario
                        } else {
                            alert('Error al agregar el paralelo: ' + response.error);
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

<script>
    $(document).ready(function () {
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