function cargarParalelos() {
    var selectedGrado = document.getElementById('grado').value;
    console.log("Selected Grado: " + selectedGrado);

    // Realizar una solicitud Fetch para obtener los paralelos
    fetch("../controller/obtener_paralelos.php?grado=" + encodeURIComponent(selectedGrado))
        .then(response => {
            if (!response.ok) {
                throw new Error('La red no respondió correctamente');
            }
            return response.json();
        })
        .then(paralelos => {

            // Obtener el select de paralelos
            var paraleloSelect = document.getElementById('id_paralelo_estudiante');

            // Limpiar las opciones actuales
            paraleloSelect.innerHTML = "";

            // Llenar el select con las opciones recibidas del servidor
            paralelos.forEach(paralelo => {
                var option = document.createElement('option');
                option.value = paralelo.id;
                option.text = paralelo.paralelo;
                paraleloSelect.add(option);
            });
        })
        .catch(error => {
            console.error('Error:', error.message);
            // Manejar el error de manera adecuada, por ejemplo, mostrando un mensaje al usuario.
        });
}