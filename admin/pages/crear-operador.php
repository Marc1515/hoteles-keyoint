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
</head>
<body id="page-top">
    <?php include_once './../../../ws_include/ws_dameOperador.php';?>
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
	              		<h1 class="h3 mb-0 text-gray-800">Crear Operador</h1>
	              		<a href="operadores.php" class="btn btn-danger btn-icon-split">
	              			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                        </a>
	            	</div>

	            	<form action="crear_operador_validate.php" method="POST" id="formularioOperator">
                        <div class="row">
                        	<div class="col-4">
                                <!-- <div hidden class="form-group" id="grupo__IdOperador">
                                    <label class="m-0 pb-2" for="IdOperador">Operador</label>
                                    <input type="text" class="form-control form-control-user" value="<?php /* echo $objeto_dameOperador->IdOperador */ ?>" name="IdOperador" id="IdOperador" required data-validation-required-message="No puede dejar este campo en blanco">
                                </div> -->
								<div class="form-group" id="grupo__nombre">
                                    <label class="m-0 pb-2" for="nombre">Nombre</label>
                                    <input type="text" class="form-control form-control-user" name="nombre" id="nombre" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__nombre" class="error__p">No puede contener números ni carácteres especiales</p>
                                </div>
								<div class="form-group" id="grupo__direccion">
                                    <label class="m-0 pb-2" for="direccion">Dirección</label>
                                    <input type="text" class="form-control form-control-user" name="direccion" id="direccion" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__nombre" class="error__p">No puede contener números ni carácteres especiales</p>
                                </div>
                                <div class="form-group" id="grupo__cp">
                                    <label class="m-0 pb-2" for="cp">Código Postal</label>
                                    <input type="text" class="form-control form-control-user" name="cp" id="cp" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__nombre" class="error__p">No puede contener números ni carácteres especiales</p>
                                </div>
                                <div class="form-group" id="grupo__poblacion">
                                    <label class="m-0 pb-2" for="poblacion">Población</label>
                                    <input type="text" class="form-control form-control-user" name="poblacion" id="poblacion" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__nombre" class="error__p">No puede contener números ni carácteres especiales</p>
                                </div>
                            </div>
                            <div class="col-4">
                            	<div class="form-group" id="grupo__provincia">
                                    <label class="m-0 pb-2" for="provincia">Provincia</label>
                                    <input type="text" class="form-control form-control-user" name="provincia" id="provincia" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__nombre" class="error__p">No puede contener números ni carácteres especiales</p>
                                </div>
                                <div class="form-group" id="grupo__telefono">
                                    <label class="m-0 pb-2" for="telefono">Teléfono</label>
                                    <input type="text" class="form-control form-control-user" name="telefono" id="telefono" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__phone" class="error__p">Solo entre 7 y 14 dígitos</p>
                                </div>
                                <div class="form-group" id="grupo__phone">
                                    <label class="m-0 pb-2" for="phone">Movil</label>
                                    <input type="text" class="form-control form-control-user" name="phone" id="phone" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__phone" class="error__p">Solo entre 7 y 14 dígitos</p>
                                </div>
                                <div class="form-group" id="grupo__email">
                                    <label class="m-0 pb-2" for="email">Email</label>
                                    <input type="text" class="form-control form-control-user" name="email" id="email" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__email" class="error__p">El correo electrónico no es correcto</p>
                                </div>
                            </div>
                            <div class="col-8">
                            	<div class="row d-flex justify-content-end" style="height: auto">
                                	<input type="hidden" name="idOperador" value="<?php echo $objeto_dameOperador->IdOperador ?>">
                                    <button type="submit" class="btn btn-lg btn-info">Crear Operador</button>
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
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            hiddenInput: "full_phone",
            utilsScript: "http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/node_modules/intl-tel-input/utils.js?21",
            initialCountry: "es",
            preferredCountries: ["es"],
        });
    </script>
</body>
</html>