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

// WS PARA RECUPERAR LOS DATOS DEL OPERADOR
if(!isset($_GET['upd'])){
	header("location:operadores.php");
}else{
	$idRol = $_GET['upd'];
}
$parametros_ws = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdRol'=>$idRol);
$soap_result_rol = $SoapClient_KeysConsigna->DameRol($parametros_ws);
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
	            	<div class="d-sm-flex align-items-center justify-content-between mb-4">
	              		<h1 class="h3 mb-0 text-gray-800">Modificar Rol</h1>
	              		<a href="operadores.php" class="btn btn-danger btn-icon-split">
	              			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                        </a>
	            	</div>

	            	<form action="actualizar_rol_validate.php" method="POST" id="formularioOperator">
                        <div class="row">
                        	<div class="col-4">
								<div class="form-group" id="grupo__nombre">
                                    <label class="m-0 pb-2" for="nombre">Nombre</label>
                                    <input type="text" class="form-control form-control-user" name="nombre" id="nombre" value="<?php echo $soap_result_rol->DameRolResult->Nombre; ?>" required data-validation-required-message="No puede dejar este campo en blanco">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group" id="grupo__url">
                                    <label class="m-0 pb-2" for="url">URL</label>
                                    <input type="text" class="form-control form-control-user" name="url" id="url" value="<?php echo $soap_result_rol->DameRolResult->Url; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                            	<div class="row d-flex justify-content-end" style="height: auto">
                                	<input type="hidden" name="idRol" value="<?php echo $soap_result_rol->DameRolResult->IdRol; ?>">
                                    <button type="submit" class="btn btn-lg btn-info">Actualizar Rol</button>
                                </div>
                            </div>
                        </div>
                    </form>
	            </div>
	        </div>
	    </div>
	</div>
	<?php include_once('../includes/scripts_footer.php');?>
</body>
</html>