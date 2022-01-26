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
							<h1 class="h3 mb-0 text-gray-800">Estado Actual</h1>
                            
						</div>
	            	</div>

		            <!-- Content Table -->
		            <?php

                        require './../../../ws_include/ws2_informes.php';

                        $idLocker = $_SESSION['IdLocker'];

                        $fechaActual = date('Ymd');

                        // --- LLAMAR WS : DameEstadoLockerPorFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
                        $parametros_dameEstadoLockerPorFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'fecha'=>$fechaActual);
                        $soap_result_DELPF = $client->DameEstadoLockerPorFecha($parametros_dameEstadoLockerPorFecha);
                    
                        $objeto_dameEstadoLockerPorFecha = $soap_result_DELPF->DameEstadoLockerPorFechaResult->LineaEstado;


                    ?>
					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                        	<thead>
		                            	<tr>
		                                    <th>Nº Puerta</th>
		                                    <th>Estado</th>
		                                    <th>Operador</th>
		                                    <th>Nº Reserva</th>
		                                    <th>Nombre Reserva</th>
		                                    <th>Localizador</th>
		                                    <th>Acción</th>
		                                </tr>
		                            </thead>
									<tbody>
		                            <?php 
		                            	if(!is_array($objeto_dameEstadoLockerPorFecha) && !is_null($objeto_dameEstadoLockerPorFecha)){ // SÓLO 1

		                            	}elseif (is_array($objeto_dameEstadoLockerPorFecha)){

		                            		for ($step = 0; $step < count($objeto_dameEstadoLockerPorFecha); $step++){
                                                
                                                require './../../../ws_include/ws_Keys_consigna.php';

                                                // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameEstadoLockerPorFecha[$step]->IdOperador);
                                                $soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);
                                            
                                                $objeto_dameOperador = $soap_result_DO->DameOperadorResult;


                                                if($objeto_dameEstadoLockerPorFecha[$step]->IdOperador === $objeto_dameOperador->IdOperador && $objeto_dameOperador->IdOperador !== 0){

                                                    $nombreOperador = $objeto_dameOperador->Nombre;

                                                } elseif ($objeto_dameOperador->IdOperador === 0) {

                                                    $nombreOperador = "";

                                                }


                                                if ($objeto_dameEstadoLockerPorFecha[$step]->Estado === 0) {

                                                    $estado = 'Libre';

                                                } else {

                                                    $estado = '<strong>Reservada</strong>';

                                                }

                                                if ($objeto_dameEstadoLockerPorFecha[$step]->IdReserva !== 0) {

                                                    $idReserva = $objeto_dameEstadoLockerPorFecha[$step]->IdReserva;

                                                } else {

                                                    $idReserva = "";

                                                }


                                                echo '  
                                                
                                                <tr>
                                                    <td>'.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.'</td>
                                                    <td>'.$estado.'</td>
                                                    <td>'.$nombreOperador.'</td>
                                                    <td>'.$idReserva.'</td>
                                                    <td>'.$objeto_dameEstadoLockerPorFecha[$step]->NombreReserva.'</td>
                                                    <td>'.$objeto_dameEstadoLockerPorFecha[$step]->Localizador.'</td>
                                                    <td class="d-flex justify-content-center">

                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-info btn-circle btn-sm" data-toggle="modal" data-target="#borrarOp'.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.'" data-id_res="'.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.'" data-nombre="'.$objeto_dameEstadoLockerPorFecha[$step]->Nombre.'" title="Abrir"><i class="fas fa-door-open"></i></button>
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="borrarOp'.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Abrir Puerta</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        ¿Està seguro que quiere abrir la puerta '.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.' ?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="abrirPuerta_validate.php" method="POST">
                                                                            <input type="hidden" id="idPuerta" name="idPuerta" value="'.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.'">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-info text-white" data-id_res="'.$objeto_dameEstadoLockerPorFecha[$step]->IdPuerta.'" data-nombre="'.$objeto_dameEstadoLockerPorFecha[$step]->Nombre.'">Confirmar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
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
    </div>
    <!-- /page content -->
    <?php include_once('../includes/scripts_footer.php');?>
    <script>
    	$(function () {
    		$('#dataTable').DataTable({
                responsive: true,
                columnDefs: [{ orderable: false, targets: 4 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
    	});
    </script>
  </body>
</html>