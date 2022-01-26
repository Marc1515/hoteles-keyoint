$(document).ready(function(){

    $('#enviarCorr').submit(function(){
    
        var notifiCliente =$ ("input[name='styled_radio']:checked").val();
    
        console.log(notifiCliente);

        if(notifiCliente==1) {

            $('#enviarCorr').click(function(){


                var nombre = document.getElementById('operador').value;
                var nomApe = document.getElementById('nombre').value;
                var correo = document.getElementById('example-email').value;
                var lastReserva = document.getElementById('lastReserva').value;
                var localizador = document.getElementById('localizador').value;
                var entrada = document.getElementById('example-date-input').value;
                var salida = document.getElementById('example-date-input2').value;
                var movilOper = document.getElementById('movilOperador').value;
                var pin = document.getElementById('pinEntrada').value;
                var ubi = document.getElementById('ubiLocker').value;


                var ruta = "NomApe="+nomApe+"&Cor="+correo+"&Reserva="+lastReserva+"&Loc="+localizador+"&oper="+nombre+"&entrada="+entrada+"&salida="+salida+"&movilOper="+movilOper+"&pin="+pin+"&ubi="+ubi;

                $.ajax({
                    url: 'email.php',
                    type: 'POST',
                    data: ruta

                })
                .done(function() {
                    console.log("success");
                    
                })
                /* .done(function() {
                    console.log("error");
                }) */
                .done(function() {
                    console.log("complete");
                })


            })

        }

    })

})
