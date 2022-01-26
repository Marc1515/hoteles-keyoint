$('#enviar').click(function(){

    var nombre = document.getElementById('nombreReserva').value;

    var ruta = "nom="+nombre;


    $.ajax({

        url: 'reservas_nombre_validate.php',
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