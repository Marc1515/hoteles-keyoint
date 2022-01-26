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
        		<h1 class="h3 mb-0 text-gray-800">Crear Controlador</h1>
        		<a href="controladores.php" class="btn btn-danger btn-icon-split">
        			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                </a>
        	</div>

        	<form action="crear_controlador_validate.php" method="POST" id="formularioControla">
          	<div class="row">
	           	<div class="col-3">
								<div class="form-group" id="grupo__id">
                  <label class="m-0 pb-2" for="id_controla">Id.</label>
                  <input type="text" class="form-control form-control-user" name="id_controla" id="id_controla" onkeyup="existe_id();" required data-validation-required-message="No puede dejar este campo en blanco">
                  <p id="error__p__id" class="error__p">Ésta Id ya existe en otro controlador. Seleccione otra.</p>
                  <p id="error__p__lockid" class="error__p">Seleccione un Locker para poder comprobar la Id.</p>
              	</div>
            	</div>
            </div>
            <div class="row">
              <div class="col-6">
								<div class="form-group" id="grupo__nombre">
                  <label class="m-0 pb-2" for="nombre">Nombre</label>
                  <input type="text" class="form-control form-control-user" name="nombre" id="nombre" required data-validation-required-message="No puede dejar este campo en blanco">
              	</div>
          		</div>
          	</div>
          	<div class="row">
          		<div class="col-2">
	          		<div class="form-group" id="grupo__ip">
	                <label class="m-0 pb-2" for="ip">IP</label>
	                <input type="text" class="form-control form-control-user" name="ip" id="ip" required data-validation-required-message="No puede dejar este campo en blanco">
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__ip">
	                <label class="m-0 pb-2" for="puerto">Puerto</label>
	                <input type="text" class="form-control form-control-user" name="puerto" id="puerto" required data-validation-required-message="No puede dejar este campo en blanco">
	            	</div>
	            </div>
	            <div class="col-2">
	          		<div class="form-group" id="grupo__pserie">
	                <label class="m-0 pb-2" for="pserie">Puerto Serie</label>
	                <select class="form-control form-control-user" id="pserie" name="pserie" required>
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                  </select>
	            	</div>
	            </div>
          	</div>
          	<div class="row">
          		<div class="col-6">
	            	<div class="row d-flex justify-content-end" style="height: auto">
	                <button type="submit" class="btn btn-lg btn-info" id="btn_agregar">Crear Controlador</button>
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
	    var id = $('#id_controla').val();
	    var idlock = $('#locker').val();
	    var dataString = 'id=' + id + '&lock=' + idlock;
	    jQuery.ajax({
	      data: dataString,
	      type: 'POST',
	      dataType: 'json',
	      url: 'controladores_id.php',
	      success: function( payload ){
	      	if( payload.status == 'locker' ){
	      		$('#locker').focus();
	      		$('#error__p__lockid').css('display','block');
	          $('#btn_agregar').prop('disabled', false);
	      	}
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
