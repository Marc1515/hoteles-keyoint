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
        	<div class="d-sm-flex align-items-center justify-content-between mb-4">
        		<h1 class="h3 mb-0 text-gray-800">Crear Puerta</h1>
        		<a href="puertas.php" class="btn btn-danger btn-icon-split">
        			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                </a>
        	</div>

        	<form action="crear_puerta_validate.php" method="POST" id="formularioPuerta">
          	<div class="row">
	           	<div class="col-3">
								<div class="form-group" id="grupo__id">
                  <label class="m-0 pb-2" for="id_puerta">Id.</label>
                  <input type="text" class="form-control form-control-user" name="id_puerta" id="id_puerta" onkeyup="existe_id();" required data-validation-required-message="No puede dejar este campo en blanco">
                  <p id="error__p__id" class="error__p">Ésta Id ya existe en otra puerta. Seleccione otra.</p>
              	</div>
            	</div>
	            <div class="col-3">
								<div class="form-group" id="grupo__nombre">
	                <label class="m-0 pb-2" for="nombre">Nombre</label>
	                <input type="text" class="form-control form-control-user" name="nombre" id="nombre" required data-validation-required-message="No puede dejar este campo en blanco">
	            	</div>
	        		</div>
          	</div>
          	<div class="row">
          		<div class="col-2">
	          		<div class="form-group" id="grupo__cu">
	                <label class="m-0 pb-2" for="puertocu">Puerto CU</label>
	                <input type="text" class="form-control form-control-user" name="puertocu" id="puertocu" required data-validation-required-message="No puede dejar este campo en blanco">
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__activa">
	                <label class="m-0 pb-2" for="activa">Activa</label>
	                <select class="form-control form-control-user" id="activa" name="activa" required>
                    <option value="Sí">Sí</option>
                    <option value="No">No</option>
                  </select>
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__idtipo">
	                <label class="m-0 pb-2" for="idtipo">Tipo de puerta</label>
	                <select class="form-control form-control-user" id="idtipo" name="idtipo" required>
	                	<option selected="selected" disabled="disabled">Seleccionar...</option>
	                	<?php
	                	// Tipo Puerta
									  $parametros_DameTiposPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
									  $soap_tipospuerta_result = $SoapClient_KeysConsigna->DameTiposPuerta($parametros_DameTiposPuerta);

									  if((array)$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta->IdLocker){ // SÓLO 1
									  	echo '<option value="'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta->IdTipoPuerta.'">'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta->Nombre.'</option>';
									  }else{
									  	for ($x = 0; $x < count((array)$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta); $x++){
									  		echo '<option value="'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta[$x]->IdTipoPuerta.'">'.$soap_tipospuerta_result->DameTiposPuertaResult->TipoPuerta[$x]->Nombre.'</option>';
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
                    <option selected="selected" disabled="disabled">Seleccionar...</option>
                    <?php
	                	// Controladores
									  $parametros_DameControladores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
									  $soap_controladores_result = $SoapClient_KeysConsigna->DameControladores($parametros_DameControladores);

									  if((array)$soap_controladores_result->DameControladoresResult->Controlador->IdLocker){ // SÓLO 1
									  	echo '<option value="'.$soap_controladores_result->DameControladoresResult->Controlador->IdControlador.'">'.$soap_controladores_result->DameControladoresResult->Controlador->Nombre.'</option>';
									  }else{
									  	for ($x = 0; $x < count((array)$soap_controladores_result->DameControladoresResult->Controlador); $x++){
									  		echo '<option value="'.$soap_controladores_result->DameControladoresResult->Controlador[$x]->IdControlador.'">'.$soap_controladores_result->DameControladoresResult->Controlador[$x]->Nombre.'</option>';
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
	                	<option selected="selected" disabled="disabled">Seleccionar...</option>
                    <option value="U">Arriba</option>
                    <option value="D">Abajo</option>
                    <option value="L">Izquierda</option>
                    <option value="R">Derecha</option>
                  </select>
	            	</div>
	            </div>
          	</div>
          	<div class="row">
          		<div class="col-6">
	            	<div class="row d-flex justify-content-end" style="height: auto">
	                <button type="submit" class="btn btn-lg btn-info" id="btn_agregar">Crear Puerta</button>
	              </div>
	            </div>
          	</div>
        	</form>
	      </div>
	    </div>
	  </div>
	</div>
	<?php include_once('../includes/scripts_footer.php');?>
  <script>
    // MIRAMOS SI EXISTE LA ID
	  function existe_id() {
	    var id = $('#id_puerta').val();
	    var dataString = 'id=' + id;
	    jQuery.ajax({
	      data: dataString,
	      type: 'POST',
	      dataType: 'json',
	      url: 'puertas_id.php',
	      success: function( payload ){
	        if( payload.status == 'no-existe' ){
	          $('#error__p__id').css('display','none');
	          $('#btn_agregar').prop('disabled', false);
	        };
	        if( payload.status == 'existe' ){
	          $('#error__p__id').css('display','block');
	          $('#btn_agregar').prop('disabled', true);
	        };
	      },
	      error: function(){
	        console.log('error');
	        }
	    });
	  };
	</script>
</body>
</html>
