$('#enviar').click(function(){

    var entradaDesde = document.getElementById('example-date-input').value;

    var entradaHasta = document.getElementById('example-date-input2').value;

    var estado = 9 /* document.getElementById('inlineFormCustomSelect').value */;
    

    var ruta = "desde=" + entradaDesde + "&hasta=" + entradaHasta + "&estado=" + estado;


    $.ajax({

        url: 'listticket_reservas.php',
        type: 'POST',
        data: ruta

        
    })
    .done(function(){
        /* $('#respuesta').html(res.status);
        console.log(res);
        const lista = document.getElementById('example23');
        console.log(lista);
        lista.remove(); */
        console.log('success');
        console.log(ruta);
    })
    .fail(function(){
        /* $('#respuesta').html(res); */
        console.log('error');
        
    })
    .always(function(){
        
    })

})

/* $(document).ready(function(){
    $("#enviar").on('click', function(){
        $(".table-responsive").remove();
    });
}); */