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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-..." crossorigin="anonymous">

<link rel="stylesheet" href="../css/eliminar.css">


<!-- //link de botones  -->

<!-- jQuery UI CSS -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.jqueryui.min.css">

<!-- DataTables Buttons CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.jqueryui.min.css">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

</head>
<main>
<?php if ($_SESSION['rol'] == "admin") { ?>

    <div class="button-container">
        <button class="button-model" onclick="openModal('modal1')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path fill="currentColor" d="M5 12h14v2H5z"></path>
            </svg>
            <span>Culminar Período</span>
            <button class="button-model" onclick="openModal('modal2')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M5 12h14v2H5z"></path>
                </svg>
                <span>Eliminar Grado</span>
            </button>

            <button class="button-model" onclick="openModal('modal3')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor" d="M5 12h14v2H5z"></path>
                </svg>
                <span>Eliminar Paralelo</span>
            </button>
        </button>

    </div>
    <?php }?>

    <?php if ($_SESSION['rol'] == "rectorado") { ?>

<div class="button-container">
    <button class="button-model" onclick="openModal('modal1')">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
            <path fill="none" d="M0 0h24v24H0z"></path>
            <path fill="currentColor" d="M5 12h14v2H5z"></path>
        </svg>
        <span>Culminar Período</span>
        <button class="button-model" onclick="openModal('modal2')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path fill="currentColor" d="M5 12h14v2H5z"></path>
            </svg>
            <span>Eliminar Grado</span>
        </button>

        <button class="button-model" onclick="openModal('modal3')">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20">
                <path fill="none" d="M0 0h24v24H0z"></path>
                <path fill="currentColor" d="M5 12h14v2H5z"></path>
            </svg>
            <span>Eliminar Paralelo</span>
        </button>
    </button>

</div>
<?php }?>
<?php if ($_SESSION['rol'] == "secretariado") { ?>

<br><br>
<?php }?>
<?php if ($_SESSION['rol'] == "docente") { ?>

<br><br>
<?php }?>

    <table id="example" class="display compact nowrap" style="width:100%;min-width: 480px">
        <thead>
            <tr>

                <th>N°</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>fecha de nacimiento </th>
                <th>Grado</th>
                <th>Paralelo</th>
                <th>Periodo académico</th>
                <th>Representante</th>
                <th>Dir.domicilio </th>
                <th>Celular Representante</th>


            </tr>
        </thead>
        <tbody>
            <?php
            $conn = conectarBaseDeDatos();
            $sql = "SELECT 
            e.id,
            e.cedula,
            e.nombres,
            e.apellidos,
            e.fecha_nacimiento,
            g.grado,
            p.apellidos_nombres,
            p.direccion,
            p.telefono,
            pa.paralelo,
            pe.periodo
            FROM estudiante e
            JOIN matricula m on e.Id=m.id_estudiante
            JOIN grado g ON m.id_grado=g.id
            JOIN persona p ON e.Id = p.id_estudiante
            JOIN paralelo  pa ON g.id=pa.id_grados
            JOIN rol r ON  p.Id= r.id_persona  
            JOIN periodo pe on m.id_periodo=pe.Id
            WHERE r.rol = 'representante' AND pe.estado=0 AND  m.id_paralelo=pa.id;";
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
                <td>' . $row['paralelo'] . '</td>
                <td>' . $row['periodo'] . '</td>
                <td>' . $row['apellidos_nombres'] . '</td>
                <td>' . $row['direccion'] . '</td>
                <td>' . $row['telefono'] . '</td>';
            }
            ?>

        </tbody>
    </table>


    <div class="overlay" id="modal1">
        <div class="modal" style="width: 350px;">
            <h1>Culminar periodo</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap;">
                <div class="form">
                    <label for="periodo">
                        <p>Periodos Académicos</p>
                    </label>
                    <div class="input-with-button"> <!-- Nuevo contenedor para input y botón -->
                        <select type="text" class="input" id="periodo" name="periodo" required>
                            <option value="" selected disabled>Seleccione un periodo</option>

                            <?php
                            $conn = conectarBaseDeDatos();
                            try {
                                // Consulta para obtener los periodos desde la base de datos
                                $sql = "SELECT id, periodo FROM periodo WHERE estado = 1";
                                $result = $conn->query($sql);

                                // Llenar las opciones del select con los datos de la base de datos
                                if ($result->rowCount() > 0) {
                                    foreach ($result as $row) {
                                        echo "<option style=color:#000000 value='" . $row["id"] . "'>" . $row["periodo"] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>No hay periodos disponibles</option>";
                                }
                            } catch (PDOException $e) {
                                echo "Error de conexión: " . $e->getMessage();
                            }
                            $conn = null;
                            ?>
                        </select>

                    </div>

                    <button class="btn-modal" onclick="culminarPeriodo()">Culminar perido académico <i class=" fas fa-check" style="margin-left:10px"></i>
                    </button>
                </div>

                <button class="modal-button" onclick="closeModal('modal1')">&times;</button>
            </div>
        </div>
    </div>
    
    <div class="overlay" id="modal2">
        <div class="modal" style="width: 300px;">
            <h1>Eliminar grado</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap;">
                <div class="form">
                    <label for="grado">
                        <p>Grado a eliminar</p>
                    </label>
                    <div class="input-with-button">
                        <select type="text" class="input" id="grados" name="grados" required>
                            <option value="" selected disabled>Seleccione un grado</option>

                            <?php
                            $conn = conectarBaseDeDatos();
                            try {
                                $sql = "SELECT id, grado FROM grado";
                                $result = $conn->query($sql);

                                if ($result->rowCount() > 0) {
                                    foreach ($result as $row) {
                                        echo "<option value='" . $row["id"] . "'>" . $row["grado"] . "</option>";
                                    }
                                } else {
                                    echo "<option value='' disabled selected>No hay grados disponibles</option>";
                                }
                            } catch (PDOException $e) {
                                echo "Error de conexión: " . $e->getMessage();
                            } finally {
                                $conn = null;
                            }
                            ?>
                        </select>
                    </div>

                    <button class="btn-modal" style="margin-left:40px" onclick="eliminarGrado()">Eliminar grado<i class="fas fa-check" style="margin-left:10px;"></i></button>
                </div>

                <button class="modal-button" onclick="closeModal('modal2')">&times;</button>
            </div>
        </div>
    </div>

    <div class="overlay" id="modal3">
        <div class="modal" style="width: 300px;">
            <h1>Eliminar Paralelo</h1>
            <div class="form-container" style="display: flex; flex-wrap: wrap;">
                <div class="form">
                    <label for="grado">
                        <p>Seleccionar Grado</p>
                    </label>
                    <div class="input-with-button">
                        <select type="text" class="input" id="grado" name="grado" required onchange="cargarParalelos()">
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
                    <label for="paralelo">
                        <p>Seleccionar Paralelo</p>
                    </label>
                    <div class="input-with-button">
                        <select class="input" id="id_paralelo_estudiante" name="id_paralelo_estudiante" required>
                            <option value="" selected disabled>Seleccione un paralelo</option>
                        </select>
                    </div>
                    <button class="btn-modal" style="margin-left: 40px" onclick="eliminarParalelo()()">Eliminar paralelo<i class="fas fa-check" style="margin-left: 10px;"></i></button>

                </div>

                <button class="modal-button" onclick="closeModal('modal3')">&times;</button>
            </div>
        </div>
    </div>





</main>
<?php
include_once "./header.php";
?>

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
    function eliminarParalelo() {
        var selectedGrado = document.getElementById('grado').value;
        var selectedParalelo = document.getElementById('id_paralelo_estudiante').value;

        // Verificar si se han seleccionado grado y paralelo
        if (!selectedGrado || !selectedParalelo) {
            Swal.fire({
                title: "Error",
                text: "Por favor, selecciona un grado y un paralelo.",
                icon: "error",
                confirmButtonText: "Aceptar",
                showCancelButton: false
            });
            return; // Detener la ejecución si no se han seleccionado ambos valores
        }

        // Utilizar SweetAlert2 para mostrar un mensaje de confirmación
        Swal.fire({
            title: "Estás seguro?",
            text: "¿Estás seguro de eliminar este paralelo? Puede haber estudiantes inscritos en ese paralelo.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            // Verificar si el usuario hizo clic en "Sí, eliminar"
            if (result.isConfirmed) {
                // Realizar una solicitud AJAX para eliminar el paralelo
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        if (this.status == 200) {
                            // Utilizar SweetAlert2 para mostrar un mensaje de éxito
                            Swal.fire({
                                title: "Éxito",
                                text: "Paralelo eliminado exitosamente.",
                                icon: "success",
                                confirmButtonText: "Aceptar"
                            }).then(() => {
                                // Agrega un parámetro a la URL antes de recargar
                                const newUrl = new URL(window.location.href);
                                newUrl.searchParams.set("reload", "true");
                                window.location.href = newUrl.toString();
                            });
                        } else {
                            // Utilizar SweetAlert2 para mostrar un mensaje de error
                            Swal.fire({
                                title: "Error",
                                text: "Error al intentar eliminar el paralelo.",
                                icon: "error",
                                confirmButtonText: "Aceptar",
                                showCancelButton: false
                            });
                        }
                    }
                };
                xhttp.open("POST", "../controller/eliminar_paralelo.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("grado=" + selectedGrado + "&paralelo=" + selectedParalelo);
            }
        });
    }
