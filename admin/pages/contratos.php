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
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Intranet - <?php echo $_SESSION['NombreLocker'];?></title>
    <?php include_once('../includes/scripts.php');?>
	<!--alerts CSS -->
	<link href="./../../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
	<style>
        .buttons-pdf {background-color: red !important;}
        .buttons-excel {background-color: green !important;  margin-right: 15px !important;}
		.dt-buttons {display: inline-block !important;}
		.dataTables_length {display: inline-block !important;  margin-right: 800px !important;}
		.dataTables_filter {display: inline-block !important;}
    </style>   
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
	            	<div class="row mb-4">
						<div class="col-6">
							<h1 class="h3 mb-0 text-gray-800">Contratos</h1>
						</div>
						<div class="col-6 d-flex justify-content-end">
							<a href="crear-contrato.php" class="btn btn-primary btn-icon-split ml-3">
								<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Contrato</span>
							</a>
						</div>


	            	</div>

		            <!-- Content Table -->
		            <?php // --- LLAMAR WS : DameOperadores 
		    			$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
		    			$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

						$objeto_dameOperador = $soap_result_DO->DameOperadoresResult->Operador;
					?>
					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered" id="listTicket_contratos" width="100%" cellspacing="0">
		                        	<thead>
		                            	<tr>
		                                    <th>Num.</th>
		                                    <th>Nombre</th>
		                                    <th>Contrato desde</th>
		                                    <th>Contrato hasta</th>
		                                    <th>Cupos</th>
		                                    <th>Acciones</th>
		                                </tr>
		                            </thead>
									<tbody>
		                            <?php 
		                            	if(!is_array($objeto_dameOperador) && !is_null($objeto_dameOperador)){ // SÓLO 1
		                            		if($objeto_dameOperador->IdOperador == 0){ // ES KEYPOINT
		                            			if($_SESSION['id_operador'] == 0 && $_SESSION['rol_user'] == 0){ // ES SUPERVISOR

												// --- LLAMAR WS : DamePuertasCupoPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
												$parametros_damePuertasCupoPorOperador = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$objeto_dameOperador->IdOperador);
												$soap_result_DPCPO = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($parametros_damePuertasCupoPorOperador);
												
												$objeto_damePuertasCupoPorOperador = $soap_result_DPCPO->DamePuertasCupoPorOperadorResult->Puerta;

		                            				echo '  <tr>
					                                            <td>'.$objeto_dameOperador->IdOperador.'</td>
					                                            <td>'.$objeto_dameOperador->Nombre.'</td>
					                                            <td>'.$objeto_dameOperador->Email.'</td>
					                                            <td>'.$objeto_dameOperador->Movil.'</td>
				                                            	<td class="d-flex justify-content-center">

					                                            <!-- Button trigger modal -->
					                                            <button type="button" class="btn btn-xs btn-info mr-2" id="borrarContrato" data-toggle="modal" data-target="#borrarContrato'.$objeto_dameOperador->IdOperador.'" data-id_res="'.$objeto_dameOperador->IdOperador.'" data-nombre="'.$objeto_dameOperador->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>';
					                                
													if ($objeto_damePuertasCupoPorOperador === null) {

													echo '

					                                            <!-- Modal -->
					                                            <div class="modal fade" id="borrarContrato'.$objeto_dameOperador->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					                                                <div class="modal-dialog">
					                                                    <div class="modal-content">
					                                                        <div class="modal-header">
					                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Operador</h5>
					                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                                                            <span aria-hidden="true">&times;</span>
					                                                            </button>
					                                                        </div>
					                                                        <div class="modal-body">
					                                                            Borrar al operador '.$objeto_dameOperador->Nombre.'?
					                                                        </div>
					                                                        <div class="modal-footer">
					                                                            <form action="eliminar_contrato_validate.php" method="POST">
					                                                                <input type="hidden" id="operador" name="contrato" value="'.$objeto_dameOperador->IdOperador.'">
					                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameOperador->IdOperador.'" data-nombre="'.$objeto_dameOperador->Nombre.'">Confirmar</button>
					                                                            </form>
					                                                        </div>
					                                                    </div>
					                                                </div>
					                                            </div>
					                                            <a href="actualizar-contrato.php?upd='.$objeto_dameOperador->IdOperador.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>';
															}
					                        echo           '</td>
					                                        </tr>';
		                            			}
		                            		}else{
			
												// --- LLAMAR WS : DamePuertasCupoPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
												$parametros_damePuertasCupoPorOperador = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$objeto_dameOperador->IdOperador);
												$soap_result_DPCPO = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($parametros_damePuertasCupoPorOperador);
												
												$objeto_damePuertasCupoPorOperador = $soap_result_DPCPO->DamePuertasCupoPorOperadorResult->Puerta;

		                            			echo '  <tr>
				                                            <td>'.$objeto_dameOperador->IdOperador.'</td>
				                                            <td>'.$objeto_dameOperador->Nombre.'</td>
				                                            <td>'.$objeto_dameOperador->Email.'</td>
				                                            <td>'.$objeto_dameOperador->Movil.'</td>
			                                            	<td class="d-flex justify-content-center">

				                                            <!-- Button trigger modal -->
				                                            <button type="button" class="btn btn-xs btn-info mr-2" id="borrarContrato" data-toggle="modal" data-target="#borrarContrato'.$objeto_dameOperador->IdOperador.'" data-id_res="'.$objeto_dameOperador->IdOperador.'" data-nombre="'.$objeto_dameOperador->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>';
				                                
															
												if ($objeto_damePuertasCupoPorOperador === null) {

				                                echo '      <!-- Modal -->
				                                            <div class="modal fade" id="borrarContrato'.$objeto_dameOperador->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				                                                <div class="modal-dialog">
				                                                    <div class="modal-content">
				                                                        <div class="modal-header">
				                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Operador</h5>
				                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                                                            <span aria-hidden="true">&times;</span>
				                                                            </button>
				                                                        </div>
				                                                        <div class="modal-body">
				                                                            Borrar al operador '.$objeto_dameOperador->Nombre.'?
				                                                        </div>
				                                                        <div class="modal-footer">
				                                                            <form action="eliminar_contrato_validate.php" method="POST">
				                                                                <input type="hidden" id="operador" name="operador" value="'.$objeto_dameOperador->IdOperador.'">
				                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameOperador->IdOperador.'" data-nombre="'.$objeto_dameOperador->Nombre.'">Confirmar</button>
				                                                            </form>
				                                                        </div>
				                                                    </div>
				                                                </div>
				                                            </div>
				                                            <a href="actualizar-contrato.php?upd='.$objeto_dameOperador->IdOperador.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>';
				                            echo       '</td>
				                                        </tr>';
													}
		                            		}
		                            	}elseif (is_array($objeto_dameOperador)){

		                            		for ($step=0; $step<count($objeto_dameOperador); $step++){

												require './../../../ws_include/ws_Keys_reserva.php';
                                                
												// --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
												$parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$objeto_dameOperador[$step]->IdOperador);
												$soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);
												
												$objeto_dameContrato = $soap_result_DC->DameContratoResult;

                                                if ($objeto_dameContrato !== null) {

                                                    $desdeDate = DateTime::createFromFormat('Ymd', $objeto_dameContrato->Desde);
                                                    $desde = $desdeDate->format('d-m-Y');

                                                    $hastaDate = DateTime::createFromFormat('Ymd', $objeto_dameContrato->Hasta);
                                                    $hasta = $hastaDate->format('d-m-Y');
                                                    
                                                    $cupo = $objeto_dameContrato->Cupo;

													$ocultarEditar = '';
													$ocultarBorrar = '';

                                                } else {

                                                    $desde = 'Sin Contrato';
                                                    $hasta = 'Sin Contrato';
                                                    $cupo = 'Sin Contrato';

													$ocultarEditar = 'hidden';
													$ocultarBorrar = 'hidden';

                                                }
                                          


		      									if($objeto_dameOperador[$step]->IdOperador == 0 || $objeto_dameOperador[$step]->IdOperador == 111){ // ES KEYPOINT
		      										if($_SESSION['id_operador'] == 0 && $_SESSION['rol_user'] == 0){ // ES SUPERVISOR
														
		      											echo '  <tr>
						                                            <td>'.$objeto_dameOperador[$step]->IdOperador.'</td>
						                                            <td>'.$objeto_dameOperador[$step]->Nombre.'</td>
						                                            <td>'.$desde.'</td>
						                                            <td>'.$hasta.'</td>
						                                            <td>'.$cupo.'</td>
					                                            	<td class="d-flex justify-content-center">';
					                                    if($objeto_dameOperador[$step]->IdOperador != 0 && $objeto_dameOperador[$step]->IdOperador != 111){
														
														require './../../../ws_include/ws_Keys_reserva.php';

														// --- LLAMAR WS : DamePuertasCupoPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
														$parametros_damePuertasCupoPorOperador = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$objeto_dameOperador[$step]->IdOperador);
														$soap_result_DPCPO = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($parametros_damePuertasCupoPorOperador);
														
														$objeto_damePuertasCupoPorOperador = $soap_result_DPCPO->DamePuertasCupoPorOperadorResult->Puerta;

					                                    	echo '
							                                    	<!-- Button trigger modal -->
						                                            <button type="button" onclick="avisoPuertasEnContrato('.$objeto_dameOperador[$step]->IdOperador.')" class="btn btn-danger btn-circle btn-sm" id="borrarContrato" data-toggle="modal" data-target="#borrarContrato'.$objeto_dameOperador[$step]->IdOperador.'" data-id_res="'.$objeto_dameOperador[$step]->IdOperador.'" data-nombre="'.$objeto_dameOperador[$step]->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>';
						                                    
															if ($objeto_damePuertasCupoPorOperador === null) {
																	
															echo '

						                                            <!-- Modal -->
						                                            <div class="modal fade" id="borrarContrato" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						                                                <div class="modal-dialog">
						                                                    <div class="modal-content">
						                                                        <div class="modal-header">
						                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Contrato</h5>
						                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                                                            <span aria-hidden="true">&times;</span>
						                                                            </button>
						                                                        </div>
						                                                        <div class="modal-body">
						                                                            Borrar el contrato '.$objeto_dameOperador[$step]->Nombre.'?
						                                                        </div>
						                                                        <div class="modal-footer">
						                                                            <form action="eliminar_contrato_validate.php" method="POST">
						                                                                <input type="hidden" id="del_id_oper" name="operador" value="'.$objeto_dameOperador[$step]->IdOperador.'">
						                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameOperador[$step]->IdOperador.'" data-nombre="'.$objeto_dameOperador[$step]->Nombre.'">Confirmar</button>
						                                                            </form>
						                                                        </div>
						                                                    </div>
						                                                </div>
						                                            </div>';

																}
						                                           
					                                    }
					                                    echo '  </td>
					                                        </tr>';
		      										}
		      									}else{
		      										echo '  <tr>
					                                            <td>'.$objeto_dameOperador[$step]->IdOperador.'</td>
					                                            <td>'.$objeto_dameOperador[$step]->Nombre.'</td>
					                                            <td>'.$desde.'</td>
					                                            <td>'.$hasta.'</td>
					                                            <td>'.$cupo.'</td>
				                                            	<td class="d-flex justify-content-center">
				                                            		<a '.$ocultarEditar.' href="actualizar-contrato.php?upd='.$objeto_dameOperador[$step]->IdOperador.'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>';
				                                    if($objeto_dameOperador[$step]->IdOperador != 0){
														
														require './../../../ws_include/ws_Keys_reserva.php';

														// --- LLAMAR WS : DamePuertasCupoPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
														$parametros_damePuertasCupoPorOperador = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$objeto_dameOperador[$step]->IdOperador);
														$soap_result_DPCPO = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($parametros_damePuertasCupoPorOperador);
														
														$objeto_damePuertasCupoPorOperador = $soap_result_DPCPO->DamePuertasCupoPorOperadorResult->Puerta;

				                                    	echo '
						                                    	<!-- Button trigger modal -->
					                                            <button '.$ocultarBorrar.' onclick="avisoPuertasEnContrato('.$objeto_dameOperador[$step]->IdOperador.')" type="button" class="btn btn-danger btn-circle btn-sm" id="borrarContrato" data-toggle="modal" data-target="#borrarContrato'.$objeto_dameOperador[$step]->IdOperador.'" data-id_res="'.$objeto_dameOperador[$step]->IdOperador.'" data-nombre="'.$objeto_dameOperador[$step]->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>';

														if ($objeto_damePuertasCupoPorOperador === null) {
					                                    
														echo '
					                                            <!-- Modal -->
					                                            <div class="modal fade" id="borrarContrato'.$objeto_dameOperador[$step]->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					                                                <div class="modal-dialog">
					                                                    <div class="modal-content">
					                                                        <div class="modal-header">
					                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Contrato</h5>
					                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                                                            <span aria-hidden="true">&times;</span>
					                                                            </button>
					                                                        </div>
					                                                        <div class="modal-body">
					                                                            Borrar al contrato '.$objeto_dameOperador[$step]->Nombre.'?
					                                                        </div>
					                                                        <div class="modal-footer">
					                                                            <form action="eliminar_contrato_validate.php" method="POST">
					                                                                <input type="hidden" id="del_id_oper" name="operador" value="'.$objeto_dameOperador[$step]->IdOperador.'">
					                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameOperador[$step]->IdOperador.'" data-nombre="'.$objeto_dameOperador[$step]->Nombre.'">Confirmar</button>
					                                                            </form>
					                                                        </div>
					                                                    </div>
					                                                </div>
					                                            </div>';
					                                           
														}
				                                    }
				                                    echo '  </td>
				                                        </tr>';
		      									}	
		                            		}
		                            	}
		                                ?>
		                            </tbody>
		                        </table>
		                    </div>
		                </div>
					</div>
	            </div>
	        </div>
	    </div>
    </div>
    <!-- /page content -->
    <?php include_once('../includes/scripts_footer.php');?>
	<script src="./../js/typeahead.bundle.js"></script>
	<!-- Sweet-Alert  -->
	<script src="./../../assets/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="./../../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
    <script>
    	$(function () {
    		$('#dataTable').DataTable({
                responsive: true,
                columnDefs: [{ orderable: false, targets: 4 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
    	});
    </script>

	<script>
	
		function avisoPuertasEnContrato(id) {

				let idOperador = id;
				let dataString = "idOperador="+idOperador;
	
				$.ajax({
					type: 'POST',
					url: './../../../ws_include/ws_damePuertasCupoPorOperador.php',
					data: dataString,
					dataType: 'json',
					success: function(response) {

						if (response.numPuertas === undefined) {

							Swal.fire({
								type: 'error',
								title: 'Ese contrato contiene 1 puerta!',
								text: 'Debe borrarlas en el apartado de Administrar Puertas!',
								footer: '<a href="administrar-puertas.php">Administrar Puertas</a>'
							});

							}

						else if (response !== null) {

							Swal.fire({
								type: 'error',
								title: 'Ese contrato contiene ' + response.numPuertas + ' puertas!',
								text: 'Debe borrarlas en el apartado de Administrar Puertas!',
								footer: '<a href="administrar-puertas.php">Administrar Puertas</a>'
							});

						}

					}

				});

		};
	</script>
	<script src="./../js/listTicket_contratos.js"></script>
  </body>
</html>