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
							<h1 class="h3 mb-0 text-gray-800">Operadores</h1>
						</div>
						<div class="col-6 d-flex justify-content-end">
							<a href="crear-operador.php" class="btn btn-primary btn-icon-split ml-3">
								<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Operador</span>
							</a>
						</div>


	            	</div>

		            <!-- Content Table -->
		            <?php // --- LLAMAR WS : DameOperadores 
		    			$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
		    			$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

						
					?>
					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered" id="listTicket_operadores" cellspacing="0" width="100%">
		                        	<thead>
		                            	<tr>
		                                    <th>Num.</th>
		                                    <th>Nombre</th>
		                                    <th>Email</th>
		                                    <th>Móvil</th>
		                                    <th>Acciones</th>
		                                </tr>
		                            </thead>
									<tbody>
		                            <?php 
		                            	if((array)$soap_result_DO->DameOperadoresResult->Operador->IdLocker){ // SÓLO 1
		                            		if($soap_result_DO->DameOperadoresResult->Operador->IdOperador == 0){ // ES KEYPOINT
		                            			if($_SESSION['id_operador'] == 0 && $_SESSION['rol_user'] == 0){ // ES ADMINISTRADOR
		                            				echo '  <tr>
					                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'</td>
					                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'</td>
					                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->Email.'</td>
					                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->Movil.'</td>
				                                            	<td class="d-flex justify-content-center">

					                                            <!-- Button trigger modal -->
					                                            <button type="button" class="btn btn-xs btn-info mr-2" data-toggle="modal" data-target="#borrarOp'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" data-id_res="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" data-nombre="'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>
					                                            
					                                            <!-- Modal -->
					                                            <div class="modal fade" id="borrarOp'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					                                                <div class="modal-dialog">
					                                                    <div class="modal-content">
					                                                        <div class="modal-header">
					                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Operador</h5>
					                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                                                            <span aria-hidden="true">&times;</span>
					                                                            </button>
					                                                        </div>
					                                                        <div class="modal-body">
					                                                            Borrar al operador '.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'?
					                                                        </div>
					                                                        <div class="modal-footer">
					                                                            <form action="eliminar_operador_validate.php" method="POST">
					                                                                <input type="hidden" id="del_id_oper" name="del_id_oper" value="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'">
					                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
					                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" data-nombre="'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'">Confirmar</button>
					                                                            </form>
					                                                        </div>
					                                                    </div>
					                                                </div>
					                                            </div>
					                                            <a href="actualizar-operador.php?upd='.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>
					                                            </td>
					                                        </tr>';
		                            			}
		                            		}else{
		                            			echo '  <tr>
				                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'</td>
				                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'</td>
				                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->Email.'</td>
				                                            <td>'.$soap_result_DO->DameOperadoresResult->Operador->Movil.'</td>
			                                            	<td class="d-flex justify-content-center">

				                                            <!-- Button trigger modal -->
				                                            <button type="button" class="btn btn-xs btn-info mr-2" data-toggle="modal" data-target="#borrarOp'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" data-id_res="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" data-nombre="'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>
				                                            
				                                            <!-- Modal -->
				                                            <div class="modal fade" id="borrarOp'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
				                                                <div class="modal-dialog">
				                                                    <div class="modal-content">
				                                                        <div class="modal-header">
				                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Operador</h5>
				                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                                                            <span aria-hidden="true">&times;</span>
				                                                            </button>
				                                                        </div>
				                                                        <div class="modal-body">
				                                                            Borrar al operador '.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'?
				                                                        </div>
				                                                        <div class="modal-footer">
				                                                            <form action="eliminar_operador_validate.php" method="POST">
				                                                                <input type="hidden" id="del_id_oper" name="del_id_oper" value="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'">
				                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
				                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'" data-nombre="'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'">Confirmar</button>
				                                                            </form>
				                                                        </div>
				                                                    </div>
				                                                </div>
				                                            </div>
				                                            <a href="actualizar-operador.php?upd='.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>
				                                            </td>
				                                        </tr>';
		                            		}
		                            	}else{
		                            		for ($i = 0; $i < count((array)$soap_result_DO->DameOperadoresResult->Operador); $i++){
		                            			$lista_operadores = (array)$soap_result_DO->DameOperadoresResult->Operador;
		      									$datos_operadores = $lista_operadores[$i];

		      									if($datos_operadores->IdOperador == 0 || $datos_operadores->IdOperador == 111){ // ES KEYPOINT
		      										if($_SESSION['id_operador'] == 0 && $_SESSION['rol_user'] == 0){ // ES ADMINISTRADOR
		      											echo '  <tr>
						                                            <td>'.$datos_operadores->IdOperador.'</td>
						                                            <td>'.$datos_operadores->Nombre.'</td>
						                                            <td>'.$datos_operadores->Email.'</td>
						                                            <td>'.$datos_operadores->Movil.'</td>
					                                            	<td class="d-flex justify-content-center">
					                                            		<a href="actualizar-operador.php?upd='.$datos_operadores->IdOperador.'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>';
					                                    if($datos_operadores->IdOperador != 0 && $datos_operadores->IdOperador != 111){
					                                    	echo '
							                                    	<!-- Button trigger modal -->
						                                            <button type="button" onclick="avisoOperadorConContrato('.$datos_operadores->IdOperador.')" class="btn btn-danger btn-circle btn-sm" id="borrarOperador" data-toggle="modal" data-target="#borrarOp'.$datos_operadores->IdOperador.'" data-id_res="'.$datos_operadores->IdOperador.'" data-nombre="'.$datos_operadores->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>
						                                            
						                                            <!-- Modal -->
						                                            <div class="modal fade" id="borrarOp'.$datos_operadores->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						                                                <div class="modal-dialog">
						                                                    <div class="modal-content">
						                                                        <div class="modal-header">
						                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Operador</h5>
						                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						                                                            <span aria-hidden="true">&times;</span>
						                                                            </button>
						                                                        </div>
						                                                        <div class="modal-body">
						                                                            Borrar al operador '.$datos_operadores->Nombre.'?
						                                                        </div>
						                                                        <div class="modal-footer">
						                                                            <form action="eliminar_operador_validate.php" method="POST">
						                                                                <input type="hidden" id="del_id_oper" name="del_id_oper" value="'.$datos_operadores->IdOperador.'">
						                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
						                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$datos_operadores->IdOperador.'" data-nombre="'.$datos_operadores->Nombre.'">Confirmar</button>
						                                                            </form>
						                                                        </div>
						                                                    </div>
						                                                </div>
						                                            </div>';
						                                           
					                                    }
					                                    echo '  </td>
					                                        </tr>';
		      										}
		      									}else{

													require './../../../ws_include/ws_Keys_reserva.php';

													$idLocker = $_SESSION['IdLocker'];

													// --- LLAMAR WS : ExisteContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
													$parametros_existeContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$datos_operadores->IdOperador);
													$soap_result_EC = $SoapClient_KeysReserva->ExisteContrato($parametros_existeContrato);
													
													$objeto_existeContrato = $soap_result_EC->ExisteContratoResult;
													  
		      										echo '  <tr>
					                                            <td>'.$datos_operadores->IdOperador.'</td>
					                                            <td>'.$datos_operadores->Nombre.'</td>
					                                            <td>'.$datos_operadores->Email.'</td>
					                                            <td>'.$datos_operadores->Movil.'</td>
				                                            	<td class="d-flex justify-content-center">
				                                            		<a href="actualizar-operador.php?upd='.$datos_operadores->IdOperador.'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>';
				                                    if($datos_operadores->IdOperador != 0){
				                                    	echo '
															<!-- Button trigger modal -->
															<button type="button" onclick="avisoOperadorConContrato('.$datos_operadores->IdOperador.')" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#borrarOp'.$datos_operadores->IdOperador.'" data-id_res="'.$datos_operadores->IdOperador.'" data-nombre="'.$datos_operadores->Nombre.'" title="Eliminar"><i class="fas fa-times"></i></button>';
															
														
														if ($objeto_existeContrato === false) {

														
															echo '
																<!-- Modal -->
																<div class="modal fade" id="borrarOp'.$datos_operadores->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
																	<div class="modal-dialog">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 class="modal-title" id="exampleModalLabel">Borrar Operador</h5>
																				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				Borrar al operador '.$datos_operadores->Nombre.'?
																			</div>
																			<div class="modal-footer">
																				<form action="eliminar_operador_validate.php" method="POST">
																					<input type="hidden" id="del_id_oper" name="del_id_oper" value="'.$datos_operadores->IdOperador.'">
																					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
																					<button type="submit" class="btn btn-danger text-white" data-id_res="'.$datos_operadores->IdOperador.'" data-nombre="'.$datos_operadores->Nombre.'">Confirmar</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>';
														}
					                                           
				                                    }
												}	
		                            		}
											echo '  </td>
												</tr>';
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
	
	function avisoOperadorConContrato(id) {

			let idOperador = id;
			let dataString = "idOperador="+idOperador;

			$.ajax({
				type: 'POST',
				url: './../../../ws_include/ws_existeContrato.php',
				data: dataString,
				dataType: 'json',
				success: function(response) {

					var respuestaContrato = response.status;

					if (respuestaContrato === true) {

						Swal.fire({
							type: 'warning',
							title: 'Este Operador contiene un contrato!',
							allowOutsideClick: true,
							showConfirmButton: true,
							confirmButtonText: 'Aceptar',
							confirmButtonColor: '#e74a3b',
							showCancelButton: true,
							cancelButtonText: 'Cancelar',
			
							html: `

								<p>Desea eliminarlo antes de borrar el Operador?</p>

								<form id="formOperador_modal">

									<input hidden type="text" name="idOperador" value="${id}">

								</form>

							
							`,

							footer: '<a href="contratos.php">Contratos</a>'
						}).then((response) => {
							console.log(response.value);

							if (response.value === true) {

								const datosForm = document.querySelector('#formOperador_modal');
								const objeto_datosForm = new FormData(datosForm);
								var url = "./../../../ws_include/ws_borrarContrato_desdeOperadores.php"

								fetch(url,{
									method: 'POST',
									body: objeto_datosForm

								})
								.then (data => data.json())
								.then (data =>{

									console.log('Succes:', data);

								})
								.catch(function(error){

									console.error('Error:', error);

								});

								

								Swal.fire({
									allowOutsideClick: false,
									showConfirmButton: false,
									type: 'success',
									title: 'Borrado!',
									text: 'Es necesario quitar las puertas asignadas',
									footer: '<a href="administrar-puertas.php">>>>>> Administrar Puertas <<<<<</a>'
								});

							}

						})

					}

				}

			});

	};
</script>
<script src="./../js/listTicket_operadores.js"></script>
  </body>
</html>