function validarImagen(event, previewId, errorMessageId) {
    var input = event.target;
    var archivo = input.files[0];

    if (archivo) {
        var extension = archivo.name.split('.').pop().toLowerCase();
        if (extension === 'jpeg' || extension === 'jpg' || extension === 'png') {
            var imagenPreview = document.getElementById(previewId);
            imagenPreview.src = URL.createObjectURL(archivo);
            imagenPreview.style.display = "block";

            var mensajeError = document.getElementById(errorMessageId);
            mensajeError.style.display = "none";
        } else {
            var mensajeError = document.getElementById(errorMessageId);
            mensajeError.innerText = "Solo se permiten archivos JPEG y PNG.";
            mensajeError.style.display = "block";

            var imagenPreview = document.getElementById(previewId);
            imagenPreview.style.display = "none";
            input.value = "";
        }
    }
}


function ocultarImagen(event) {
    var imagenContainer = document.getElementById("imagen-container");
    var mensajeError = document.getElementById("mensaje-error");

    if (event.target.files && event.target.files[0]) {
        imagenContainer.style.display = "none";
    } else {
        imagenContainer.style.display = "block";
    }

    mensajeError.style.display = "none";
}