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
							<h1 class="h3 mb-0 text-gray-800">Disponiblidad por Operador</h1>
						</div>
	            	</div>

		            <!-- Content Table -->
		            <?php // --- LLAMAR WS : DameOperadores 
		    			$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
		    			$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

                        $objeto_dameOperadores = $soap_result_DO->DameOperadoresResult->Operador;

						    /* $numberFormated = str_pad($randNumber); */

                            $operadorSeleccionado = $_POST['operador']

					?>

                    <form action="disponiblidad.php" class="row" method="POST">

                        <select name="operador" id="operador" class="custom-select col-4 mb-3">

                            <?php 
                            
                                if (!is_array($objeto_dameOperadores) && !is_null($objeto_dameOperadores)) {

                                    if ($objeto_dameOperadores->IdOperador !== 0 && $objeto_dameOperadores->IdOperador !== 111) {

                                        echo "<option value='".$objeto_dameOperadores->IdOperador."'>".$objeto_dameOperadores->Nombre."</option>";

                                    }


                                } elseif (is_array($objeto_dameOperadores)) {

                                    for ($step=0; $step<count($objeto_dameOperadores); $step++) {

                                        if ($objeto_dameOperadores[$step]->IdOperador !== 0 && $objeto_dameOperadores[$step]->IdOperador !== 111) {

                                            if ($operadorSeleccionado == $objeto_dameOperadores[$step]->IdOperador) {

                                                $operadorASeleccionar = "selected";

                                            } else {

                                                $operadorASeleccionar = "";

                                            }

                                            echo "<option ".$operadorASeleccionar." value='".$objeto_dameOperadores[$step]->IdOperador."'>".$objeto_dameOperadores[$step]->Nombre."</option>";

                                        }

                                    }

                                } else {
                                    // Sin operadores
                                }
                            
                            ?>
                            
                        </select>

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
                                        

					<div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive">
		                        <table class="table table-bordered" id="dataTable" cellspacing="0" width="100%">
		                        	<thead>
		                            	<tr>
		                                    <th>Fecha</th>
		                                    <th>Total</th>
		                                    <th>Asignadas</th>
		                                    <th>Libres</th>
		                                    <th>Reservadas</th>
		                                </tr>
		                            </thead>
									<tbody>
		                            <?php 

                                        $idOperador = intval($_POST['operador']);
                                        $desde = date("Ymd", strtotime($_POST['desde_disponiblidad']));
                                        $hasta = date("Ymd", strtotime($_POST['hasta_disponiblidad']));

                                        // --- LLAMAR WS : DameOcupacionEntreFechas 
                                        $parametros_dameOcupacionEntreFechas = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
                                        $soap_result_DOEF = $SoapClient_KeysReserva->DameOcupacionEntreFechas($parametros_dameOcupacionEntreFechas);

                                        $objeto_dameOcupacionEntreFechas = $soap_result_DOEF->DameOcupacionEntreFechasResult->DisponibleDia;

                                        if (!is_array($objeto_dameOcupacionEntreFechas) && !is_null($objeto_dameOcupacionEntreFechas)) {

                                            $fecha = date("d-m-Y", strtotime($objeto_dameOcupacionEntreFechas->Fecha));


                                            echo '
                                        
                                            <tr>
                                                <td>'.$fecha.'</td>
                                                <td>'.$objeto_dameOcupacionEntreFechas->Asignadas.'</td>
                                                <td>'.$objeto_dameOcupacionEntreFechas->Total.'</td>
                                                <td>'.$objeto_dameOcupacionEntreFechas->Libres.'</td>
                                                <td>'.$objeto_dameOcupacionEntreFechas->Reservadas.'</td>
                                            </tr>
                                            
                                            ';


                                        } elseif (is_array($objeto_dameOcupacionEntreFechas)) {

                                            for ($step=0; $step<count($objeto_dameOcupacionEntreFechas); $step++) {

                                                $fecha = date("d-m-Y", strtotime($objeto_dameOcupacionEntreFechas[$step]->Fecha));


                                                echo '
                                            
                                                <tr>
                                                    <td>'.$fecha.'</td>
                                                    <td>'.$objeto_dameOcupacionEntreFechas[$step]->Asignadas.'</td>
                                                    <td>'.$objeto_dameOcupacionEntreFechas[$step]->Total.'</td>
                                                    <td>'.$objeto_dameOcupacionEntreFechas[$step]->Libres.'</td>
                                                    <td>'.$objeto_dameOcupacionEntreFechas[$step]->Reservadas.'</td>
                                                </tr>
                                                
                                                ';

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
                    filename : 'disponiblidadPorOperador',
                    title: 'Disponiblidad por Operador',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    download: 'open',
                    exportOptions: {columns: [0,1,2,3,4]},
                    customize : function(doc) {
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = [ '30%', '18%', '18%', '17%', '17%'];
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
                    filename : 'disponiblidadPorOperador',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    exportOptions: {columns: [0,1,2,3,4]},
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
    </script>

  </body>
</html>