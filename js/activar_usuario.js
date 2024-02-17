function alerta_activar(usuarios) {
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
            mandar_php2(usuarios)
        }
    });
}

 
function mandar_php2(usuarios){
    parametros= {id:usuarios};
    $.ajax({
        data:parametros,
        url:"../Controller/activar_usuarios.php",
        type:"POST",
        beforeSend:function() {},
        success:function(){
            Swal.fire("Activado!","El usuario ha sido Activado.","success").then((result) =>{
                window,location.href="./tab_opciones.php"
            });
        },
    });

}