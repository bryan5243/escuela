<?php
session_start();
include_once '../model/conexion.php'; 
?>
<html lang="es">
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="icon" href="../img/logo23.ico" type="image/x-icon">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="../css/pre_inscripcion.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<title>Inscripción</title>
</head>
<style>
    .card {
        display: flex;
        flex-direction: column;
        align-items: center;
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
        margin-top: 10px;
        /* Ajusta el margen superior según tus preferencias */
    }

    .school-info {
        background-color: #ff0000;
        padding: 10px;
        /* Aumentamos el padding para mejorar la legibilidad */
        border-radius: 10px;
        margin-top: 10px;
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

    @media (max-width: 767px) {
        .logo-container {
            margin-right: 0;
            /* Eliminamos el margen a la derecha en dispositivos móviles */
        }

        .school-info {
            padding: 0;
            /* Aumentamos el padding en dispositivos móviles para una mejor legibilidad */
        }
    }
</style>

<body>
    <main class="container mt-5">
        <form action="#" method="post" id="formularioInscripcion">
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
                    <label for="nacionalidad" class="form-label">Nacionalidad:</label>
                    <select class="form-select" name="nacionalidad" id="nacionalidad" onchange="verificarNacionalidad()" required>
                        <option value="" selected disabled>Seleccione una opcion</option>

                        <option value="ecuatoriano">Ecuatoriano</option>
                        <option value="extranjero">Extranjero</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cedula" class="form-label">1. Cedula:</label>
                    <input type="text" class="form-control" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" name="cedula" id="cedula" oninput="verificarCedula()" required>
                    <div id="mensaje"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="apellidos" class="form-label">2. Apellidos:</label>
                        <input type="text" class="form-control" name="apellidos" oninput="validarTexto(this)" required>
                    </div>

                </div>
                <div class="col-md-6">

                    <div class="mb-3">
                        <label for="nombres" class="form-label">3. Nombres:</label>
                        <input type="text" class="form-control" name="nombres" oninput="validarTexto(this)" required>
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
                <select class="form-select" name="discapacidad" id="discapacidad" required onchange="toggleCamposDiscapacidad()">
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
                            <input type="text" class="form-control" name="porcentajeDiscapacidad" id="porcentajeDiscapacidad" disabled>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h2>Padre:</h2>
                    <div class="mb-3">
                        <label for="nacionalidad_padre" class="form-label">Nacionalidad del Padre:</label>
                        <select class="form-select" name="nacionalidad_padre" id="nacionalidad_padre" oninput="verificarNacionalidadPadre()" required>
                            <option value="" selected disabled>Seleccione una opcion</option>

                            <option value="ecuatoriano">Ecuatoriano</option>
                            <option value="extranjero">Extranjero</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cedula_Padre" class="form-label">Cédula del Padre:</label>
                        <input type="text" class="form-control" name="cedula_Padre" id="cedula_Padre" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); verificarNacionalidadPadre()" required>
                        <div id="mensaje_padre"></div>

                    </div>

                    <div class="mb-3">
                        <label for="apellidosNombres_Padre" class="form-label">9. Apellidos y Nombres:</label>
                        <input type="text" class="form-control" name="apellidosNombres_Padre" id="apellidosNombres_Padre" oninput="validarTexto(this)" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono_Padre" class="form-label">10. Teléfono Celular:</label>
                        <input type="text" class="form-control" id="telefono_Padre" name="telefono_Padre" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" require>
                    </div>
                </div>

                <div class="col-md-6">
                    <h2>Madre:</h2>
                    <div class="mb-3">
                        <label for="nacionalidad_Madre" class="form-label">Nacionalidad de la Madre:</label>
                        <select class="form-select" name="nacionalidad_Madre" id="nacionalidad_Madre" onchange="verificarNacionalidadMadre()" required>
                            <option value="" selected disabled>Seleccione una opcion</option>

                            <option value="ecuatoriana">Ecuatoriana</option>
                            <option value="extranjera">Extranjera</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cedula_Madre" class="form-label">11. Cedula:</label>
                        <input type="text" class="form-control" id="cedula_Madre" name="cedula_Madre" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); verificarNacionalidadMadre()" required>
                        <div id="mensaje_madre"></div>
                    </div>

                    <div class=" mb-3">
                        <label for="apellidosNombres_Madre" class="form-label">12. Apellidos y Nombres:</label>
                        <input type="text" class="form-control" id="apellidosNombres_Madre" name="apellidosNombres_Madre" oninput="validarTexto(this)" required>
                    </div>

                    <div class=" mb-3">
                        <label for="telefono_Madre" class="form-label">13. Teléfono Celular:</label>
                        <input type="text" class="form-control" id="telefono_Madre" name=" telefono_Madre" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" require>
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
                        <label for="nacionalidad_Representante" class="form-label">Nacionalidad del Representante:</label>
                        <select class="form-select" name="nacionalidad_Representante" id="nacionalidad_Representante" onchange="verificarNacionalidadRepresentante()" required>
                            <option value="" selected disabled>Seleccione una opcion</option>

                            <option value="ecuatoriano">Ecuatoriano</option>
                            <option value="extranjero">Extranjero</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="cedula_Representante" class="form-label">14. Cedula:</label>
                        <input type="text" class="form-control" id="cedula_Representante" name="cedula_Representante" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10); verificarNacionalidadRepresentante()" required>
                        <div id="mensaje_representante"></div>
                    </div>


                    <div class="mb-3">
                        <label for="apellidosNombres_Representante" class="form-label">15. Apellidos y Nombres:</label>
                        <input type="text" class="form-control" id="apellidosNombres_Representante" name="apellidosNombres_Representante" oninput="validarTexto(this)" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono_Representante" class="form-label">16. Teléfono Celular:</label>
                        <input type="text" class="form-control" id="telefono_Representante" name="telefono_Representante" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10)" require>
                    </div>
                </div>

                <button type="button" class="btn btn-primary" onclick="validarYEnviar()">Enviar</button>

            </div>

        </form>

    </main>

