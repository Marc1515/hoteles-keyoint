<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

include_once('../../../ws_include/ws_Keys_consigna.php');
if($_POST['lock'] == 0 || $_POST['lock'] == "null"){
	die( json_encode( array( 'status' => 'locker') ) );
}

if($_POST['id'] == 0){
	die( json_encode( array( 'status' => 'existe') ) );
}else{
	// --- LLAMAR WS : DameControlador 
	$soap_controla = array('token'=>$token_ws, 'IdLocker'=>$_POST['lock'], 'IdControlador'=>$_POST['id']);
	$soap_controla_result = $SoapClient_KeysConsigna->__soapCall('DameControlador', array($soap_controla));

	if($soap_controla_result->DameControladorResult->IdLocker == 0 && $soap_controla_result->DameControladorResult->IdControlador == 0){
		die( json_encode( array( 'status' => 'no-existe') ) );
	}else{
		die( json_encode( array( 'status' => 'existe') ) );
	}
}
?>