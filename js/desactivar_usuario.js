function alerta_eliminar(usuarios) {
    Swal.fire({
        title: 'Estas seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: '¡Sí, Desactivalo!'
    }).then((result) => {
        if (result.isConfirmed) {
            mandar_php(usuarios)
        }
    });
}

 
function mandar_php(usuarios){
    parametros= {id:usuarios};
    $.ajax({
        data:parametros,
        url:"../Controller/desactivar_usuarios.php",
        type:"POST",
        beforeSend:function() {},
        success:function(){
            Swal.fire("Desactivado!","El usuario ha sido Desactivado.","success").then((result) =>{
                window,location.href="./tab_opciones.php"
            });
        },
    });

}