function cambiarPinEntrada(){

    let theObject = new XMLHttpRequest(); 
    
    theObject.onreadystatechange = function () {
        
        if(theObject.readyState === 4 && theObject.status === 200) {

            let resp = theObject.responseText;
            
            document.getElementById('pinEntrada').value = resp;
            
        }   
        
    };

    theObject.open('POST', '../ws/ws_reservas/ws_genPin.php', true);

    theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    theObject.send();

}



function cambiarPinSalida(){

    let theObject = new XMLHttpRequest(); 
    
    theObject.onreadystatechange = function () {
        
        if(theObject.readyState === 4 && theObject.status === 200) {

            let resp = theObject.responseText;
            
            document.getElementById('pinSalida').value = resp;
            
        }   
        
    };

    theObject.open('POST', '../ws/ws_reservas/ws_genPin.php', true);

    theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    theObject.send();

}


function cambiarPuertaEntrada() {

    var entrada = document.getElementById('example-date-input').value;
    
    /* console.log(entrada); */
    var dataString = 'entrada=' + entrada;
    jQuery.ajax({
      data: dataString,
      type: 'POST',
      dataType: 'json',
      url: '../ws/ws_reservas/ws_reserva2.php',
      success: function( payload ){
          
          if (payload.status == 'No hay puertas disponibles') {

            document.getElementById('enviarCorr').disabled = true;

        } else {

            document.getElementById('enviarCorr').disabled = false;

        }

        document.getElementById('idPuertaEntrada').value = payload.status;


      },
      error: function(){
        console.log('error');
        }
    });


};


