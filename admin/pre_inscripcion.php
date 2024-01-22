<?php
session_start();
use PgSql\Connection\Connection;

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/pre_inscripcion.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .card {
        display: center;
        justify-content: center;
        align-items: center;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 20px;
        width: 1000px;
        /* Puedes ajustar el ancho según tus necesidades */
        margin: 10 auto;
    }

    .logo-container {
        margin-right: 20px;
        /* Espacio entre el logo y la información de la escuela */

        text-align: flex;
    }

    .logo {
        width: 150px;
        height: 150px;
        text-align: center;
    }

    .school-container {
        text-align: center;
    }

    .school-info {
        background-color: #ff0000;
        padding: 0px;
        border-radius: 10px;
        margin-top: 0px;
    }

    .school-info h2 {
        color: black;
        /* Cambiamos el color del texto a negro */
        margin-bottom: 0;
        /* Ajustamos el margen inferior para reducir el espacio debajo del texto */
    }

    h2 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    h3 {
        font-size: 24px;
        margin-bottom: 5px;
    }

    .small-text {
        font-size: 12px;
        margin-bottom: 2px;
    }
</style>


<main class="container mt-5">
    <form action="#" method="post" id="preInscripcionForm">
        <div class="card">
            <img src="../img/logo.jpeg" alt="Avatar Logo" class="logo">
            <div class="school-container">
                <h3>ESCUELA DE EDUCACIÓN BÁSICA PARTICULAR</h3>
                <div class="school-info">
                    <h2>“LAS ÁGUILAS DEL SABER”</h2>
                </div>
                <p class="small-text">RESOLUCIÓN: DEO-DPE: 109-2009</p>
                <p class="small-text">AMIE: 07H01462</p>
                <p class="small-text">EL CAMBIO-MACHALA-ECUADOR</p>
            </div>
        </div>

        <h2>Estudiante</h2>
        <div class="row">
            <div class="mb-3">
                <label for="cedula" class="form-label">1. Cedula:</label>
                <input type="text" class="form-control" name="cedula" required>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="apellidos" class="form-label">2. Apellidos:</label>
                    <input type="text" class="form-control" name="apellidos" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="nombres" class="form-label">3. Nombres:</label>
                    <input type="text" class="form-control" name="nombres" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <label for="direccion" class="form-label">4. Dirección:</label>
                <input type="text" class="form-control" name="direccion" required>
            </div>
        </div>


        <div class="mb-3">
            <label for="discapacidad" class="form-label">5. Posee algún tipo de discapacidad:</label>
            <select class="form-select" name="discapacidad" id="discapacidad" required
                onchange="toggleCamposDiscapacidad()">
                <option value="" selected disabled>¿Tiene alguna discapacidad?</option>
                <option value="si">Si</option>
                <option value="no">No</option>
            </select>
        </div>

        <div class="row">

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="tipoDiscapacidad" class="form-label">6. Tipo de discapacidad:</label>
                        <input type="text" class="form-control" name="tipoDiscapacidad" id="tipoDiscapacidad" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="porcentajeDiscapacidad" class="form-label">7. Porcentaje:</label>
                        <input type="text" class="form-control" name="porcentajeDiscapacidad"
                            id="porcentajeDiscapacidad" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <h2>Padre:</h2>

                <div class="mb-3">
                    <label for="cedula_Padre" class="form-label">6. Cedula:</label>
                    <input type="text" class="form-control" name="cedula_Padre" id="cedula_Padre" required>
                </div>

                <div class="mb-3">
                    <label for="apellidosNombres_Padre" class="form-label">9. Apellidos y Nombres:</label>
                    <input type="text" class="form-control" name="apellidosNombres_Padre" id="apellidosNombres_Padre"
                        required>
                </div>

                <div class="mb-3">
                    <label for="telefono_Padre" class="form-label">10. Teléfono Celular:</label>
                    <input type="text" class="form-control" id="telefono_Padre" name="telefono_Padre">
                </div>
            </div>

            <div class="col-md-6">
                <h2>Madre:</h2>

                <div class="mb-3">
                    <label for="cedula_Madre" class="form-label">11. Cedula:</label>
                    <input type="text" class="form-control" id="cedula_Madre" name="cedula_Madre" required>
                </div>

                <div class=" mb-3">
                    <label for="apellidosNombres_Madre" class="form-label">12. Apellidos y Nombres:</label>
                    <input type="text" class="form-control" id="apellidosNombres_Madre" name="apellidosNombres_Madre"
                        required>
                </div>

                <div class=" mb-3">
                    <label for="telefono_Madre" class="form-label">13. Teléfono Celular:</label>
                    <input type="text" class="form-control" id="telefono_Madre" name=" telefono_Madre">
                </div>
            </div>

            <div class="col-md-6 mx-auto">
                <h2>Representante:</h2>

                <div class="mb-3">
                    <label for="tipoRepresentante" class="form-label">Tipo de Representante:</label>
                    <select class="form-select" id="tipoRepresentante" onchange="mostrarCampos(this.value)">
                        <option value="" selected disabled>Seleccione un representante</option>

                        <option value="Padre">Padre</option>
                        <option value="Madre">Madre</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cedula_Representante" class="form-label">14. Cedula:</label>
                    <input type="text" class="form-control" id="cedula_Representante" name="cedula_Representante"
                        required>
                </div>

                <div class="mb-3">
                    <label for="apellidosNombres_Representante" class="form-label">15. Apellidos y Nombres:</label>
                    <input type="text" class="form-control" id="apellidosNombres_Representante"
                        name="apellidosNombres_Representante" required>
                </div>

                <div class="mb-3">
                    <label for="telefono_Representante" class="form-label">16. Teléfono Celular:</label>
                    <input type="text" class="form-control" id="telefono_Representante" name="telefono_Representante">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>

        </div>


    </form>
    <?php
    include_once '../model/conexion.php';
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
';
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $pdo = conectarBaseDeDatos();

        try {
            $pdo->beginTransaction();

            // Obtener datos del formulario de Estudiante
            $cedulaEstudiante = $_POST['cedula'];
            $apellidosEstudiante = $_POST['apellidos'];
            $nombresEstudiante = $_POST['nombres'];
            $direccionEstudiante = $_POST['direccion'];
            $condicionEstudiante = ($_POST['discapacidad'] == 'si') ? 1 : 0; // Convert 'si' to 1, 'no' to 0
    
            // Insertar datos en la tabla Estudiante
            $stmtEstudiante = $pdo->prepare("INSERT INTO estudiante (cedula, apellidos, nombres, direccion, condicion) VALUES (?, ?, ?, ?, ?)");
            $stmtEstudiante->execute([
                $cedulaEstudiante,
                $apellidosEstudiante,
                $nombresEstudiante,
                $direccionEstudiante,
                $condicionEstudiante
            ]);

            $idEstudiante = $pdo->lastInsertId();

            // Verificar si el estudiante tiene discapacidad
            if ($_POST['discapacidad'] == 'si') {
                $tipoDiscapacidad = $_POST['tipoDiscapacidad'];
                $porcentajeDiscapacidad = $_POST['porcentajeDiscapacidad'];

                // Insertar datos en la tabla Discapacidad
                $stmtDiscapacidad = $pdo->prepare("INSERT INTO discapacidad (tipo, porcentaje, id_estudiante) VALUES (?, ?, ?)");
                $stmtDiscapacidad->execute([
                    $tipoDiscapacidad,
                    $porcentajeDiscapacidad,
                    $idEstudiante
                ]);
            }

            // Insertar datos en la tabla Persona y Rol para Mamá
            guardarPersonaRol($pdo, 'Madre', $idEstudiante);

            // Insertar datos en la tabla Persona y Rol para Papá
            guardarPersonaRol($pdo, 'Padre', $idEstudiante);

            // Insertar datos en la tabla Persona y Rol para Representante
            guardarPersonaRol($pdo, 'Representante', $idEstudiante);

            $pdo->commit();
            echo '
        <script>
            Swal.fire({
                title: "¡Prematrícula exitosa!",
                text: "Los datos se han guardado correctamente.",
                icon: "success",
                showConfirmButton: false,
                timer: 2000 // Cierra automáticamente después de 2 segundos
            }).then(function() {
                window.location.href = "pre_inscripcion.php";
            });
        </script>';
            exit();
        } catch (Exception $e) {
            $pdo->rollback();

            // Mostrar SweetAlert2 en caso de error
    
            exit();
        }
    }

    function guardarPersonaRol($pdo, $rol, $idEstudiante)
    {
        $cedulaPersona = $_POST['cedula_' . ucfirst($rol)];
        $apellidosNombresPersona = $_POST['apellidosNombres_' . ucfirst($rol)];
        $telefonoPersona = $_POST['telefono_' . ucfirst($rol)];

        $stmtPersona = $pdo->prepare("INSERT INTO persona (cedula, apellidos_nombres, telefono, id_estudiante) VALUES (?, ?, ?, ?)");
        $stmtPersona->execute([
            $cedulaPersona,
            $apellidosNombresPersona,
            $telefonoPersona,
            $idEstudiante
        ]);

        $idPersona = $pdo->lastInsertId();
        $stmtRol = $pdo->prepare("INSERT INTO rol (rol, id_persona) VALUES (?, ?)");
        $stmtRol->execute([$rol, $idPersona]);
    }
    ?>
