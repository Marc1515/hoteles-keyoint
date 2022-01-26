<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

include_once('../../../ws_include/ws_Keys_consigna.php');

if($_POST['id'] == 0){
	die( json_encode( array( 'status' => 'existe') ) );
}else{
	// --- LLAMAR WS : DamePuerta 
	$soap_puerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdPuerta'=>$_POST['id']);
	$soap_puerta_result = $SoapClient_KeysConsigna->__soapCall('DamePuerta', array($soap_puerta));

	if($soap_puerta_result->DamePuertaResult->IdLocker == 0){
		die( json_encode( array( 'status' => 'no-existe') ) );
	}else{
		die( json_encode( array( 'status' => 'existe') ) );
	}
}
?>