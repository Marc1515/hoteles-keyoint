<?php
session_start();

include_once('../../ws_include/ws_Keys_consigna.php');
include_once('../../ws_include/ws_consigna.php');


// LLEGO DIRECTO?
if(empty($_SESSION['NombreLocker']) || empty($_SESSION['IdLocker'])){
	// --- OBTIENE IDLOCKER ------------------------------------------------------------------------------------------------------------------------------------->
	$pagweb = $_SERVER['SERVER_NAME'];
	$dominio = explode(".", $pagweb);
	$subdominio = $dominio[0];
	$soap_idlocker = array('token'=>$token_ws, 'PrefijoWeb'=>$subdominio);

	$soap_idlocker_result = $SoapClient_Consigna->__soapCall('DameLockerPorPrefijoWeb', array($soap_idlocker));
	$_SESSION['IdLocker'] = $soap_idlocker_result->DameLockerPorPrefijoWebResult->IdLocker;
	$_SESSION['NombreLocker'] = $soap_idlocker_result->DameLockerPorPrefijoWebResult->Nombre;

	
}

// --- COMPRUEBA NOMBRE DE USUARIO Y CONTRASEÑA -------------------------------------------------------------------------------------------------------------------------------------------------->
$error = '';

if (isset($_POST['login'])) {
	$login_user = $_POST['usuario'];
	$login_pass = $_POST['password'];
	
	if ($login_user == 'keypoint'){
		$_SESSION['id_operador'] = 0;
	}else{
		$_SESSION['id_operador'] = 111;
	}
	$soap_dameusuarios = array('token'=>$token_ws, 'nombreUsuario'=>$login_user, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$_SESSION['id_operador']);
	$soap_dameusuarios_result = $SoapClient_KeysConsigna->__soapCall('DameUsuarioPorNombre', array($soap_dameusuarios));

	$objeto_dameUsuarios = $soap_dameusuarios_result->DameUsuariosResult->Usuario;

	# Comprueba acceso al sistema
	if (count((array)$soap_dameusuarios_result) == 1){
		// COMPROVAMOS EL USUARIO
		if ($soap_dameusuarios_result->DameUsuarioPorNombreResult->NombreUsuario == $login_user && $soap_dameusuarios_result->DameUsuarioPorNombreResult->Pwd == $login_pass && $soap_dameusuarios_result->DameUsuarioPorNombreResult->IdRol != 5) {
			$_SESSION['rol_user'] = $soap_dameusuarios_result->DameUsuarioPorNombreResult->IdRol;
			$_SESSION['name_user'] = $soap_dameusuarios_result->DameUsuarioPorNombreResult->Nombre;
			$_SESSION['id_user'] = $soap_dameusuarios_result->DameUsuarioPorNombreResult->IdUsuario;

			$_SESSION['infApplogin_user'] = $login_user;
			setcookie("tiempoUsuario2", "Maximo tiempo de sesion para un Usuario", time() + 1200);
			header("location: pages/dashboard.php");
		}
	}else{
		for ($i = 0; $i < count((array)$soap_dameusuarios_result->DameUsuarioPorNombreResult); $i++) {
			$lista_usuarios = (array)$soap_dameusuarios_result->DameUsuarioPorNombreResult;
            $datos_usuarios = $lista_usuarios[$i];
			$ws_user = $datos_usuarios->NombreUsuario;
			$ws_pass = $datos_usuarios->Pwd;
			$ws_rol = $datos_usuarios->IdRol;
			if ($ws_user == $login_user && $ws_pass == $login_pass && $ws_rol != 5) {
				$login_ok = 'SI';
				$_SESSION['rol_user'] = $datos_usuarios->IdRol;
				$_SESSION['name_user'] = $datos_usuarios->Nombre;
				$_SESSION['id_user'] = $datos_usuarios->IdUsuario;

				$_SESSION['infApplogin_user'] = $login_user;
				setcookie("tiempoUsuario2", "Maximo tiempo de sesion para un Usuario", time() + 1200);
				header("location: pages/dashboard.php");
			}
		}
	}
	$error = 'Lo sentimos, la combinación de usuario y contraseña no coincide con las almacenadas en nuestro sistema.';
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php echo $_SESSION['NombreLocker'];?> - Login</title>
	<?php include_once('includes/scripts.php');?>
</head>

<body class="bg-gradient-primary">
	<div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="imagenes/lockers/<?php echo $_SESSION['IdLocker'];?>.png" width="350" alt="<?php echo $_SESSION['NombreLocker'];?>" /><br><br>
                                        <div style="font-size: 12px; color: #cc0000; margin-top: 10px; text-align: center;"><?php echo $error; ?></div>
                                        <br>
                                    </div>
                                    <form class="user" action="" method="post">
                                        <div class="form-group">
                                            <input type="text" name="usuario" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Usuario" required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Contraseña" autocomplete="on" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Conectar
                                        </button>
                                        <input type="hidden" name="login" value="login">
                                    </form>
                                </div>
                                	<p style="text-align: center;">&copy; <?php echo date('Y');?> KeyPoint Solutions, SL - Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include_once('includes/scripts_footer.php');?>
</body>
</html>