</body>

<script>
    // Función para validar campos y mostrar alerta
    function validarYEnviar() {
        // Validar si todos los campos están llenos
        var formValido = true;
        $('input, select').each(function() {
            if ($(this).prop('required') && $(this).val() === '') {
                formValido = false;
                return false; // Salir del bucle si encuentra un campo vacío
            }
        });

        // Si algún campo está vacío, mostrar SweetAlert
        if (!formValido) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Rellene todos los campos por favor',
            });
            return;
        }

        // Si todos los campos están llenos, enviar el formulario con AJAX
        $.ajax({
            url: 'guardar_incripcion.php', // Reemplaza esto con la URL del archivo de guardado
            method: 'POST',
            data: $('#formularioInscripcion').serialize(),
            success: function(response) {
                console.log($('#formularioInscripcion').serialize());

                Swal.fire({
                    title: "Éxito",
                    text: "Los datos se han guardado correctamente.",
                    icon: "success",
                    confirmButtonText: "Aceptar",
                    showCancelButton: false
                }).then((result) => {
                    // Redirige a la página después de hacer clic en "Aceptar y redirigir"
                    if (result.isConfirmed) {
                        window.location.href = "../index.php"; // Reemplaza con la URL de tu página destino
                    }
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Hubo un problema al enviar el formulario',
                });
            },
        });
    }
</script>











<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function() {
        // Función para verificar la cédula en tiempo real
        function verificarCedula() {
            var cedula = $("#cedula").val();

            // Realizar una solicitud AJAX para verificar la existencia en la base de datos
            $.ajax({
                type: "POST",
                url: "verificar_cedula.php",
                data: {
                    cedula: cedula
                },
                success: function(response) {
                    if (response.trim() === "existente") {
                        $("#mensaje").html("<span style='color:red;'>Estudiante ya inscrito</span>");
                    } else {
                        // Si la cédula no está registrada, realizar la validación ecuatoriana
                        validarCedulaEcuatoriana(cedula);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", error);
                    // Manejar errores según sea necesario
                }
            });
        }

        // Agregar el evento oninput al campo de cédula
        $("#cedula").on("input", verificarCedula);

        // Función para validar la cédula ecuatoriana
        function validarCedulaEcuatoriana(cedula) {
            var mensajeDiv = $("#mensaje");

            // Verificar si la cédula tiene 10 dígitos
            if (cedula.length === 10) {
                // Coeficientes para el cálculo del dígito verificador
                var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

                // Calcular el dígito verificador
                var total = 0;
                for (var i = 0; i < 9; i++) {
                    var digito = parseInt(cedula[i]);
                    var resultado = digito * coeficientes[i];
                    total += (resultado > 9) ? resultado - 9 : resultado;
                }

                var verificadorCalculado = (total % 10 === 0) ? 0 : 10 - (total % 10);

                // Verificar que el dígito verificador coincida
                if (verificadorCalculado !== parseInt(cedula[9])) {
                    mensajeDiv.html("<span style='color:red;'>Numero de cedula no valido.</span>");
                } else {
                    mensajeDiv.html("<span style='color:green;'>Cédula válida</span>");
                }
            } else {
                mensajeDiv.html('La cédula debe tener 10 dígitos.');
            }
        }

        function verificarNacionalidad() {
            var nacionalidadSelect = $("#nacionalidad");

            // Limpiar el mensaje al cambiar la nacionalidad
            $("#mensaje").html("");

            if (nacionalidadSelect.val() === "extranjero") {
                // Si la nacionalidad es extranjera, no realizar más validaciones
                return;
            }

            // Si la nacionalidad es ecuatoriana, realizar la validación de cédula
            verificarCedula();
        }

        // Agregar el evento onchange al campo de nacionalidad
        $("#nacionalidad").on("change", verificarNacionalidad);
    });
