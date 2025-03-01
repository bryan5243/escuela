<?php
session_start();
include_once "../layout/plantilla.php";
include_once "../administracion/menu.php";
include_once '../model/conexion.php';

if (!isset($_SESSION['id']) || empty($_SESSION['nombre']) || empty($_SESSION['rol'])) {
    header("location: login.php");
    exit();
}
?>
<!----------------Final del menu------------------->
<main>
    <div class="date">
        <input type="date" id="datePicker" readonly>
    </div>
    <style>
        <?php
        $conn = conectarBaseDeDatos();
        $sqlInactive = "SELECT COUNT(DISTINCT e.Id) AS total_estudiantes
    FROM estudiante e
    JOIN matricula m ON e.Id=m.id_estudiante
    JOIN periodo p on p.Id=m.id_periodo
    WHERE e.estado = 0 AND p.estado = 1 AND e.foto IS NOT NULL;";
        $resultInactive = $conn->query($sqlInactive);
        $totalInactive = $resultInactive->fetch(PDO::FETCH_ASSOC)['total_estudiantes'];

        // Obtener datos de pacientes activos
        $sqlActive = "SELECT COUNT(DISTINCT e.Id) AS total_estudiantes
    FROM estudiante e
   JOIN matricula m ON e.Id=m.id_estudiante
   JOIN periodo p on p.Id=m.id_periodo
    WHERE e.estado = 1 AND p.estado = 1 AND e.foto IS NOT NULL;;";
        $resultActive = $conn->query($sqlActive);
        $totalActive = $resultActive->fetch(PDO::FETCH_ASSOC)['total_estudiantes'];

        // Obtener datos de  todos los pacientes 
        $sqlTotal = "SELECT COUNT(DISTINCT e.Id) AS total_estudiantes
    FROM estudiante e
    JOIN matricula m ON e.Id=m.id_estudiante
    JOIN periodo p on p.Id=m.id_periodo
    WHERE  p.estado = 1 AND e.foto IS NOT NULL;";
        $resultTotal = $conn->query($sqlTotal);
        $totalPatients = $resultTotal->fetch(PDO::FETCH_ASSOC)['total_estudiantes'];
        ?> :root {
            --color-dark-variant: #222425;

        }

        .dark-theme-variables {

            --color-dark-variant: #a3bdcc;

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
        nav,
        #example_previous,
        #example_paginate,
        #example_info,
        #example_next {
            color: var(--color-dark-variant);
        }


        .hand-cursor {
            cursor: pointer;
        }




        #menu-btn {
            cursor: pointer;
        }

        #close-btn {
            cursor: pointer;
        }

        @media screen and (max-width:768px) {

            aside {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 250px;
                overflow-y: auto;
            }
        }
    </style>
    <link rel="stylesheet" href="../css/styles.css">
    <link rel="stylesheet" href="../src/datables/DataTables-1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="../src/datables//Responsive-2.4.1/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.2.1/css/fontawesome.min.css" integrity="sha384-QYIZto+st3yW+o8+5OHfT6S482Zsvz2WfOzpFSXMF9zqeLcFV0/wlZpMtyFcZALm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha384-..." crossorigin="anonymous">





    <h1>Dashboard</h1>

    <div class="insights">
        <div class="sales">
            <span class="material-icons-sharp">analytics</span>
            <div class="middle">
                <div class="left">
                    <h3>Inactivos</h3>
                    <h2>
                        <?php echo $totalInactive; ?>
                    </h2>
                </div>

            </div>
            <small class="text-muted">Ahora</small>
        </div>


        <!----------fin sales------>


        <div class="expenses">
            <span class="material-icons-sharp">bar_chart</span>
            <div class="middle">
                <div class="left">
                    <h3>Matriculados</h3>
                    <h2>
                        <?php echo $totalActive; ?>
                    </h2>
                </div>


            </div>
            <small class="text-muted">Ahora</small>
        </div>

        <div class="income">
            <span class="material-icons-sharp">stacked_line_chart</span>
            <div class="middle">
                <div class="left">
                    <h3>Total estudiantes</h3>
                    <h2>
                        <?php echo $totalActive; ?>
                    </h2>
                </div>


            </div>
            <small class="text-muted">Ahora</small>
        </div>
    </div>
    <h2 style="margin-bottom: 25px; margin-top: 25px;">Estudiantes Inscritos</h2>

    <table id="example" class="display compact nowrap" style="width:100%;min-width: 480px">
        <thead>
            <tr>

                <th>N°</th>
                <th>Cedula</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Dirección</th>
                <th>Discapacidad</th>
                <th>Representante</th>
                <th>telefono</th>
                <th>Opciones</th>


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
            e.direccion,
            CASE WHEN e.condicion = 1 THEN 'SI' ELSE 'NO' END AS discapacidad,
            p.cedula,
            p.apellidos_nombres,
            p.telefono
            FROM estudiante e
            JOIN persona p ON e.Id = p.id_estudiante
            JOIN rol r ON p.Id = r.id_persona
            WHERE r.rol = 'representante' AND e.foto IS NULL;";
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
                <td>' . $row['direccion'] . '</td>
                <td>' . $row['discapacidad'] . '</td>

                <td>' . $row['apellidos_nombres'] . '</td>

                <td>' . $row['telefono'] . '</td>
                <td>';
                if ($_SESSION['rol'] == "admin") {

                    echo '<div style="display: flex; align-items: center;" >
                <form action="matriculacion.php" method="post" id="actForm">
                    <input type="hidden" name="id" value="' . $row['id'] . '">
                    <button id="actualizar" class="hand-cursor" type="submit" value="' . $row['id'] . '" style="background-color: var(--c);">
                    <i class="fas fa-user-check" style="font-size: 28px; color: #ec1d17;"></i>
                    </button>
                </form>';

                    echo ' <form action="../controller/eliminar_prematricula.php" method="post" id="eliminarForm">
                <input type="hidden" name="id" value="' . $row['id'] . '">
                <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
                    <i class="fas fa-trash-alt" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
                </button>
            </form>
        </div>';
                } elseif ($_SESSION['rol'] == "rectorado") {
                    echo '<div style="display: flex; align-items: center;" >
        <form action="matriculacion.php" method="post" id="actForm">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <button id="actualizar" class="hand-cursor" type="submit" value="' . $row['id'] . '" style="background-color: var(--c);">
            <i class="fas fa-user-check" style="font-size: 28px; color: #ec1d17;"></i>
            </button>
        </form>
        </div>';
                } elseif ($_SESSION['rol'] == "secretariado") {

                    echo '<div style="display: flex; align-items: center;" >
        <form action="matriculacion.php" method="post" id="actForm">
            <input type="hidden" name="id" value="' . $row['id'] . '">
            <button id="actualizar" class="hand-cursor" type="submit" value="' . $row['id'] . '" style="background-color: var(--c);">
            <i class="fas fa-user-check" style="font-size: 28px; color: #ec1d17;"></i>
            </button>
        </form>';

                    echo ' <form action="../controller/eliminar_prematricula.php" method="post" id="eliminarForm">
        <input type="hidden" name="id" value="' . $row['id'] . '">
        <button class="hand-cursor" type="button" onclick="alerta_eliminar(' . $row['id'] . ')" style="background-color: var(--c);">
            <i class="fas fa-trash-alt" style="font-size: 28px; color: #ec1d17; margin-left:10px;"></i>
        </button>
    </form>
</div>';
                }

                echo '</td>';
            }
            ?>

        </tbody>
    </table>






</main>



<?php
include_once "./header.php";
?>
<script src="../js/menu.js"></script>
<script src="../js/tema.js"></script>
<script src="../src/datables/jquery-3.5.1.js"></script>
<script src="../js/calendario.js"></script>
<script src="../js/eliminar_prematricula.js"></script>



<script src="../src/datables/DataTables-1.13.4/js/jquery.dataTables.min.js"></script>
<script src="../src/datables/Responsive-2.4.1/js/dataTables.responsive.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable({
            responsive: true,
            autoWidth: true,
            language: {
                url: '../src/datables/español.json',
            },
        });
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
   // Función para cerrar la sesión
function cerrarSesion() {
    // Redirige a un script PHP que destruirá la sesión
    window.location.href = '../model/cerrar_session.php';
}

// Manejar el evento de carga de la página y el evento popstate
window.addEventListener('load', function() {
    cerrarSesionOnPageLoad();
});

window.addEventListener('popstate', function() {
    cerrarSesionOnPageLoad();
});

function cerrarSesionOnPageLoad() {
    // Verifica si la página se está cargando desde el historial de navegación
    if (window.performance && window.performance.navigation.type === 2) {
        console.log('Evento de retroceso/avance detectado');
        cerrarSesion();
    }
}

</script>