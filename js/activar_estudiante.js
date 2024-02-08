function alerta_eliminar(estudiante) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, Activalo!'
    }).then((result) => {
        if (result.isConfirmed) {
            mandar_php(estudiante)
        }
    });
}

 
function mandar_php(estudiante){
    parametros= {id:estudiante};
    $.ajax({
        data:parametros,
        url:"../Controller/activar_estudiante.php",
        type:"POST",
        beforeSend:function() {},
        success:function(){
            Swal.fire("Activado!","El estudiante ha sido Activado.","success").then((result) =>{
                window,location.href="./listado_estudiantes.php"
            });
        },
    });

}