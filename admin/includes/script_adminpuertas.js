	status_puertas();
	var cambios = 0;
	var clicks = 0;
	var contrato = 0;
	var cupo = 0;

	function status_puertas(){
		// CARGAMOS PUERTAS
    var operador = $('#select_operadores').val();
    if (operador == 'NONE' || operador == null){
    	operador = 0;
    }else{
    	var dataString = 'id=' + operador;
    	jQuery.ajax({
	      data: dataString,
	      type: 'POST',
	      dataType: 'json',
	      url: '../includes/puertas_operador.php',
	      success: function( payload ){ 
	      	cupo = payload.cupo;
	      	contrato = payload.contrato;
	      },
	      error: function(){
	      	console.log('error');
	      }
	    })
	  }

    var dataString = 'id=' + operador;
  	jQuery.ajax({
      data: dataString,
      type: 'POST',
      dataType: 'json',
      url: '../includes/celdas_admpuertas.php',
      success: function( payload ){      	
      	puertas = payload.status;
      	for (var i = 0; i < Object.keys(puertas).length; i++) {
      		key_puerta = i+1;
      		if(puertas[key_puerta] != null){
      			if(puertas[key_puerta]['Estado'] == 'Libre'){
	      			$("#cell_" + key_puerta).css("background-color", "#62ff62");
	      			$("#cell_" + key_puerta).html("<div class='libre'>" + puertas[key_puerta]['NombrePuerta'] + "<br />&nbsp;<br /></div>");
	      		}else{
	      			if(puertas[key_puerta]['IdOperador'] != operador && operador != 0){
								$("#cell_" + key_puerta).css("background-color", "#fb6262");
								$("#cell_" + key_puerta).css('opacity', '0.5');
								$("#cell_" + key_puerta).css('cursor', 'not-allowed');
								$("#cell_" + key_puerta).html("<div class='ocupada'>" + puertas[key_puerta]['NombrePuerta'] + "</div><div class='ocupada'>" + puertas[key_puerta]['NombreOperador'] + "</div>");
							}else{
								$("#cell_" + key_puerta).css('opacity', '1');
								$("#cell_" + key_puerta).css("background-color", "#fb6262");
								$("#cell_" + key_puerta).css('cursor', 'pointer');
	      				$("#cell_" + key_puerta).html("<div class='ocupada'>" + puertas[key_puerta]['NombrePuerta'] + "</div><div class='ocupada'>" + puertas[key_puerta]['NombreOperador'] + "</div>");
							}
	      		}
      		}
      	}
      },
      error: function(){
      	console.log('error');
      }
  	});
	};
	function select(puerta){
		var operador = $('#select_operadores').val();
		if(operador == 'NONE' || operador == null){
			$('#err_opera').modal('show');
			return;
		}
		if(puertas[puerta]['Nuevo'] == "" || puertas[puerta]['Nuevo'] == null){
			if(puertas[puerta]['Estado'] == 'Libre'){
				if(cupo >= contrato){
					$('#err_maximoPuertasPermitidasPorContrato').modal('show');
					return;
				}else{
					clicks++;
					cambios++;
					cupo++;
					$("#cell_" + puerta).css("background-color", "#ffa800");
					$("#cell_" + puerta).css("color", "black");
					$("#cell_" + puerta).html("<div'>" + puertas[puerta]['NombrePuerta'] + "<br>OCUPAR</div>");
					puertas[puerta]['Nuevo'] = "ocupar";
					puertas[puerta]['IdOperador'] = operador;
					$("#boton_guardar").css("display", "block");
				}
				/*var dataString = 'idOperador=' + operador;

				$.ajax({
					data: dataString,
					type: 'POST',
					dataType: 'json',
					url: '../../../ws_include/ws_dameContrato_AdministrarPuertas.php',
					success: function( payload ){

						var maximoPuertasDelContrato = payload.status;
						

						$.ajax ({
							data: dataString,
							type: 'POST',
							dataType: 'json',
							url: '../../../ws_include/ws_damePuertasCupo_AdministrarPuertas.php',
							success: function( payload ){

								var puertasAsignadas = payload.status;
								var puertasAsigandasConCadaClick = puertasAsignadas + clicks;

								/* console.log(maximoPuertasDelContrato);
								console.log(puertasAsignadas);
								console.log(clicks);
								console.log(puertasAsigandasConCadaClick); 

								if(puertasAsigandasConCadaClick <= maximoPuertasDelContrato) {


									$("#cell_" + puerta).css("background-color", "#ffa800");
									$("#cell_" + puerta).css("color", "black");
									$("#cell_" + puerta).html("<div'>" + puertas[puerta]['NombrePuerta'] + "<br>OCUPAR</div>");
									puertas[puerta]['Nuevo'] = "ocupar";
									puertas[puerta]['IdOperador'] = operador;
									$("#boton_guardar").css("display", "block");
									cambios++;

								} else {

									clicks--;
									$('#err_maximoPuertasPermitidasPorContrato').modal('show');
									return;

								}

							}

						});

					}

				});*/

			}else{
				if(puertas[puerta]['Nuevo'] == "liberar"){
					if(cupo >= contrato){
						$('#err_maximoPuertasPermitidasPorContrato').modal('show');
						return;
					}else{
						$("#cell_" + puerta).css('opacity', '1');
						$("#cell_" + puerta).css("background-color", "#fb6262");
						$("#cell_" + puerta).css('cursor', 'pointer');
	  				$("#cell_" + puerta).html("<div class='ocupada'>" + puertas[puerta]['NombrePuerta'] + "</div><div class='ocupada'>" + puertas[puerta]['NombreOperador'] + "</div>");
						puertas[puerta]['Nuevo'] = "";
						cambios--;
						cupo++;
						if(cambios == 0){
							$("#boton_guardar").css("display", "none");
						}
					}
				}else{
					dataString = 'idPuerta=' + puerta;
					$.ajax({
						data: dataString,
						type: 'POST',
						dataType: 'json',
						url: '../../../ws_include/ws_dameReservasVigentesPorPuerta.php',
						success: function( payload ){
							if (payload.status === null) {
								$("#cell_" + puerta).css("background-color", "#009900");
								$("#cell_" + puerta).css("color", "white");
								$("#cell_" + puerta).html("<div>" + puertas[puerta]['NombrePuerta'] + "<br>LIBERAR</div>");
								puertas[puerta]['Nuevo'] = "liberar";
								$("#boton_guardar").css("display", "block");
								cambios++;
								cupo--;
							} else {
								$('#err_puertaConReserva').modal('show');
								return;
							}
						}
					});
				}
			}
		}else{
			if(puertas[puerta]['Nuevo'] === 'ocupar'){
				$("#cell_" + puerta).css("background-color", "#62ff62");
				$("#cell_" + puerta).css("color", "black");
				$("#cell_" + puerta).html("<div'>" + puertas[puerta]['NombrePuerta'] + "</div>");
				puertas[puerta]['Nuevo'] = "";
				cambios--;
				clicks--;
				cupo--;
				if(cambios == 0){
					$("#boton_guardar").css("display", "none");
				}
			}else{
				if(cupo >= contrato){
					$('#err_maximoPuertasPermitidasPorContrato').modal('show');
					return;
				}else{
					$("#cell_" + puerta).css("background-color", "#fb6262");
					$("#cell_" + puerta).css("color", "white");
					$("#cell_" + puerta).html("<div>" + puertas[puerta]['NombrePuerta'] + "</div><div>" + puertas[puerta]['NombreOperador'] + "</div>");
					puertas[puerta]['Nuevo'] = "";
					cambios--;
					cupo++;
					if(cambios == 0){
						$("#boton_guardar").css("display", "none");
					}
				}
			}
		}
	};
	// HAY CAMBIOS?
  function confirma() {
  	if(cambios > 0){
  		$('#cambios_op').modal('show');
	}
  };
  function enviar_form(opcion) {
  	var operador = $('#select_operadores').val();
  	switch(opcion){
  		case true:
  			$("#boton_guardar").css("display", "none");
  			$("#boton_loading").css("display", "block");
  			var valParam = JSON.stringify(puertas);
		  	jQuery.ajax({
		      data: { ArrJson: valParam},
		      type: 'POST',
		      dataType: 'json',
		      url: '../includes/insceldas_admpuertas.php',
		      success: function( payload ){      	
		      	if(payload.status == 'OK'){
		      		window.location.href = 'administrar-puertas.php?op='+operador;
		      	}
		      },
		      error: function(){
		      	console.log('error');
		      }
	      });	
  		break;
  		case false:
  			cambios = 0;
				status_puertas();
  			$('#cambios_op').modal('hide');
  			$("#boton_guardar").css("display", "none");
  			$("#boton_loading").css("display", "none");
  		break;
  	}
  }