function comprobarContrato() {

    var entrada = document.getElementById('example-date-input').value;
    var salida = document.getElementById('example-date-input2').value;
    var idOperador = document.getElementById('idOperador').value;
    var idPuertaEntrada = document.getElementById('idPuertaEntrada').value;
    

    var dataString = 'entrada=' + entrada + '&salida=' + salida + '&idOperador=' + idOperador/*  + '&idPuertaEntrada=' + idPuertaEntrada */;


    jQuery.ajax({
        data: dataString,
        type: 'POST',
        dataType: 'json',
        url: '../ws/ws_reservas/ws_existeContrato.php',
        success: function( payload ){


            var entradaMiliseg = new Date(entrada);
            var salidaMiliseg = new Date(salida);

            entradaMilisegundos = entradaMiliseg.getTime();
            salidaMilisegundos = salidaMiliseg.getTime();


            entradaConFec = new Date(entradaMilisegundos);
            salidaConFec = new Date(entradaMilisegundos + 86400000);


            if (entradaConFec.getDate() >= 10) {

                if (entradaConFec.getMonth() >= 10) {

                    entradaConFecha = entradaConFec.getFullYear() + "-" +( entradaConFec.getMonth() + 1) + "-" + entradaConFec.getDate();

                } else {

                    entradaConFecha = entradaConFec.getFullYear() + "-0" +( entradaConFec.getMonth() + 1) + "-" + entradaConFec.getDate();

                }


            } else {

                if (entradaConFec.getMonth() >= 10) {

                    entradaConFecha = entradaConFec.getFullYear() + "-" +( entradaConFec.getMonth() + 1) + "-0" + entradaConFec.getDate();

                } else {

                    entradaConFecha = entradaConFec.getFullYear() + "-0" +( entradaConFec.getMonth() + 1) + "-0" + entradaConFec.getDate();

                }


            }


            if (salidaConFec.getDate() >= 10) {

                if (salidaConFec.getMonth() >= 10) {

                    salidaConFecha = salidaConFec.getFullYear() + "-" +( salidaConFec.getMonth() + 1) + "-" + salidaConFec.getDate();

                } else {

                    salidaConFecha = salidaConFec.getFullYear() + "-0" +( salidaConFec.getMonth() + 1) + "-" + salidaConFec.getDate();

                }


            } else {

                if (salidaConFec.getMonth() >= 10) {

                    salidaConFecha = salidaConFec.getFullYear() + "-" +( salidaConFec.getMonth() + 1) + "-0" + salidaConFec.getDate();

                } else {

                    salidaConFecha = salidaConFec.getFullYear() + "-0" +( salidaConFec.getMonth() + 1) + "-0" + salidaConFec.getDate();

                }


            }


            document.getElementById('example-date-input2').value = salidaConFecha;





            if (payload.existeContrato === true) {

                jQuery.ajax({
                    data: dataString,
                    type: 'POST',
                    dataType: 'json',
                    url: '../ws/ws_reservas/ws_dameContrato.php',
                    success: function( payload ){


                        entradaForm1 = entrada.replace("-", "");
                        entradaForm2 = entradaForm1.replace("-", "");


                        salidaForm1 = salidaConFecha.replace("-", "");
                        salidaForm2 = salidaForm1.replace("-", "");

                        var fechaActual = new Date();
                        var anoActual = fechaActual.getUTCFullYear();
                        var mesActual = (fechaActual.getMonth() + 1);
                        var diaActual = fechaActual.getDate();


                        if (mesActual < 10) {

                            if (diaActual < 10) {

                                fechaMinima = anoActual + "0" + mesActual + "0" + diaActual;
                                fechaMinimaFormatada = anoActual + "-0" + mesActual + "-0" + diaActual;

                            } else {

                                fechaMinima = anoActual + "0" + mesActual + "" + diaActual;
                                fechaMinimaFormatada = anoActual + "-0" + mesActual + "-" + diaActual;

                            }

                        } else {

                            if (diaActual < 10) {

                                fechaMinima = anoActual + "" + mesActual + "0" + diaActual;
                                fechaMinimaFormatada = anoActual + "-" + mesActual + "-0" + diaActual;

                            } else {

                                fechaMinima = anoActual + "" + mesActual + "" + diaActual;
                                fechaMinimaFormatada = anoActual + "-" + mesActual + "-" + diaActual;

                            }

                        }
                        

                        var fechaManana = new Date();
                        var anoManana = fechaManana.getUTCFullYear();
                        var mesManana = (fechaManana.getMonth() + 1);
                        var diaManana = fechaManana.getDate();



                        if (mesManana < 10) {

                            if (diaManana < 10) {

                                fechaManana = anoManana + "0" + mesManana + "0" + diaManana;
                                fechaMananaFormatada = anoManana + "-0" + mesManana + "-0" + diaManana;

                            } else {

                                fechaManana = anoManana + "0" + mesManana + "" + diaManana;
                                fechaMananaFormatada = anoManana + "-0" + mesManana + "-" + diaManana;

                            }

                        } else {

                            if (diaManana < 10) {

                                fechaManana = anoManana + "" + mesManana + "0" + diaManana;
                                fechaMananaFormatada = anoManana + "-" + mesManana + "-0" + diaManana;

                            } else {

                                fechaManana = anoManana + "" + mesManana + "" + diaManana;
                                fechaMananaFormatada = anoManana + "-" + mesManana + "-" + diaManana;

                            }

                        }


                        /* console.log(fechaMananaFormatada); */


                        if (entradaForm2 > fechaMinima) {

            
                            if (entradaForm2 > payload.dameContratoSalida) {
                
                                Swal.fire({
                                    type: 'warning',
                                    title: 'Fuera de fechas!',
                                    text: 'Su contrato solo le permite crear reservas dentro la fecha de ENTRADA acordada.',
                                });


                                if (entradaForm2 > payload.dameContratoSalida || idPuertaEntrada == 'No hay puertas disponibles') {

                                    document.getElementById('enviarCorr').disabled = true;

                                }

                
                            } else {

                                if (idPuertaEntrada == 'No hay puertas disponibles') {

                                    document.getElementById('enviarCorr').disabled = true;

                                }

                                
                            }

                        } else if (entradaForm2 < fechaMinima) {

                            document.getElementById('example-date-input').value = fechaMinimaFormatada;
                            document.getElementById('example-date-input2').value = fechaMananaFormatada;


                        }

              
                    },
                    error: function(){
                      console.log('error');
                      }
                  });



            } else {

                Swal.fire({
                    type: 'warning',
                    title: 'Sin Contrato!',
                    text: 'Debe acordar un contrato antes de realizar una reserva.',
                });
                

            }
  
        },
        error: function(){
          console.log('error');
          }
      });
      

};



function cambiarPuertaSalida(){

    let theObject = new XMLHttpRequest(); 
    
    theObject.onreadystatechange = function () {
        
        if(theObject.readyState === 4 && theObject.status === 200) {

            let resp = theObject.responseText;
            
            document.getElementById('idPuertaSalida').value = resp;
            
        }   
        
    };

    theObject.open('POST', '../ws/ws_reservas/ws_reserva.php', true);

    theObject.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    theObject.send();

}


/* function generarLocalizador() {

    var localizador = document.getElementById('localizador').value;
    

    var dataString = 'localizador=' + localizador;
    
    jQuery.ajax({
      data: dataString,
      type: 'POST',
      dataType: 'json',
      url: '../ws/ws_reservas/ws_generarLocalizador.php',
      success: function( payload ){
        
          console.log(payload.status)
          console.log(payload.localizador)
          
          if (payload.localizador === '') {



            document.getElementById('localizador').value = payload.status;

        }

      },
      error: function(){
        console.log('error');
        }
    });


  } */;