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
	              		<h1 name="crearOActualizar" class="h3 mb-0 text-gray-800">Crear Usuario</h1>
	              		<a href="usuarios.php" class="btn btn-danger btn-icon-split">
	              			<span class="icon text-white-50"><i class="fas fa-times"></i></span><span class="text">Cancelar</span>
                        </a>
	            	</div>

	            	<form action="crear_user_validate.php" method="POST" id="formularioUser" class="form-material m-t-40">
                        <div class="row">
                            <div class="col-4">
							<input hidden class="form-control form-control-line" name="crearOActualizar" type="text" value="crear" readonly>
                            	<div class="form-group" id="grupo__operador">
                                    <label class="m-0 pb-2" for="Operador">Operador</label>
                                    <select class="custom-select col-12" id="idop" name="idop" required="">
		                            	<?php
		                            	// OPERADORES
		                            	$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
				    					$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

				    					if((array)$soap_result_DO->DameOperadoresResult->Operador->IdLocker){ // SÓLO 1
				    						if($soap_result_DO->DameOperadoresResult->Operador->IdOperador == 0){
				    							if($_SESSION['id_operador'] == 0 && $_SESSION['id_user'] == 0){
				    								echo '<option value="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'">'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'</option>';
				    							}
				    						}else{
				    							echo '<option value="'.$soap_result_DO->DameOperadoresResult->Operador->IdOperador.'">'.$soap_result_DO->DameOperadoresResult->Operador->Nombre.'</option>';
				    						}
										}else{
											for ($i = 0; $i < count((array)$soap_result_DO->DameOperadoresResult->Operador); $i++){
		                            			$lista_operadores = (array)$soap_result_DO->DameOperadoresResult->Operador;
		      									$datos_operadores = $lista_operadores[$i];
		      									if($datos_operadores->IdOperador == 0){
				    								if($_SESSION['id_operador'] == 0 && $_SESSION['id_user'] == 0){
				    									echo '<option value="'.$datos_operadores->IdOperador.'">'.$datos_operadores->Nombre.'</option>';
													}
												}else{
													echo '<option value="'.$datos_operadores->IdOperador.'">'.$datos_operadores->Nombre.'</option>';
												}
		      								}
										}
		                            	?>
                            		</select>
                                </div>
                                <div class="form-group" id="grupo__nombre">
                                    <label class="m-0 pb-2" for="nameUser">Nombre</label>
                                    <input type="text" class="form-control form-control-line" id="nameUser" name="nombre" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__nombre" class="error__p">El nombre no puede contener números ni carácteres especiales</p>
                                </div>

                                <div class="form-group" id="grupo__usuario">
                                    <label class="m-0 pb-2" for="nickName">Nombre de Usuario</label>
                                    <input type="text" class="form-control form-control-line" id="nickName" name="nombreUsuario" maxlength="20" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__user" class="error__p">El nombre de Usuario debe contener entre 4 y 20 letras</p>
                                </div>

                                <div class="form-group" id="grupo__pwd">
                                    <label class="m-0 pb-2" for="pwd">Contraseña</label>
                                    <input type="password" class="form-control form-control-line" name="pwd" id="pwd" required data-validation-required-message="No puede dejar este campo en blanco">  
                                    <p id="error__p__pwd" class="error__p">Se permite un mínimo de 4 y un máximo de 12 dígitos</p>
                                </div>

                                <div class="form-group" id="grupo__pwd2">
                                    <label class="m-0 pb-2" for="pwd2">Confirmacion de Contraseña</label>
                                    <input type="password" class="form-control form-control-line" name="pwd2" id="pwd2" required data-validation-required-message="No puede dejar este campo en blanco">  
                                    <p id="error__p__pwd2" class="error__p">Se permite un mínimo de 4 y un máximo de 12 dígitos</p>
                                    <p id="error__p__confirm" class="error__p">Las contraseñas no coinciden</p>
                                </div>
                            </div>
                            <div class="col-4">
                            	<div class="form-group">
                                    <label>Rol de Usuario</label>
                                    <select class="custom-select col-12" id="inlineFormCustomSelect" name="idRol" required>
		                            	<?php
		                            	// ROLES
		                            	$parametros_dameRoles = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
						    			$soap_result_RL = $SoapClient_KeysConsigna->DameRoles($parametros_dameRoles);
						    			if((array)$soap_result_RL->DameRolesResult->Rol->IdLocker){ // SÓLO 1
						    				echo '<option value="'.$soap_result_RL->DameRolesResult->Rol->IdRol.'">'.$soap_result_RL->DameRolesResult->Rol->Nombre.'</option>';
						    			}else{
						    				for ($i = 0; $i < count((array)$soap_result_RL->DameRolesResult->Rol); $i++){
		                            			$lista_roles = (array)$soap_result_RL->DameRolesResult->Rol;
		      									$datos_roles = $lista_roles[$i];
		      									echo '<option value="'.$datos_roles->IdRol.'">'.$datos_roles->Nombre.'</option>';
		      								}
						    			}
		                            	?>
                            		</select>
                                </div>
                                <div class="form-group" id="grupo__email">
                                    <label class="m-0 pb-2" for="example-email">Email</label>
                                    <input type="email" id="example-email" name="example-email" class="form-control" required data-validation-required-message="No puede dejar este campo en blanco">
                                    <p id="error__p__email" class="error__p">El correo electrónico no es correcto</p>
                                </div>
                                <div class="form-group" id="grupo__phone" style="overflow: visible !important;">
                                    <label class="m-0 pb-2" for="phone">Movil</label>
                                    <input type="tel" class="form-control form-control-line" name="full_phone" id="phone" required data-validation-required-message="No puede dejar este campo en blanco">  
                                    <p id="error__p__phone" class="error__p">Sólo entre 7 y 14 dígitos</p>
                                </div>
                                <div class="form-group">
                                    <label class="m-0 pb-2" for="pin">Pin</label>
                                    <input type="text" class="form-control form-control-line" id="pin" name="pin" required data-validation-required-message="No puede dejar este campo en blanco" maxlength="6">
                                </div>
                            </div>
                            <div class="col-8">
                            	<div class="row d-flex justify-content-end" style="height: auto">
                                    <button type="submit" class="btn btn-lg btn-info" id="crearUser">Crear Usuario</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
	        </div>
	    </div>
	</div>
	<?php include_once('../includes/scripts_footer.php');?>
	<script src="http://<?php echo $_SERVER['SERVER_NAME'];?>/keysWeb/main/modules/js/form_user.js"></script>
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