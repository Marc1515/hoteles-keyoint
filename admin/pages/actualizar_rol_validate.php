<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$idRol = $_POST['idRol'];
$nombre = $_POST['nombre'];
$url = $_POST['url'];

include_once('../../../ws_include/ws_Keys_consigna.php');

if(isset($_POST)) {
	// --- LLAMAR WS : ActualizarRol 
    $parametros_actualizarRol = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdRol'=>$idRol, 'Nombre'=>$nombre, 'Url'=>$url);
    $soap_result_AR = $SoapClient_KeysConsigna->ActualizarRol($parametros_actualizarRol);

    header("location:roles.php");
    die();
}
?>