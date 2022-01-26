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

// WS PARA RECUPERAR LOS DATOS DEL LOCKER
if(!isset($_GET['upd'])){
	header("location:lockers.php");
}else{
	$id_locker = $_GET['upd'];
}
$soap_lockers = array('token'=>$token_ws, 'IdLocker'=>$id_locker);
$soap_lockers_result = $SoapClient_KeysConsigna->__soapCall('DameLocker', array($soap_lockers));
$objeto_dameLocker = $soap_lockers_result->DameLockerResult;
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
        		<h1 class="h3 mb-0 text-gray-800">Actualizar Locker</h1>
        		<a href="lockers.php" class="btn btn-danger btn-icon-split">
        			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                </a>
        	</div>

        	<form action="actualizar_locker_validate.php" method="POST" id="formularioLocker">
          	<div class="row">
          		<div class="col-3 col-sm-2 col-md-2 col-lg-2 col-xl-1">
								<div class="form-group" id="grupo__id">
                  <label class="m-0 pb-2" for="id_lock">Id.</label>
                  <input type="text" class="form-control form-control-user" name="id_lock" id="id_lock" readonly="readonly" value="<?php echo $objeto_dameLocker->IdLocker; ?>">
              	</div>
            	</div>
            </div>
            <div class="row">
              <div class="col-10 col-sm-8 col-md-8 col-lg-8 col-xl-4">
								<div class="form-group" id="grupo__nombre">
                  <label class="m-0 pb-2" for="nombre">Nombre</label>
                  <input type="text" class="form-control form-control-user" name="nombre" id="nombre" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_dameLocker->Nombre; ?>">
              	</div>
          		</div>
          	</div>
          	<div class="row">
          		<div class="col-8 col-sm-4 col-md-4 col-lg-3 col-xl-2">
	          		<div class="form-group" id="grupo__serie">
	                <label class="m-0 pb-2" for="serie">Núm. de Serie</label>
	                <input type="text" class="form-control form-control-user" name="serie" id="serie" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_dameLocker->NumeroSerie; ?>">
	            	</div>
	            </div>
	          </div>
	          <div class="row">
	            <div class="col-8 col-sm-4 col-md-4 col-lg-3 col-xl-2">
	          		<div class="form-group" id="grupo__estado">
	                <label class="m-0 pb-2" for="estado">Estado</label>
	                <select class="form-control form-control-user" id="estado" name="estado" required value="<?php echo $objeto_dameLocker->Estado; ?>">>
                    <option value="1">Activo</option>
                    <option value="0">Prueba</option>
                  </select>
	            	</div>
	            </div>
          	</div>
          	<div class="row">
          		<div class="col-8 col-sm-4 col-md-4 col-lg-3 col-xl-2">
	          		<div class="form-group" id="grupo__vpn">
	                <label class="m-0 pb-2" for="vpn">VPN</label>
	                <input type="text" class="form-control form-control-user" name="vpn" id="vpn" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_dameLocker->VPN; ?>">
	            	</div>
	            </div>
	          </div>
	          <div class="row">
	            <div class="col-8 col-sm-4 col-md-4 col-lg-3 col-xl-2">
	          		<div class="form-group" id="grupo__bd">
	                <label class="m-0 pb-2" for="bd">Base de Datos</label>
	                <input type="text" class="form-control form-control-user" name="bd" id="bd" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_dameLocker->BD; ?>">
	            	</div>
	            </div>
	          </div>
	          <div class="row">
 							<div class="col-12 col-sm-12 col-md-10 col-lg-10 col-xl-6">
	          		<div class="form-group" id="grupo___url">
	                <label class="m-0 pb-2" for="bd">Url Maps</label>
	                <input type="text" class="form-control form-control-user" name="urlMaps" id="urlMaps"  value="<?php echo $objeto_dameLocker->URLMaps; ?>">
	            	</div>
	            </div>	            
          	</div>
          	<div class="col-8 col-sm-6 col-md-4 col-lg-3 col-xl-2">
            	<div class="row d-flex justify-content-start" style="height: auto">
                <button type="submit" class="btn btn-lg btn-info" id="btn_agregar">Actualizar Locker</button>
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