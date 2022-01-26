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
							<h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
						</div>
						<div class="col-6 d-flex justify-content-end">
	              			<a href="crear-usuario.php" class="btn btn-primary btn-icon-split ml-3">
	              				<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Usuario</span>
							</a>
						</div>

	            	</div>

	            	<!-- Content Table -->
		            <?php 
		            $key_user = 0;
		            // ES KEYPOINT?
		            if($_SESSION['id_operador'] == 0 && $_SESSION['id_user'] == 0){
		            	$parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idOperador'=>0,  'OrdenAoN'=>'N', 'idrol'=>0);
						$soap_result_DU = $SoapClient_KeysConsigna->DameUsuarios($parametros_dameUsuarios);

						if((array)$soap_result_DU->DameUsuariosResult->Usuario->IdLocker){ // SÓLO 1
							$lista_usuarios[$key_user] = (array)$soap_result_DU->DameUsuariosResult->Usuario;
							$lista_usuarios[$key_user]['Operador'] = "KeyPoint";
							$lista_usuarios[$key_user]['IdOperador'] = 0;
							$key_user++;
						}else{
							for ($i = 0; $i < count((array)$soap_result_DU->DameUsuariosResult->Usuario); $i++){
		                       	$lista_usuarios[$key_user] = (array)$soap_result_DU->DameUsuariosResult->Usuario[$i];
		                       	$lista_usuarios[$key_user]['Operador'] = "KeyPoint";
		                       	$lista_usuarios[$key_user]['IdOperador'] = 0;
		                       	$key_user++;

		      				}
						}


		            }
		            // OTROS OPERADORES
		            // --- LLAMAR WS : DameOperadores 
		            $parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
		    		$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);
		    		if((array)$soap_result_DO->DameOperadoresResult->Operador->IdLocker){ // SÓLO 1 OPERADOR
		    			if($soap_result_DO->DameOperadoresResult->Operador->IdOperador != 0){
		    				$parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idOperador'=>$soap_result_DO->DameOperadoresResult->Operador->IdOperador, 'OrdenAoN'=>'N', 'idrol'=>0);
							$soap_result_DU = $SoapClient_KeysConsigna->DameUsuarios($parametros_dameUsuarios);
							if((array)$soap_result_DU->DameUsuariosResult->Usuario->IdLocker){ // SÓLO 1 USUARIO DE 1 OPERADOR								
								$result_users = (array)$soap_result_DU->DameUsuariosResult->Usuario;
								$lista_usuarios[$key_user] = (array)$result_users[0];
								$lista_usuarios[$key_user]['Operador'] = $soap_result_DO->DameOperadoresResult->Operador->Nombre;
								$lista_usuarios[$key_user]['IdOperador'] = $soap_result_DO->DameOperadoresResult->Operador->IdOperador;
								$key_user++;
							}else{
								for ($i = 0; $i < count((array)$soap_result_DU->DameUsuariosResult->Usuario); $i++){
									$result_users = (array)$soap_result_DU->DameUsuariosResult->Usuario;
									$lista_usuarios[$key_user] = (array)$result_users[$i];
									$lista_usuarios[$key_user]['Operador'] = $soap_result_DO->DameOperadoresResult->Operador->Nombre;
									$lista_usuarios[$key_user]['IdOperador'] = $soap_result_DO->DameOperadoresResult->Operador->IdOperador;
			      					$key_user++;
								}
							}
		    			}
		    		}else{
		    			for ($i = 0; $i < count((array)$soap_result_DO->DameOperadoresResult->Operador); $i++){
		    				$lista_operadores = (array)$soap_result_DO->DameOperadoresResult->Operador;
		      				$datos_operadores = $lista_operadores[$i];
		      				if($datos_operadores->IdOperador != 0){
		      					$parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idOperador'=>$datos_operadores->IdOperador, 'OrdenAoN'=>'N', 'idrol'=>0);
								$soap_result_DU = $SoapClient_KeysConsigna->DameUsuarios($parametros_dameUsuarios);
								if((array)$soap_result_DU->DameUsuariosResult->Usuario->IdLocker){ // SÓLO 1
									$result_users = (array)$soap_result_DU->DameUsuariosResult->Usuario;
									$lista_usuarios[$key_user] = (array)$result_users;
									$lista_usuarios[$key_user]['Operador'] = $datos_operadores->Nombre;
									$lista_usuarios[$key_user]['IdOperador'] = $datos_operadores->IdOperador;
									$key_user++;
								}else{
									for ($z = 0; $z < count((array)$soap_result_DU->DameUsuariosResult->Usuario); $z++){
										$result_users = (array)$soap_result_DU->DameUsuariosResult->Usuario;
										$lista_usuarios[$key_user] = (array)$result_users[$z];
										$lista_usuarios[$key_user]['Operador'] = $datos_operadores->Nombre;
										$lista_usuarios[$key_user]['IdOperador'] = $datos_operadores->IdOperador;
			      						$key_user++;
									}
								}
		      				}
		    			}
		    		}
					?>
					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered" id="listTicket_usuarios" width="100%" cellspacing="0">
		                        	<thead>
                                        <tr>
                                        	<th>Operador</th>
                                            <th>Nombre</th>
                                            <th>Usuario</th>
                                            <th>Rol</th>
                                            <th>Pwd</th>
                                            <th>Pin</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    	for ($x = 0; $x < count((array)$lista_usuarios); $x++){

											if ($lista_usuarios[$x]['IdRol'] !== 0 && $lista_usuarios[$x]['Operador'] !== 'SUPERVISOR') {

												// ROL
												if($lista_usuarios[$x]['IdRol'] === 1) {
													$rol = "Administrador";
												}else if ($lista_usuarios[$x]['IdRol'] === 2) {
													$rol = "Usuario";
												}else if ($lista_usuarios[$x]['IdRol'] === 0) {
													$rol = "KeyPoint";
												}
												echo    
												'   <tr>
														<td>'.$lista_usuarios[$x]['Operador'].'</td>
														<td>'.$lista_usuarios[$x]['Nombre'].'</td>
														<td>'.$lista_usuarios[$x]['NombreUsuario'].'</td>
														<td>'.$rol.'</td>
														<td>'.$lista_usuarios[$x]['Pwd'].'</td>
														<td>'.$lista_usuarios[$x]['PinSeguridad'].'</td>
														<td class="d-flex justify-content-center">
															<a href="actualizar-usuario.php?upd='.$lista_usuarios[$x]['IdUsuario'].'&upo='.$lista_usuarios[$x]['IdOperador'].'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>';
												if($lista_usuarios[$x]['Operador'] != 'KeyPoint'){
													echo '
															<!-- Button trigger modal -->
															<button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#borrarUser'.$lista_usuarios[$x]['IdUsuario'].'" data-id_res="'.$lista_usuarios[$x]['IdUsuario'].'" data-nombre="'.$lista_usuarios[$x]['Nombre'].'" title="Eliminar"><i class="fas fa-times"></i></button>

															<!-- Modal -->
															<div class="modal fade" id="borrarUser'.$lista_usuarios[$x]['IdUsuario'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 class="modal-title" id="exampleModalLabel">Borrar Usuario</h5>
																			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body">
																			Borrar al usuario '.$lista_usuarios[$x]['Nombre'].'?
																		</div>
																		<div class="modal-footer">
																			<form action="eliminar_usuario_validate.php" method="POST">
																				<input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$lista_usuarios[$x]['IdUsuario'].'">
																				<input type="hidden" id="del_id_op" name="del_id_op" value="'.$lista_usuarios[$x]['IdOperador'].'">
																				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
																				<button type="submit" class="btn btn-danger text-white" data-id_res="'.$lista_usuarios[$x]['Nombre'].'" data-nombre="'.$lista_usuarios[$x]['Nombre'].'">Confirmar</button>
																			</form>
																		</div>
																	</div>
																</div>
															</div>';
												}
													echo '  </td>
														</tr>';

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
	<?php include_once('../includes/scripts_footer.php');?>
	<script src="./../js/typeahead.bundle.js"></script>
 	<script>
    	$(function () {
    		$('#dataTable').DataTable({
                responsive: true,
                columnDefs: [{ orderable: false, targets: 6 }, { orderable: false, targets: 3 }, { orderable: false, targets: 4 }, { orderable: false, targets: 5 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
    	});
    </script>
	<script src="./../js/listTicket_usuarios.js"></script>
</body>
</html>