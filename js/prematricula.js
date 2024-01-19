 src = "https://cdn.jsdelivr.net/npm/sweetalert2@11"

 // Obtener elementos del DOM
 const matriculaLink = document.getElementById('matriculaLink');
 const redirectButton = document.getElementById('redirectButton');

 // Deshabilitar el enlace al cargar la página
 matriculaLink.classList.add('disabled');

 // Función para mostrar la alerta
 function mostrarAlerta() {
     Swal.fire({
         title: 'Escoja un estudiante de prematrícula',
         icon: 'info',
         showCancelButton: true,
         confirmButtonText: 'OK',
         cancelButtonText: 'Prematrícula',
     }).then((result) => {
         if (result.isConfirmed) {
             // Redirigir a la página de matrícula si se hace clic en OK
             window.location.href = 'matriculacion.php';
         }
     });
 }

 // Habilitar el enlace cuando se hace clic en el botón de redirección
 redirectButton.addEventListener('click', () => {
     matriculaLink.classList.remove('disabled');
     // Mostrar la alerta
     mostrarAlerta();
 });