</main>



<script>
    function mostrarCampos(tipo) {
        var cedulaRepresentante = document.getElementById('cedula_Representante');
        var apellidosNombresRepresentante = document.getElementById('apellidosNombres_Representante');
        var telefonoRepresentante = document.getElementById('telefono_Representante');

        cedulaRepresentante.value = '';
        apellidosNombresRepresentante.value = '';
        telefonoRepresentante.value = '';

        if (tipo === 'Madre') {
            var cedulaMadre = document.getElementById('cedula_Madre');
            var apellidosNombresMadre = document.getElementById('apellidosNombres_Madre');
            var telefonoMadre = document.getElementById('telefono_Madre');

            cedulaRepresentante.value = cedulaMadre.value;
            apellidosNombresRepresentante.value = apellidosNombresMadre.value;
            telefonoRepresentante.value = telefonoMadre.value;

        } else if (tipo === 'Padre') {
            var cedulaPadre = document.getElementById('cedula_Padre');
            var apellidosNombresPadre = document.getElementById('apellidosNombres_Padre');
            var telefonoPadre = document.getElementById('telefono_Padre');

            cedulaRepresentante.value = cedulaPadre.value;
            apellidosNombresRepresentante.value = apellidosNombresPadre.value;
            telefonoRepresentante.value = telefonoPadre.value;
        } else if (tipo === 'otros') {
            // Habilita los campos del representante solo en este caso
            cedulaRepresentante.disabled = false;
            apellidosNombresRepresentante.disabled = false;
            telefonoRepresentante.disabled = false;
        }
    }
</script>



<script>
    function toggleCamposDiscapacidad() {
        var discapacidadSelect = document.getElementById('discapacidad');
        var tipoDiscapacidadInput = document.getElementById('tipoDiscapacidad');
        var porcentajeDiscapacidadInput = document.getElementById('porcentajeDiscapacidad');

        if (discapacidadSelect.value === 'si') {
            tipoDiscapacidadInput.disabled = false;
            porcentajeDiscapacidadInput.disabled = false;
        } else {
            tipoDiscapacidadInput.disabled = true;
            porcentajeDiscapacidadInput.disabled = true;
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/pre_inscripcion.js"></script>