</script>




<script>
    function eliminarGrado() {
        var selectedGrado = document.getElementById('grados').value;

        // Verificar si se ha seleccionado un grado
        if (selectedGrado === "") {
            // Utilizar SweetAlert2 para mostrar un mensaje de advertencia
            Swal.fire({
                title: "Advertencia",
                text: "Por favor, selecciona un grado antes de intentar eliminar.",
                icon: "error",
                confirmButtonText: "Aceptar",
                showCancelButton: false
            });
            return;
        }

        // Utilizar SweetAlert2 para mostrar un mensaje de confirmación
        Swal.fire({
            title: "Estás seguro?",
            text: "¿Estás seguro de eliminar este grado? Puede haber estudiantes inscritos en ese grado.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            // Verificar si el usuario hizo clic en "Sí, eliminar"
            if (result.isConfirmed) {
                // Realizar una solicitud AJAX para eliminar el grado
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState == 4) {
                        console.log("HTTP status:", this.status); // Log HTTP status for debugging

                        if (this.status == 200) {
                            // Utilizar SweetAlert2 para mostrar un mensaje de éxito
                            Swal.fire({
                                title: "Éxito",
                                text: "Grado eliminado con éxito.",
                                icon: "success",
                                confirmButtonText: "Aceptar",
                                showCancelButton: false
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            // Utilizar SweetAlert2 para mostrar un mensaje de error
                            Swal.fire({
                                title: "Error",
                                text: "Error al intentar eliminar el grado.",
                                icon: "error",
                                confirmButtonText: "Aceptar",
                                showCancelButton: false
                            });
                        }
                    }
                };
                xhttp.open("POST", "../controller/eliminar_grado.php", true);
                xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttp.send("grado=" + selectedGrado);
            }
        });
    }
