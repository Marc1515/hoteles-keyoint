$('#enviarLocalizador').click(function(){

    var localizador = document.getElementById('localizador').value;
    

    var ruta = "localizador=" + localizador;


    $.ajax({

        url: 'cambiarEstado_validate.php',
        type: 'POST',
        data: ruta
        
    })
    .done(function(){
        console.log('success');
        console.log(ruta);
    })
    .fail(function(){
        console.log('error');
        
    })
    .always(function(){
        
    })

})