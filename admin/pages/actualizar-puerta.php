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

// WS PARA RECUPERAR LOS DATOS DE LA PUERTA
if(!isset($_GET['upd'])){
	header("location:puertas.php");
}else{	
	$id_puerta = $_GET['upd'];
}
$soap_puerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdPuerta'=>$id_puerta);
$soap_puerta_result = $SoapClient_KeysConsigna->__soapCall('DamePuerta', array($soap_puerta));

$objeto_damePuerta = $soap_puerta_result->DamePuertaResult;
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
        		<h1 class="h3 mb-0 text-gray-800">Actualizar Puerta</h1>
        		<a href="puertas.php" class="btn btn-danger btn-icon-split">
        			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                </a>
        	</div>

        	<form action="actualizar_puerta_validate.php" method="POST" id="formularioPuerta">
          	<div class="row">
	           	<div class="col-3">
								<div class="form-group" id="grupo__id">
                  <label class="m-0 pb-2" for="id_puerta">Id.</label>
                  <input type="text" class="form-control form-control-user" name="id_puerta" id="id_puerta" readonly="readonly" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_damePuerta->IdPuerta; ?>">
              	</div>
            	</div>
	            <div class="col-3">
								<div class="form-group" id="grupo__nombre">
	                <label class="m-0 pb-2" for="nombre">Nombre</label>
	                <input type="text" class="form-control form-control-user" name="nombre" id="nombre" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_damePuerta->Nombre; ?>">
	            	</div>
	        		</div>
          	</div>
          	<div class="row">
          		<div class="col-2">
	          		<div class="form-group" id="grupo__cu">
	                <label class="m-0 pb-2" for="puertocu">Puerto CU</label>
	                <input type="text" class="form-control form-control-user" name="puertocu" id="puertocu" required data-validation-required-message="No puede dejar este campo en blanco" value="<?php echo $objeto_damePuerta->PuertoCU; ?>">
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__activa">
	                <label class="m-0 pb-2" for="activa">Activa</label>
	                <select class="form-control form-control-user" id="activa" name="activa" required>
	                	<?php
	                		if($objeto_damePuerta->Activa == TRUE){
	                			$essi = 'selected="selected"';
	                			$esno = '';
	                		}else{
	                			$essi = '';
	                			$esno = 'selected="selected"';
	                		}
	                	?>
                    <option value="Sí" <?php echo $essi;?>>Sí</option>
                    <option value="No" <?php echo $esno;?>>No</option>
                  </select>
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__idtipo">
	                <label class="m-0 pb-2" for="idtipo">Tipo de puerta</label>
	                <select class="form-control form-control-user" id="idtipo" name="idtipo" required>
	                	<?php
	                	// Tipo Puerta
									  $parametros_DameTiposPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
									  $soap_tipospuerta_result = $SoapClient_KeysConsigna->DameTiposPuerta($parametros_DameTiposPuerta);

									  if((array)$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta->IdLocker){ // SÓLO 1
									  	echo '<option value="'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta->IdTipoPuerta.'">'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta->Nombre.'</option>';
									  }else{
									  	for ($x = 0; $x < count((array)$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta); $x++){
									  		if($objeto_damePuerta->IdTipoPuerta == $soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta[$x]->IdTipoPuerta){
									  			$estipopuerta = ' selected="selected"';
									  		}else{
									  			$estipopuerta = '';
									  		}
									  		echo '<option value="'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta[$x]->IdTipoPuerta.'"'.$estipopuerta.'>'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta[$x]->Nombre.'</option>';
									  	}
									  }
	                	?>
                  </select>
	            	</div>
	            </div>
          	</div>
          	<div class="row">
          		<div class="col-2">
	          		<div class="form-group" id="grupo__idcontrola">
	                <label class="m-0 pb-2" for="idcontrola">Controlador</label>
	                <select class="form-control form-control-user" id="idcontrola" name="idcontrola" required>
                    <?php
	                	// Controladores
									  $parametros_DameControladores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
									  $soap_controladores_result = $SoapClient_KeysConsigna->DameControladores($parametros_DameControladores);

									  if((array)$soap_controladores_result->DameControladoresResult->Controlador->IdLocker){ // SÓLO 1
									  	echo '<option value="'.$soap_controladores_result->DameControladoresResult->Controlador->IdControlador.'">'.$soap_controladores_result->DameControladoresResult->Controlador->Nombre.'</option>';
									  }else{
									  	for ($x = 0; $x < count((array)$soap_controladores_result->DameControladoresResult->Controlador); $x++){
									  		if($objeto_damePuerta->IdControlador == $soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta[$x]->IdControlador){
									  			$escontrolador = ' selected="selected"';
									  		}else{
									  			$escontrolador = '';
									  		}
									  		echo '<option value="'.$soap_controladores_result->DameControladoresResult->Controlador[$x]->IdControlador.'"'.$escontrolador.'>'.$soap_controladores_result->DameControladoresResult->Controlador[$x]->Nombre.'</option>';
									  	}
									  }
	                	?>
                  </select>
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__posicion">
	                <label class="m-0 pb-2" for="posicion">Posición</label>
	                <select class="form-control form-control-user" id="posicion" name="posicion" required>
	                	<?php
	                		switch ($objeto_damePuerta->Posicion) {
	                			case 'L':
									        $esL = ' selected="selected"';
									        $esU = '';
									        $esD = '';
									        $esR = '';
									        break;
									      case 'U':
									        $esL = ' selected="selected"';
									        $esU = '';
									        $esD = '';
									        $esR = '';
									        break;
									      case 'D':
									        $esL = '';
									        $esU = '';
									        $esD = ' selected="selected"';
									        $esR = '';
									        break;
									      case 'R':
									        $esL = '';
									        $esU = '';
									        $esD = '';
									        $esR = ' selected="selected"';
									        break;
	                		}
	                	?>
                    <option value="U"<?php echo $esU;?>>Arriba</option>
                    <option value="D"<?php echo $esD;?>>Abajo</option>
                    <option value="L"<?php echo $esL;?>>Izquierda</option>
                    <option value="R"<?php echo $esR;?>>Derecha</option>
                  </select>
	            	</div>
	            </div>
          	</div>
          	<div class="row">
          		<div class="col-6">
	            	<div class="row d-flex justify-content-end" style="height: auto">
	                <button type="submit" class="btn btn-lg btn-info" id="btn_agregar">Actualizar Puerta</button>
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
