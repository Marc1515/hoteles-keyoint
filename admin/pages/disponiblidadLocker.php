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
        .botonesSubtabla {display: inline-block !important;  margin-right: 200px !important;};
    </style>
    <link rel="stylesheet" href="./../css/disponiblidad.css">    
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
							<h1 class="h3 mb-0 text-gray-800">Disponiblidad Locker</h1>
						</div>
	            	</div>


                    <form action="disponiblidadLocker.php" class="row" method="POST">

                        <div class="col-3 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <input class="form-control" type="date" value="<?php if (isset($_POST['desde_disponiblidad'])) { $_SESSION['desde_disponiblidad'] = $_POST['desde_disponiblidad']; echo $_POST['desde_disponiblidad']; } elseif(isset($_SESSION['desde_disponiblidad'])) { echo $_SESSION['desde_disponiblidad']; } else { echo date("Y-m-d"); } ?>" name="desde_disponiblidad" id="example-date-input" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada desde">   
                            </div>
                        </div>

                        <div class="col-3 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <input class="form-control" type="date" value="<?php if (isset($_POST['hasta_disponiblidad'])) { $_SESSION['hasta_disponiblidad'] = $_POST['hasta_disponiblidad']; echo $_POST['hasta_disponiblidad']; } elseif(isset($_SESSION['hasta_disponiblidad'])) { echo $_SESSION['hasta_disponiblidad']; } else { $hoy = time(); $quinceDiasEnSegundos = 24*60*60*15; $quinceDias=$hoy+$quinceDiasEnSegundos;  echo $quinceDias=date("Y-m-d", $quinceDias);} ?>" name="hasta_disponiblidad" id="example-date-input2" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada hasta"> 
                            </div>
                        </div>

                        <div class="col-2 col-sm-12 col-md-12 col-lg-4 mb-4">
                            <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="float-right float-sm-none btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                        </div>

                    </form>

		            <?php
                    
                        $desde = date('Ymd', strtotime($_POST['desde_disponiblidad']));
                        $hasta = date('Ymd', strtotime($_POST['hasta_disponiblidad']));

                    
                        // --- LLAMAR WS : DameBooking 
		    			$parametros_dameBooking = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'Desde'=>$desde, 'Hasta'=>$hasta);
		    			$soap_result_DB = $SoapClient_KeysReserva->DameBooking($parametros_dameBooking);

                        $objeto_dameBooking = $soap_result_DB->DameBookingResult->LineaBooking;


					?>
                                        

                    <!-- Content Table -->
					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered tablaDisponiblidad" id="dataTable" cellspacing="0" width="100%">
		                        	<thead>
		                            	<tr>
		                                    <th>Fecha</th>
		                                    <th>OcultarFecha</th>
		                                    <th>Total</th>
		                                    <th>Contrato</th>
		                                    <th>Libres</th>
		                                </tr>
		                            </thead>
									<tbody>
		                            <?php 

                                        if (!is_array($objeto_dameBooking) && !is_null($objeto_dameBooking)) {

                                            $fecha = date("Ymd", strtotime($objeto_dameBooking->Fecha));


                                            echo '
                                        
                                                <tr onclick="infoSubTabla('.$fecha.')" data-toggle="modal" data-target="#modal'.$fecha.'">

                                                    <td>'.$objeto_dameBooking->Fecha.'</td>
                                                    <td>'.$fecha.'</td>
                                                    <td>'.$objeto_dameBooking->Total.'</td>
                                                    <td>'.$objeto_dameBooking->Contrato.'</td>
                                                    <td>'.$objeto_dameBooking->Libres.'</td>

                                                </tr>';


                                        } elseif (is_array($objeto_dameBooking)) {

                                            for ($step=0; $step<count($objeto_dameBooking); $step++) {

                                                $fecha = date("Ymd", strtotime($objeto_dameBooking[$step]->Fecha));


                                                echo '
                                            
                                                    <tr onclick="infoSubTabla('.$fecha.')" data-toggle="modal" data-target="#modal'.$fecha.'">

                                                        <td>'.$objeto_dameBooking[$step]->Fecha.'</td>
                                                        <td>'.$fecha.'</td>
                                                        <td>'.$objeto_dameBooking[$step]->Total.'</td>
                                                        <td>'.$objeto_dameBooking[$step]->Contrato.'</td>
                                                        <td>'.$objeto_dameBooking[$step]->Libres.'</td>

                                                    </tr>';

                                            }

                                        } else {



                                        }




		                                ?>
		                            </tbody>
		                        </table>
                                <?php

                                if (!is_array($objeto_dameBooking) && !is_null($objeto_dameBooking)) {


                                    $fecha = date("Ymd", strtotime($objeto_dameBooking->Fecha));

                                    echo '<div id="modal'.$fecha.'" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">'.$objeto_dameBooking->Fecha.'</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                    
                                                        <table class="table table-bordered">

                                                            <thead>
                                                            
                                                                <tr>
                                                                
                                                                    <th>Nº Operador</th>
                                                                    <th>Nombre</th>
                                                                    <th>Contratadas</th>
                                                                
                                                                </tr>

                                                            </thead>

                                                            <tbody>';
                
                
                                                            // --- LLAMAR WS : DameDetalleBooking 
                                                            $parametros_dameDetalleBooking = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'Fecha'=>$fecha);
                                                            $soap_result_DDB = $SoapClient_KeysReserva->DameDetalleBooking($parametros_dameDetalleBooking);
                
                                                            $objeto_dameDetalleBooking = $soap_result_DDB->DameDetalleBookingResult->DetalleBooking;
                
                
                                                            if (!is_array($objeto_dameDetalleBooking) && !is_null($objeto_dameDetalleBooking)) {

                                                                echo '
                                                                        <tr>
                                                                        
                                                                            <td>'.$objeto_dameDetalleBooking->IdOperador.'</td>
                                                                            <td>'.$objeto_dameDetalleBooking->Nombre.'</td>
                                                                            <td>'.$objeto_dameDetalleBooking->Contratadas.'</td>
                                                                        
                                                                        </tr>';
                
                
                                                            } elseif (is_array($objeto_dameDetalleBooking)) {
                
                                                                for ($step2=0; $step2<count($objeto_dameDetalleBooking); $step2++) {
                
                
                                                                    echo '
                                                                        <tr>
                                                                        
                                                                            <td>'.$objeto_dameDetalleBooking[$step2]->IdOperador.'</td>
                                                                            <td>'.$objeto_dameDetalleBooking[$step2]->Nombre.'</td>
                                                                            <td>'.$objeto_dameDetalleBooking[$step2]->Contratadas.'</td>
                                                                        
                                                                        </tr>';
                
                
                                                                }
                
                                                            } else {
                
                                                            }
                                                        
                                        echo '
                                                            </tbody>
                                                        </table>  
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>';


                                } elseif (is_array($objeto_dameBooking)) {

                                    for ($step3=0; $step3<count($objeto_dameBooking); $step3++) {

                                        $fecha = date("Ymd", strtotime($objeto_dameBooking[$step3]->Fecha));

                                        echo '<div id="modal'.$fecha.'" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle"><strong>'.$objeto_dameBooking[$step3]->Fecha.'</strong></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        
                                                            <table style="width: 100% !important" id="subTable'.$fecha.'" class="table table-bordered">

                                                                <thead>
                                                                
                                                                    <tr>
                                                                    
                                                                        <th>Nº Operador</th>
                                                                        <th>Nombre</th>
                                                                        <th>Contratadas</th>
                                                                    
                                                                    </tr>

                                                                </thead>

                                                                <tbody>';
                    
                    
                                                                // --- LLAMAR WS : DameDetalleBooking 
                                                                $parametros_dameDetalleBooking = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'Fecha'=>$fecha);
                                                                $soap_result_DDB = $SoapClient_KeysReserva->DameDetalleBooking($parametros_dameDetalleBooking);
                    
                                                                $objeto_dameDetalleBooking = $soap_result_DDB->DameDetalleBookingResult->DetalleBooking;
                    
                    
                                                                if (!is_array($objeto_dameDetalleBooking) && !is_null($objeto_dameDetalleBooking)) {

                                                                    echo '
                                                                    <tr>
                                                                    
                                                                        <td>'.$objeto_dameDetalleBooking->IdOperador.'</td>
                                                                        <td>'.$objeto_dameDetalleBooking->Nombre.'</td>
                                                                        <td>'.$objeto_dameDetalleBooking->Contratadas.'</td>
                                                                    
                                                                    </tr>';
                    
                    
                                                                } elseif (is_array($objeto_dameDetalleBooking)) {
                    
                                                                    for ($step2=0; $step2<count($objeto_dameDetalleBooking); $step2++) {
                    
                    
                                                                        echo '
                                                                            <tr>
                                                                            
                                                                                <td>'.$objeto_dameDetalleBooking[$step2]->IdOperador.'</td>
                                                                                <td>'.$objeto_dameDetalleBooking[$step2]->Nombre.'</td>
                                                                                <td>'.$objeto_dameDetalleBooking[$step2]->Contratadas.'</td>
                                                                            
                                                                            </tr>';
                    
                    
                                                                    }
                    
                                                                } else {
                    
                                                                }
                                                            
                                            echo '
                                                                </tbody>
                                                            </table>  
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';



                                            }

                                        } else {



                                        }


                                ?>
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
                    filename : 'disponiblidadLocker',
                    title: 'Disponiblidad Locker',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    download: 'open',
                    exportOptions: {columns: [0,2,3,4]},
                    customize : function(doc) {
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = [ '40%', '20%', '20%', '20%'];
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
                    filename : 'disponiblidadLocker',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    exportOptions: {columns: [0,2,3,4]},
                    }],             
                "displayLength":25,
                "columns": [{"searchable": true},{"searchable": false},{"searchable": false},{"searchable": false},{"searchable": false}],
                language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                columnDefs: [
                    {orderable: false, targets: [1,2,3,4]}
                ],
                order: [1, 'asc']
            });

        });


        function infoSubTabla (fecha) {
            
            tablalockers = $('#subTable'+fecha).DataTable({
                responsive: true,
                paging: false,
                searching: false,
                destroy: true,
                dom: 'Brt',
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-pdf \" title=\"Exportar a PDF\"></span>',
                    filename : 'disponiblidadLockerPorFecha',
                    title: 'Disponiblidad Locker por Fecha',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    download: 'open',
                    exportOptions: {columns: [0,1,2]},
                    customize : function(doc) {
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = [ '20%', '60%', '20%'];
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
                    filename : 'disponiblidadLockerPorFecha',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    exportOptions: {columns: [0,1,2]},
                    }],             
                "displayLength":25,
                "columns": [{"searchable": true},{"searchable": false},{"searchable": false}],
                language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                columnDefs: [
                    {orderable: false, targets: [1,2]}
                ],
                order: [1, 'asc']
            });
            

        };


    </script>

  </body>
</html>