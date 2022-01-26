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
        <?php
        include_once('../../../ws_include/ws_Keys_consigna.php');
        include_once('../../../ws_include/ws_Keys_reserva.php');
	    include_once("../includes/menu.php"); ?>
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
							<h1 class="h3 mb-0 text-gray-800">Trazabilidad por Fechas</h1>
						</div>
	            	</div>


                    <form method="POST" class="row">


                        <div class="col-12 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <input class="form-control" type="date" value="<?php if (isset($_POST['desde_trazabilidad'])) { $_SESSION['desde_trazabilidad'] = $_POST['desde_trazabilidad']; echo $_POST['desde_trazabilidad']; } elseif(isset($_SESSION['desde_trazabilidad'])) { echo $_SESSION['desde_trazabilidad']; } else { echo date("Y-m-d"); } ?>" name="desde_trazabilidad" id="example-date-input" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada desde">   
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <input class="form-control" type="date" value="<?php if (isset($_POST['hasta_trazabilidad'])) { $_SESSION['hasta_trazabilidad'] = $_POST['hasta_trazabilidad']; echo $_POST['hasta_trazabilidad']; } elseif(isset($_SESSION['hasta_trazabilidad'])) { echo $_SESSION['hasta_trazabilidad']; } else { $hoy = time(); $quinceDiasEnSegundos = 24*60*60*15; $quinceDias=$hoy+$quinceDiasEnSegundos;  echo $quinceDias=date("Y-m-d", $quinceDias);} ?>" name="hasta_trazabilidad" id="example-date-input2" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada hasta"> 
                            </div>
                        </div>

                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 mb-4">
                            <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="float-right float-sm-none btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                        </div>

                    </form>


		            <!-- Content Table -->
		            <?php

                        $desde = date("Ymd", strtotime($_POST['desde_trazabilidad']));
                        $hasta = date("Ymd", strtotime($_POST['hasta_trazabilidad']));

                        // --- LLAMAR WS : DameAperturasEntreFechas 
                        $parametros_dameAperturasEntreFechas = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'desde'=>$desde, 'hasta'=>$hasta);
                        $soap_result_DAEF = $SoapClient_KeysReserva->DameAperturasEntreFechas($parametros_dameAperturasEntreFechas);

                        $objeto_dameAperturasEntreFechas = $soap_result_DAEF->DameAperturasEntreFechasResult->Apertura;
						
					?>
					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
		                        	<thead>
		                            	<tr>
		                                    <th>Fecha y Hora</th>
		                                    <th>Nº Reserva</th>
		                                    <th>Acción</th>
		                                    <th>Operador</th>
		                                    <th>Nombre</th>
		                                    <th>Puerta</th>
		                                </tr>
		                            </thead>
									<tbody>
                                        <?php 

                                            if (!is_array($objeto_dameAperturasEntreFechas) && !is_null($objeto_dameAperturasEntreFechas)) {



                                            } elseif (is_array($objeto_dameAperturasEntreFechas)) {

                                                for ($step=0; $step<count($objeto_dameAperturasEntreFechas); $step++) {

                                                    $estiloNombre = "";
                                                    $estiloOperador = "";

                                                    $fecha = date("d-m-Y - H:i:s:A", strtotime($objeto_dameAperturasEntreFechas[$step]->Fecha));



                                                    // --- LLAMAR WS : DameOperador 
                                                    $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$objeto_dameAperturasEntreFechas[$step]->IdOperador);
                                                    $soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);

                                                    $objeto_dameOperador = $soap_result_DO->DameOperadorResult;


                                                    if ($objeto_dameAperturasEntreFechas[$step]->IdOperador === $objeto_dameOperador->IdOperador) {

                                                        $nombreOperador = $objeto_dameOperador->Nombre;

                                                    } else {

                                                        $nombreOperador = "Operador Eliminado";
                                                        $estiloOperador = "style='color: red;'";

                                                    }



                                                    // --- LLAMAR WS : DameUsuario 
                                                    $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$objeto_dameAperturasEntreFechas[$step]->IdOperador, 'IdUsuario'=>$objeto_dameAperturasEntreFechas[$step]->IdUsuario);
                                                    $soap_result_DU = $SoapClient_KeysConsigna->DameUsuario($parametros_dameUsuario);

                                                    $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;


                                                    


                                                    // --- LLAMAR WS : DameReserva 
                                                    $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$objeto_dameAperturasEntreFechas[$step]->IdOperador, 'IdReserva'=>$objeto_dameAperturasEntreFechas[$step]->IdReserva);
                                                    $soap_result_DR = $SoapClient_KeysReserva->DameReserva($parametros_dameReserva);

                                                    $objeto_dameReserva = $soap_result_DR->DameReservaResult;



                                                    if ($objeto_dameAperturasEntreFechas[$step]->Tipo === 1) {
                                                        
                                                        $accion = 'Entregado';

                                                        if ($objeto_dameAperturasEntreFechas[$step]->IdUsuario === $objeto_dameUsuario->IdUsuario) {

                                                            $nombre = $objeto_dameUsuario->Nombre;
    
                                                        } else {

                                                            $nombre = "Usuario Eliminado";
                                                            $estiloNombre = "style='color: red;'";

                                                        }


                                                    } elseif ($objeto_dameAperturasEntreFechas[$step]->Tipo === 2) {

                                                        $accion = 'Recogido';

                                                        if ($objeto_dameAperturasEntreFechas[$step]->IdReserva === $objeto_dameReserva->IdReserva) {

                                                            $nombre = $objeto_dameReserva->Nombre;
    
                                                        } else {

                                                            $nombre = "Reserva Eliminada";

                                                        }


                                                    } elseif ($objeto_dameAperturasEntreFechas[$step]->Tipo === 9){

                                                        $accion = 'Apertura Manual';

                                                        if ($objeto_dameAperturasEntreFechas[$step]->IdUsuario === $objeto_dameUsuario->IdUsuario) {

                                                            $nombre = $objeto_dameUsuario->Nombre;
    
                                                        } else {

                                                            $nombre = "Usuario Eliminado";
                                                            $estiloNombre = "style='color: red;'";

                                                        }

                                                    }


                                                    // Si el número de reserva es 0 no se muestra nada
                                                    if ($objeto_dameAperturasEntreFechas[$step]->IdReserva !== 0) {

                                                        $idReserva = $objeto_dameAperturasEntreFechas[$step]->IdReserva;

                                                    } else {

                                                        $idReserva = '';

                                                    }


                                                    if ($objeto_dameAperturasEntreFechas[$step]->IdPuerta !== 99) {


                                                        echo '  <tr>
                                                            <td>'.$fecha.'</td>
                                                            <td>'.$idReserva.'</td>
                                                            <td>'.$accion.'</td>
                                                            <td '.$estiloOperador.'>'.$nombreOperador.'</td>
                                                            <td '.$estiloNombre.'>'.$nombre.'</td>
                                                            <td>'.$objeto_dameAperturasEntreFechas[$step]->IdPuerta.'</td>
                                                            
                                                        </tr>';

                                                    }


                                                    

                                                }

                                            } else {

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
            tablalockers = $('#dataTable').DataTable({
                responsive: true,
                searching: true,
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-pdf \" title=\"Exportar a PDF\"></span>',
                    filename : 'trazabilidadPorFechas',
                    title: 'Trazabilidad por Fechas',
                    pageSize: 'A4',
                    orientation: 'landscape',
                    download: 'open',
                    exportOptions: {columns: [0,1,2,3,4,5]},
                    customize : function(doc) {
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = [ '20%', '15%', '15%', '20%', '20%', '10%' ];
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
                    filename : 'trazabilidadPorFechas',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    exportOptions: {columns: [0,1,2,3,4,5]},
                    }],             
                language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
        });
    </script>


<!-- <script src="./../js/listTicket_trazabilidadPorFechas.js"></script> -->
  </body>
</html>