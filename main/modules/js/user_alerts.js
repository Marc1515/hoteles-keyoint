$('#crearUser').click(function(){

    $.ajax({

        url: 'crear_user_validate.php',
        type: 'POST',
        data: ruta,
        dataType: 'json',
    })
    .done(function(res){
        $('#respuesta').html(res.status);
        console.log(res);
    })
    .fail(function(res){
        $('#respuesta').html(res);
        console.log(res.status);
    })
    .always(function(){
        console.log("complete");
    })

})