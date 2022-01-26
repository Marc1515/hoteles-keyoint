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
    <link rel="stylesheet" href="./../includes/datepicker/css/bootstrap-datepicker.css">
    <!--alerts CSS -->
    <link href="./../../assets/node_modules/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <?php

    require './../../../ws_include/ws_Keys_reserva.php';
    require './../../../ws_include/ws_Keys_consigna.php';

    $idLocker = $_SESSION['IdLocker'];
    
    $idOperadorString = $_GET['upd'];
    $idOperador = intval($idOperadorString);
    
    // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
    $soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);
    
    $objeto_dameContrato = $soap_result_DC->DameContratoResult; 
    
    $desdeDate = DateTime::createFromFormat('Ymd', $objeto_dameContrato->Desde);
    $desde = $desdeDate->format('d/m/Y');

    $hastaDate = DateTime::createFromFormat('Ymd', $objeto_dameContrato->Hasta);
    $hasta = $hastaDate->format('d/m/Y');


    // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
    $soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);

    $objeto_dameOperador = $soap_result_DO->DameOperadorResult;
    
    ?>

    <?php require './../../../ws_include/ws_dameOperadoresSinContrato.php'; ?>
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
	              		<h1 class="h3 mb-0 text-gray-800">Modificar Contrato</h1>
	              		<a href="contratos.php" class="btn btn-danger btn-icon-split">
	              			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                        </a>
	            	</div>

	            	<form action="actualizar_contrato_validate.php?upd=<?php echo $_GET['upd']?>" method="POST" id="formularioOperator">
                        <div class="row">
                        	<div class="col-4">
                                <div hidden class="form-group row" id="grupo__idOperador">
                                    <div class="col-8">
                                        <label class="m-0 pb-2" for="idOperador">ID Operador</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="idOperador" id="idOperador" value="<?php echo $objeto_dameOperador->IdOperador ?>" required data-validation-required-message="No puede dejar este campo en blanco" readonly>
                                    </div>
                                </div>
                                <div class="form-group row" id="grupo__operador">
                                    <div class="col-8">
                                        <label class="m-0 pb-2" for="operador">Operador</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="operador" id="operador" value="<?php echo $objeto_dameOperador->Nombre ?>" required data-validation-required-message="No puede dejar este campo en blanco" readonly>
                                    </div>
                                </div>
								<div class="form-group row" id="grupo__cupo">
                                    <div class="col-8">
                                        <label class="m-0 pb-2" for="cupo">Cupo de Puertas</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="text" class="form-control" name="cupo" id="cupo" value="<?php echo $objeto_dameContrato->Cupo ?>" required data-validation-required-message="No puede dejar este campo en blanco">
                                    </div>
                                </div>
                                <div class="input-group date fj-date row">
                                    <div class="col-12">
                                        <label class="m-0 pb-2" for="desde">Desde</label>   
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="desde" name="desde" autocomplete="off" value="<?php echo $desde ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                                <div class="input-group date fj-date row">
                                    <div class="col-12">
                                        <label class="m-0 pb-2" for="hasta">Hasta</label>   
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="hasta" name="hasta" autocomplete="off" value="<?php echo $hasta ?>"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-8">
                            	<div class="row d-flex justify-content-end" style="height: auto">
                                	<input type="hidden" name="idOperador" value="<?php echo $objeto_dameOperador->IdOperador ?>">
                                    <button type="submit" class="btn btn-lg btn-info" id="botonActualizar">Actualizar Contrato</button>
                                </div>
                            </div>
                        </div>
                    </form>
	            </div>
	        </div>
	    </div>
	</div>
	<?php include_once('../includes/scripts_footer.php');?>
	<script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/main/modules/js/form_operador.js"></script>
	<script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/src/js/intlTelInput.js"></script>
    <script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/src/js/prism.js"></script>    
    <script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/node_modules/intl-tel-input/intlTelInput.js?71"></script>
    <script src="./../includes/datepicker/js/bootstrap-datepicker.js"></script>
    <!-- Sweet-Alert  -->
    <script src="./../../assets/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
    <script src="./../../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
    <script>
        $('.fj-date').datepicker({
            format: "dd/mm/yyyy"
        });
    </script>
    <script>

        $(document).ready(function() {

            $('#cupo').keyup(function(e) {

                let cupo = document.getElementById('cupo').value;
                let idOperador = document.getElementById('idOperador').value;
                let dataString = "cupo="+cupo+"&idOperador="+idOperador;

                
                $.ajax({
                    type: 'POST',
                    url: './../../../ws_include/ws_damePuertasCupoPorOperador.php',
                    data: dataString,
                    dataType: 'json',
                    success: function(response) {

                        if (response === null) {

                            console.log(response);

                        } else {

                            if (cupo < response.numPuertas && cupo != '') {

                                let total = response.numPuertas - cupo;

                                if (total === 1) {

                                    Swal.fire({
                                        type: 'error',
                                        title: 'Antes debe que quitar ' + total + ' puerta!',
                                        text: 'Debe dirigirse al apartado de Administrar Puertas!',
                                        footer: '<a href="administrar-puertas.php">Administrar Puertas</a>'
                                    });


                                } else {

                                    Swal.fire({
                                        type: 'error',
                                        title: 'Antes debe que quitar ' + total + ' puertas!',
                                        text: 'Debe dirigirse al apartado de Administrar Puertas!',
                                        footer: '<a href="administrar-puertas.php">Administrar Puertas</a>'
                                    });
                                }
                                
                            } else if (cupo > response.numPuertas && cupo != '') {

                                let total = cupo - response.numPuertas;

                                $.ajax({
                                    type: 'POST',
                                    url: './../../../ws_include/ws_dameCupoDisponible.php',
                                    data: total,
                                    dataType: 'json',
                                    success: function(response) {

                                        if (total > response.cupoDisponible) {

                                            Swal.fire({
                                                type: 'error',
                                                title: 'NO hay tantas puertas disponibles!',
                                                text: 'Solo dispone de ' + response.cupoDisponible + ' puertas libres',
                                                footer: '<a href="administrar-puertas.php">Administrar Puertas</a>'
                                            });
        
                                        }

                                    }

                                });


                            }

                        }

                    }

                });

            });

        });

    </script>

</body>
</html>
