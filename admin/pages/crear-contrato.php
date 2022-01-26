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
    <link rel="stylesheet" href="./../includes/datepicker/css/bootstrap-datepicker.css">
</head>
<body id="page-top">
    <?php include_once './../../../ws_include/ws_dameOperador.php';?>
    <?php include_once './../../../ws_include/ws_dameOperadoresSinContrato.php';?>
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
	              		<h1 class="h3 mb-0 text-gray-800">Crear Contrato</h1>
	              		<a href="contratos.php" class="btn btn-danger btn-icon-split">
	              			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                        </a>
	            	</div>

	            	<form action="crear_contrato_validate.php" method="POST" id="formularioOperator">
                        <div class="row">
                        	<div class="col-4">
                                <div class="form-group" id="grupo_operador">
                                    <label class="m-0 pb-2" for="nombre">Operador</label>
                                    <select name="operador" class="form-control" id="FormControlSelect">
                                        <?php 
                                        
                                        if(!is_array($objeto_dameOperadoresSinContrato) && $objeto_dameOperadoresSinContrato !== null) {

                                            if ($objeto_dameOperadoresSinContrato->IdOperador !== 0 && $objeto_dameOperadoresSinContrato->IdOperador !== 111) {

                                                echo '<option value="'.$objeto_dameOperadoresSinContrato->IdOperador.'">'.$objeto_dameOperadoresSinContrato->Nombre.'</option>';

                                            } elseif ($objeto_dameOperadoresSinContrato->IdOperador === 0 && $objeto_dameOperadoresSinContrato->IdOperador === 111) {

                                                echo '<option>No hay Operadores sin contrato</option>';

                                            }

                                        } elseif (is_array($objeto_dameOperadoresSinContrato)) {

                                            for($step=0; $step<count($objeto_dameOperadoresSinContrato); $step++) {

                                                if ($objeto_dameOperadoresSinContrato[$step]->IdOperador !== 0 && $objeto_dameOperadoresSinContrato[$step]->IdOperador !== 111) {

                                                    echo '<option value="'.$objeto_dameOperadoresSinContrato[$step]->IdOperador.'">'.$objeto_dameOperadoresSinContrato[$step]->Nombre.'</option>'; 
                                                
                                                } elseif ($objeto_dameOperadoresSinContrato[$step]->IdOperador === 0 && $objeto_dameOperadoresSinContrato[$step]->IdOperador === 111) {

                                                    echo '<option>No hay Operadores sin contrato</option>';

                                                }

                                            }

                                        } else {

                                        }
                                        
                                        ?>

                                    </select>

                                </div>
								<div class="form-group row" id="grupo__cupo">
                                    <div class="col-8">
                                        <label class="m-0 pb-2" for="cupo">Cupo de Puertas</label>
                                    </div>
                                    <div class="col-8">
                                        <input type="number" class="form-control" name="cupo" id="cupo" required data-validation-required-message="No puede dejar este campo en blanco">
                                    </div>
                                </div>
                                <div class="input-group date fj-date row">
                                    <div class="col-12">
                                        <label class="m-0 pb-2" for="desde">Desde</label>   
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="desde" name="desde" autocomplete="off"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                                <div class="input-group date fj-date row">
                                    <div class="col-12">
                                        <label class="m-0 pb-2" for="hasta">Hasta</label>   
                                    </div>
                                    <div class="col-12">
                                        <input type="text" class="form-control" id="hasta" name="hasta" autocomplete="off"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                                    </div>
                                </div>
                            </div>

                            
                            <div class="col-8">
                            	<div class="row d-flex justify-content-end" style="height: auto">
                                	<input type="hidden" name="idOperador" value="<?php echo $objeto_dameOperador->IdOperador ?>">
                                    <button type="submit" class="btn btn-lg btn-info">Crear Contrato</button>
                                </div>
                            </div>
                        </div>
                    </form>
	            </div>
	        </div>
	    </div>
	</div>
	<?php include_once('../includes/scripts_footer.php');?>
	
	<script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/src/js/intlTelInput.js"></script>
    <script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/src/js/prism.js"></script>    
    <script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/node_modules/intl-tel-input/intlTelInput.js?71"></script>
    <script src="./../includes/datepicker/js/bootstrap-datepicker.js"></script>
    <script>
        $('.fj-date').datepicker({
            format: "dd/mm/yyyy"
        });
    </script>
</body>
</html>