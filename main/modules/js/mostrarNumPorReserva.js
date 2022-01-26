$('#enviar').click(function(){

    var numero = document.getElementById('numReserva').value;

    var ruta = "num="+numero;


    $.ajax({

        url: 'reservas_numero_validate.php',
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