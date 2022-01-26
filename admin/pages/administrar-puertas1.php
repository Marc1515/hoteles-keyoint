<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}
if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

include_once('../includes/roles.php');
include_once('../../../ws_include/ws_Keys_consigna.php');
include_once('../../../ws_include/ws_Keys_reserva.php');

// OPERADORES
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

$x = 0;
if((array)$soap_result_DO->DameOperadoresResult->Operador->IdLocker){ // SÓLO 1
	if($soap_result_DO->DameOperadoresResult->Operador->IdOperador != 0){ // ES KEYPOINT
		$listado_operadores[0] = $soap_result_DO->DameOperadoresResult->Operador;
	}
}else{
	for ($i = 0; $i < count((array)$soap_result_DO->DameOperadoresResult->Operador); $i++){
		$lista_operadores = (array)$soap_result_DO->DameOperadoresResult->Operador;
		$datos_operadores = $lista_operadores[$i];

		if($datos_operadores->IdOperador != 0){ // ES KEYPOINT
			$listado_operadores[$x] = $datos_operadores;
			$x++;
		}
	}
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Intranet - <?php echo $_SESSION['NombreLocker'];?></title>
    <?php include_once('../includes/scripts.php');?>
    <link href="../includes/multiselect/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
</head>
<body id="page-top">
  	<!-- Page Wrapper -->
    <div id="wrapper">
	    <!-- Sidebar -->
	    <?php include_once("../includes/menu.php"); ?>
	    <!-- End of Sidebar -->

	    <!-- Content Wrapper -->
	    <div id="content-wrapper" class="d-flex flex-column">
	      
	        <!-- Main Content -->
	        <div id="content">
	          
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
					  <i class="fa fa-bars"></i>
					</button>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">
					  <div class="topbar-divider d-none d-sm-block"></div>
					  <?php include_once("../includes/datosuser.php"); ?>
					</ul>
				</nav>
				<!-- End of Topbar -->

	          	<!-- Begin Page Content -->
	          	<div class="container-fluid">

	            	<!-- Page Heading -->
	            	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	              		<h1 class="h3 mb-0 text-gray-800">Administrar Puertas</h1>
	            	</div>

	            	<!-- Content Table -->
	            	<div class="card shadow mb-4">
						<div class="card-body">
							<form id="form_puertas" name="form_puertas" action="administrar_puertas_validate.php" method="post">
								<div class="row">
									<select class="custom-select col-4" id="select_operadores" name="select_operadores" onchange="admin_puertas()" onclick="confirma()">
										<option value="NONE">Escoger un Operador...</option>
										<?php
											for ($i = 0; $i < count((array)$listado_operadores); $i++){
												echo '<option value="'.$listado_operadores[$i]->IdOperador.'">'.$listado_operadores[$i]->Nombre.'</option>';
											}
										?>
									</select>
								</div>
								<div class="row">
									<?php
										for ($i = 0; $i < count((array)$listado_operadores); $i++){
											echo '<select multiple id="puertas_cupo" name="puertas_cupo[]" style="display: none;"></select>';
										}
									?>
								</div>
								<div class="row">
									<div id="boton_guardar" class="col-5" style="text-align: right; margin-top: 5px; display: none;">
										<button type="submit" class="btn btn-success btn-icon-split">
	                                        <span class="icon text-white-50">
	                                            <i class="fas fa-check"></i>
	                                        </span>
	                                        <span class="text">Guardar</span>
	                                    </button>
	                                </div>
								</div>
							</form>
						</div>
					</div>
					<!-- Modal -->
	                <div class="modal fade" id="cambios_op" name="cambios_op" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	                    <div class="modal-dialog">
	                        <div class="modal-content">
	                            <div class="modal-header">
	                                <h5 class="modal-title" id="exampleModalLabel">Guardar cambios?</h5>
	                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                                <span aria-hidden="true">&times;</span>
	                                </button>
	                            </div>
	                            <div class="modal-body">
	                                Desea guardar los cambios realizados?
	                            </div>
	                            <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" onclick="enviar_form(true)">Sí</button>
                                    <button type="button" class="btn btn-danger text-white" onclick="enviar_form(false)">No</button>
	                            </div>
	                        </div>
	                    </div>
	                </div>
				</div>
			</div>
		</div>
	</div>
	<?php include_once('../includes/scripts_footer.php');?>
	<script type="text/javascript" src="../includes/multiselect/js/jquery.multi-select.js"></script>   
	<script>
		var cambios = false;
	
		// CARGAMOS PUERTAS
        function admin_puertas() {
          	var id = $('#select_operadores').val();
        	var dataString = 'id=' + id;
        	$('#puertas_cupo').find('option').remove();
      		jQuery.ajax({
	            data: dataString,
	            type: 'POST',
	            dataType: 'json',
	            url: 'puertas_op.php',
	            success: function( payload ){
	            	array_puertas = payload.status;
	            	if(array_puertas['Libres']){
	            		for(i = 0; i < array_puertas['Libres'].length; i++) {
	            			$('#puertas_cupo').append('<option value="' + array_puertas['Libres'][i]['id'] + '">' + array_puertas['Libres'][i]['Nombre'] + '</option>');
	            		}
	            	}
	            	if(array_puertas['Ocupadas']){
		            	for(i = 0; i < array_puertas['Ocupadas'].length; i++) {
		            		$('#puertas_cupo').append('<option value="' + array_puertas['Ocupadas'][i]['id'] + '" selected>' + array_puertas['Ocupadas'][i]['Nombre'] + '</option>');
		            	}
		            }
	            	//$('#puertas_cupo').multiSelect();
	            	$('#puertas_cupo').multiSelect('refresh');
	            },
	            error: function(){
	            	console.log('error');
	            }
          	});
      		$('#puertas_cupo').multiSelect({
	      		afterSelect: function(values){
	      			$('#boton_guardar').show();
	      		    cambios = true;
	      		},
	      		afterDeselect: function(values){
	      			$('#boton_guardar').show();
	      		    cambios = true;
	      		},
				selectableHeader: "<div class='custom-header' style='text-align: center; margin-top:5px;'>Puertas disponibles</div>",
  				selectionHeader: "<div class='custom-header' style='text-align: center; margin-top:5px;'>Puertas asignadas</div>"
      		});
    	};

    	// HAY CAMBIOS?
        function confirma() {
        	if(cambios == true){
        		$('#cambios_op').modal('show');
      		}
        };
        function enviar_form(opcion) {
        	switch(opcion){
        		case true:
        			$('#form_puertas').submit();
        		break;
        		case false:
        			cambios = false;
        			$('#cambios_op').modal('hide');
        		break;
        	}
        }
	</script>
</body>
</html>