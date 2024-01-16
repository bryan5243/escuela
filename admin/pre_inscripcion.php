<?php
session_start();
use PgSql\Connection\Connection;

?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/pre_inscripcion.css">
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
    <form action="" method="post" id="preInscripcionForm">
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
                <label for="direcciones" class="form-label">4. Dirección:</label>
                <input type="text" class="form-control" name="nombres" required>
            </div>
        </div>


        <div class="mb-3">
            <label for="discapacidad" class="form-label">4. Posee algún tipo de discapacidad:</label>
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
                        <label for="tipoDiscapacidad" class="form-label">5. Tipo de discapacidad:</label>
                        <input type="text" class="form-control" name="tipoDiscapacidad" id="tipoDiscapacidad" disabled>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="porcentajeDiscapacidad" class="form-label">6. Porcentaje:</label>
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
                    <label for="cedulaPadre" class="form-label">7. Cedula:</label>
                    <input type="text" class="form-control" name="cedulaPadre" id="cedulaPadre" required>
                </div>

                <div class="mb-3">
                    <label for="apellidosNombresPadre" class="form-label">8. Apellidos y Nombres:</label>
                    <input type="text" class="form-control" name="apellidosNombresPadre" id="apellidosNombresPadre"
                        required>
                </div>

                <div class="mb-3">
                    <label for="telefonoPadre" class="form-label">9. Teléfono Celular:</label>
                    <input type="text" class="form-control" id="telefonoPadre" name="telefonoPadre">
                </div>
            </div>

            <div class="col-md-6">
                <h2>Madre:</h2>

                <div class="mb-3">
                    <label for="cedulaMadre" class="form-label">10. Cedula:</label>
                    <input type="text" class="form-control" name="cedulaMadre" id="cedulaMadre" required>
                </div>

                <div class=" mb-3">
                    <label for="apellidosNombresMadre" class="form-label">11. Apellidos y Nombres:</label>
                    <input type="text" class="form-control" name="apellidosNombresMadre" id="apellidosNombresMadre"
                        required>
                </div>

                <div class=" mb-3">
                    <label for="telefonoMadre" class="form-label">12. Teléfono Celular:</label>
                    <input type="text" class="form-control" id="telefonoMadre" name=" telefonoMadre">
                </div>
            </div>

            <div class="col-md-6 mx-auto">
                <h2>Representante:</h2>

                <div class="mb-3">
                    <label for="tipoRepresentante" class="form-label">Tipo de Representante:</label>
                    <select class="form-select" id="tipoRepresentante" onchange="mostrarCampos(this.value)">
                        <option value="" selected disabled>Seleccione un representante</option>

                        <option value="padre">Padre</option>
                        <option value="madre">Madre</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cedulaRepresentante" class="form-label">7. Cedula:</label>
                    <input type="text" class="form-control" name="cedulaRepresentante" id="cedulaRepresentante"
                        required>
                </div>

                <div class="mb-3">
                    <label for="apellidosNombresRepresentante" class="form-label">8. Apellidos y Nombres:</label>
                    <input type="text" class="form-control" name="apellidosNombresRepresentante"
                        id="apellidosNombresRepresentante" required>
                </div>

                <div class="mb-3">
                    <label for="telefonoRepresentante" class="form-label">9. Teléfono Celular:</label>
                    <input type="text" class="form-control" name="telefonoRepresentante" id="telefonoRepresentante">
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Enviar</button>

        </div>


    </form>
</main>


<script>
    function mostrarCampos(tipo) {
        // Obtén los elementos del formulario
        var cedulaRepresentante = document.getElementById('cedulaRepresentante');
        var apellidosNombresRepresentante = document.getElementById('apellidosNombresRepresentante');
        var telefonoRepresentante = document.getElementById('telefonoRepresentante');

        // Reinicia los valores y deshabilita los campos
        cedulaRepresentante.value = '';
        apellidosNombresRepresentante.value = '';
        telefonoRepresentante.value = '';
        cedulaRepresentante.disabled = true;
        apellidosNombresRepresentante.disabled = true;
        telefonoRepresentante.disabled = true;

        // Muestra datos según la selección
        if (tipo === 'madre') {
            var cedulaMadre = document.getElementById('cedulaMadre');
            var apellidosNombresMadre = document.getElementById('apellidosNombresMadre');
            var telefonoMadre = document.getElementById('telefonoMadre');

            cedulaRepresentante.value = cedulaMadre.value;
            apellidosNombresRepresentante.value = apellidosNombresMadre.value;
            telefonoRepresentante.value = telefonoMadre.value;

            // Deshabilita los campos del padre
            cedulaRepresentante.disabled = true;
            apellidosNombresRepresentante.disabled = true;
            telefonoRepresentante.disabled = true;

        } else if (tipo === 'padre') {
            var cedulaPadre = document.getElementById('cedulaPadre');
            var apellidosNombresPadre = document.getElementById('apellidosNombresPadre');
            var telefonoPadre = document.getElementById('telefonoPadre');

            cedulaRepresentante.value = cedulaPadre.value;
            apellidosNombresRepresentante.value = apellidosNombresPadre.value;
            telefonoRepresentante.value = telefonoPadre.value;


            // Deshabilita los campos del padre
            cedulaRepresentante.disabled = true;
            apellidosNombresRepresentante.disabled = true;
            telefonoRepresentante.disabled = true;


        } else if (tipo === 'otros') {
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