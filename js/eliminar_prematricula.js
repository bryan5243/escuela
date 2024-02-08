function alerta_eliminar(estudiante) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, bórralo!'
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
        url:"../Controller/eliminar_prematricula.php",
        type:"POST",
        beforeSend:function() {},
        success:function(){
            Swal.fire("Eliminado!","El estudiante ha sido eliminado.","success").then((result) =>{
                window,location.href="dashboard.php"
            });
        },
    });

}