function comprobarContrato() {

    var entrada = document.getElementById('example-date-input').value;
    var salida = document.getElementById('example-date-input2').value;
    var idOperador = document.getElementById('idOperador').value;
    var estado = document.getElementById('estado').value;
    console.log(estado);

    var dataString = 'entrada=' + entrada + '&salida=' + salida + '&idOperador=' + idOperador;

    if (estado != 0) {

        document.getElementById('example-date-input').readOnly = true;

    }


    jQuery.ajax({
        data: dataString,
        type: 'POST',
        dataType: 'json',
        url: '../ws/ws_reservas/ws_existeContrato.php',
        success: function( payload ){

            var entradaNueva = new Date(entrada);
            var salidaNueva = new Date(salida);


            if (payload.existeContrato === true) {

                if (entradaNueva.getDate() >= 10) {

                    if (entradaNueva.getMonth() >= 10) {

                        fechaEntradaFinal = entradaNueva.getFullYear() + "" + (entradaNueva.getMonth() + 1) + "" + entradaNueva.getDate();

                    } else {

                        fechaEntradaFinal = entradaNueva.getFullYear() + "0" + (entradaNueva.getMonth() + 1) + "" + entradaNueva.getDate();

                    }
    
                } else {
    
                    if (entradaNueva.getMonth() >= 10) {

                        fechaEntradaFinal = entradaNueva.getFullYear() + "" + (entradaNueva.getMonth() + 1) + "0" + entradaNueva.getDate();

                    } else {

                        fechaEntradaFinal = entradaNueva.getFullYear() + "0" + (entradaNueva.getMonth() + 1) + "0" + entradaNueva.getDate();

                    }
    
                }



                if (salidaNueva.getDate() >= 10) {

                    if (salidaNueva.getMonth() >= 10) {

                        fechaSalidaFinal = salidaNueva.getFullYear() + "" + (salidaNueva.getMonth() + 1) + "" + salidaNueva.getDate();

                    } else {

                        fechaSalidaFinal = salidaNueva.getFullYear() + "0" + (salidaNueva.getMonth() + 1) + "" + salidaNueva.getDate();

                    }
    
                } else {
    
                    if (salidaNueva.getMonth() >= 10) {

                        fechaSalidaFinal = salidaNueva.getFullYear() + "" + (salidaNueva.getMonth() + 1) + "0" + salidaNueva.getDate();

                    } else {

                        fechaSalidaFinal = salidaNueva.getFullYear() + "0" + (salidaNueva.getMonth() + 1) + "0" + salidaNueva.getDate();

                    }
    
                }

                jQuery.ajax({
                    data: dataString,
                    type: 'POST',
                    dataType: 'json',
                    url: '../ws/ws_reservas/ws_dameContrato.php',
                    success: function( payload ){

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

                        if (fechaEntradaFinal > fechaMinima) {
            
                            if (fechaEntradaFinal < payload.dameContratoEntrada || fechaEntradaFinal > payload.dameContratoSalida) {
                
                                Swal.fire({
                                    type: 'warning',
                                    title: 'Fuera de fechas!',
                                    text: 'Su contrato solo le permite crear reservas dentro la fecha de ENTRADA acordada.',
                                });

                                document.getElementById('enviarCorr').disabled = true;
                
                            } else {

                                document.getElementById('enviarCorr').disabled = false;
                                
                            }

                        } else if (fechaEntradaFinal < fechaMinima) {

                            document.getElementById('example-date-input').value = fechaMinimaFormatada;
                            /* document.getElementById('example-date-input2').value = fechaMananaFormatada; */

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