$('#enviarCorr').click(function(){

    var nombre = document.getElementById('operador').value;
    var nomApe = document.getElementById('nombre').value;
    var correo = document.getElementById('example-email').value;
    var lastReserva = document.getElementById('idReserva').value;
    var localizador = document.getElementById('localizador').value;
    var entrada = document.getElementById('example-date-input').value;
    var salida = document.getElementById('example-date-input2').value;
    var movilOper = document.getElementById('movilOperador').value;
    var pin = document.getElementById('pinEntrada').value;

    /* var codigoQR = document.getElementById('codigoQR').value; */

    var ruta = "NomApe="+nomApe+"&Cor="+correo+"&Reserva="+lastReserva+"&Loc="+localizador+"&oper="+nombre+"&entrada="+entrada+"&salida="+salida+"&movilOper="+movilOper+"&pin="+pin;

    $.ajax({
        url: 'email_actualizacion.php',
        type: 'POST',
        data: ruta

    })
    .done(function(/* res */) {
        console.log("success");
        /* $('#respuesta').html(res); */
    })
    /* .done(function() {
        console.log("error");
    }) */
    .done(function() {
        console.log("complete");
    })


})