</script>









<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>




<!-- Asegúrate de incluir jQuery en tu proyecto -->
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
    function culminarPeriodo() {
        // Obtener el valor seleccionado del select
        var periodoSeleccionado = document.getElementById("periodo").value;
        var usuario = "<?php echo $_SESSION['nombre']; ?>";

        if (periodoSeleccionado.trim() === "") {
            Swal.fire({
                title: "Advertencia",
                text: "Por favor, selecciona un periodo antes de intentar eliminar.",
                icon: "error",
                confirmButtonText: "Aceptar",
                showCancelButton: false
            });
            return;
        }

        // Verificar si se ha seleccionado un periodo
        if (periodoSeleccionado) {
            // Hacer una solicitud AJAX para enviar el periodo al servidor
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "../controller/culminar_periodo.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Utilizar SweetAlert2 para mostrar un mensaje de éxito
                        Swal.fire({
                            title: "Éxito",
                            text: "Periodo culminado con éxito.",
                            icon: "success",
                            confirmButtonText: "Aceptar",
                            showCancelButton: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    } else {
                        console.error("Error en la solicitud AJAX");
                    }
                }
            };
            // Enviar el periodo al servidor
            xhr.send("periodo=" + periodoSeleccionado);
        } else {
            // Utilizar SweetAlert2 para mostrar un mensaje de advertencia
            Swal.fire({
                title: "Advertencia",
                text: "Selecciona un periodo antes de culminar.",
                icon: "warning",
                confirmButtonText: "Aceptar",
                showCancelButton: false
            });
        }
    }
</script>









<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>





<script src=" ../js/tema.js"></script>
<script src="../js/activo.js"></script>
<script src="../js/menu.js"></script>



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