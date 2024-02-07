document.addEventListener('DOMContentLoaded', function () {
    // Obtener referencia al campo de fecha de nacimiento
    var fechaNacimientoInput = document.getElementById('fecha_nacimiento_estudiante');

    // Obtener la fecha actual en formato ISO
    var fechaActual = new Date().toISOString().split('T')[0];

    // Establecer el atributo 'max' del campo de fecha al valor actual
    fechaNacimientoInput.setAttribute('max', fechaActual);
});

// Función para validar cédula, limitar longitud a 10 caracteres y permitir solo números
function validarCedula(inputElement) {
    inputElement.addEventListener("input", function () {
        this.value = this.value.slice(0, 10).replace(/[^0-9]/g, '');
    });
}

// Función para validar código único, limitar longitud a 10 caracteres y permitir solo números
function validarCodigoUnico(inputElement) {
    inputElement.addEventListener("input", function () {
        this.value = this.value.slice(0, 10).replace(/[^0-9]/g, '');
    });
}

function formatearNombres(inputElement) {
    inputElement.addEventListener("input", function () {
        // Validar que solo se ingresen letras
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]/g, '');

        // Si el valor es completamente en mayúsculas, convertir a formato título
        if (this.value === this.value.toUpperCase()) {
            this.value = this.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
        } else {
            // Si contiene alguna minúscula, aplicar el formato normal
            this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
        }
    });
}



// Función para validar la fecha de nacimiento, evitando fechas futuras
function validarFechaNacimiento(inputElement) {
    var fechaActual = obtenerFechaActual();

    inputElement.addEventListener("input", function () {
        if (this.value > fechaActual) {
            alert("No se permite seleccionar fechas futuras.");
            this.value = fechaActual;
        }
    });

    inputElement.max = fechaActual;
}

// Función para obtener la fecha actual en formato ISO
function obtenerFechaActual() {
    return new Date().toISOString().split('T')[0];
}

function validarTexto(input) {
    // Eliminar caracteres no permitidos (números)
    input.value = input.value.replace(/[^A-Za-zÁÉÍÓÚáéíóúñÑüÜ ]/g, "");

    // Si el valor es completamente en mayúsculas, convertir a formato título
    if (this.value === this.value.toUpperCase()) {
        this.value = this.value.toLowerCase().replace(/\b\w/g, l => l.toUpperCase());
    } else {
        // Si contiene alguna minúscula, aplicar el formato normal
        this.value = this.value.replace(/\b\w/g, l => l.toUpperCase());
    }

    // También puedes mostrar un mensaje de error si lo deseas
    if (input.validity.patternMismatch) {
        input.setCustomValidity("Solo se permiten letras y espacios");
    } else {
        input.setCustomValidity("");
    }
}


validarFechaNacimiento(document.getElementById("fecha_nacimiento_estudiante"));