</script>

<script>
    // Agregar el evento onchange al campo de nacionalidad del padre
    function verificarNacionalidadPadre() {
        var nacionalidadPadre = $("#nacionalidad_padre").val();
        var cedulaPadre = $("#cedula_Padre").val();
        var mensajeDiv = $("#mensaje_padre");

        // Limpiar el mensaje
        mensajeDiv.html("");

        // Verificar nacionalidad
        if (nacionalidadPadre === "ecuatoriano") {
            validarCedulaEcuatoriana(cedulaPadre, mensajeDiv);
        }
    }

    // Función para validar la cédula ecuatoriana
    function validarCedulaEcuatoriana(cedula, mensajeDiv) {
        // Verificar si la cédula tiene 10 dígitos
        if (cedula.length === 10) {
            // Coeficientes para el cálculo del dígito verificador
            var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

            // Calcular el dígito verificador
            var total = 0;
            for (var i = 0; i < 9; i++) {
                var digito = parseInt(cedula[i]);
                var resultado = digito * coeficientes[i];
                total += (resultado > 9) ? resultado - 9 : resultado;
            }

            var verificadorCalculado = (total % 10 === 0) ? 0 : 10 - (total % 10);

            // Verificar que el dígito verificador coincida
            if (verificadorCalculado !== parseInt(cedula[9])) {
                mensajeDiv.html("<span style='color:red;'>Número de cédula no válido.</span>");
            } else {
                mensajeDiv.html("<span style='color:green;'>Cédula válida</span>");
            }
        } else {
            mensajeDiv.html('La cédula debe tener 10 dígitos.');
        }
    }
</script>


<script>
    function verificarNacionalidadMadre() {
        var nacionalidadMadre = $("#nacionalidad_Madre").val();
        var cedulaMadre = $("#cedula_Madre").val();
        var mensajeDiv = $("#mensaje_madre");

        // Limpiar el mensaje
        mensajeDiv.html("");

        // Verificar nacionalidad
        if (nacionalidadMadre === "ecuatoriana") {
            validarCedulaEcuatoriana(cedulaMadre, mensajeDiv);
        }
    }

    function validarCedulaEcuatoriana(cedula, mensajeDiv) {
        // Verificar si la cédula tiene 10 dígitos
        if (cedula.length === 10) {
            // Coeficientes para el cálculo del dígito verificador
            var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

            // Calcular el dígito verificador
            var total = 0;
            for (var i = 0; i < 9; i++) {
                var digito = parseInt(cedula[i]);
                var resultado = digito * coeficientes[i];
                total += (resultado > 9) ? resultado - 9 : resultado;
            }

            var verificadorCalculado = (total % 10 === 0) ? 0 : 10 - (total % 10);

            // Verificar que el dígito verificador coincida
            if (verificadorCalculado !== parseInt(cedula[9])) {
                mensajeDiv.html("<span style='color:red;'>Número de cédula no válido.</span>");
            } else {
                mensajeDiv.html("<span style='color:green;'>Cédula válida</span>");
            }
        } else {
            mensajeDiv.html('La cédula debe tener 10 dígitos.');
        }
    }
</script>

<script>
    function verificarNacionalidadRepresentante() {
        var nacionalidadRepresentante = $("#nacionalidad_Representante").val();
        var cedulaRepresentante = $("#cedula_Representante").val();
        var mensajeDiv = $("#mensaje_representante");

        // Limpiar el mensaje
        mensajeDiv.html("");

        // Verificar nacionalidad
        if (nacionalidadRepresentante === "ecuatoriano") {
            validarCedulaEcuatoriana(cedulaRepresentante, mensajeDiv);
        }
    }

    function validarCedulaEcuatoriana(cedula, mensajeDiv) {
        // Verificar si la cédula tiene 10 dígitos
        if (cedula.length === 10) {
            // Coeficientes para el cálculo del dígito verificador
            var coeficientes = [2, 1, 2, 1, 2, 1, 2, 1, 2];

            // Calcular el dígito verificador
            var total = 0;
            for (var i = 0; i < 9; i++) {
                var digito = parseInt(cedula[i]);
                var resultado = digito * coeficientes[i];
                total += (resultado > 9) ? resultado - 9 : resultado;
            }

            var verificadorCalculado = (total % 10 === 0) ? 0 : 10 - (total % 10);

            // Verificar que el dígito verificador coincida
            if (verificadorCalculado !== parseInt(cedula[9])) {
                mensajeDiv.html("<span style='color:red;'>Número de cédula no válido.</span>");
            } else {
                mensajeDiv.html("<span style='color:green;'>Cédula válida</span>");
            }
        } else {
            mensajeDiv.html('La cédula debe tener 10 dígitos.');
        }
    }
</script>



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
<script src="../js/re_estudiante.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../src/sweetalert2/dist/sweetalert2.all.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>