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
	// --- LLAMAR WS : DameTipoPuerta 
	$soap_tipopuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdTipoPuerta'=>$_POST['id']);
	$soap_tipopuerta_result = $SoapClient_KeysConsigna->__soapCall('DameTipoPuerta', array($soap_tipopuerta));

	if($soap_tipopuerta_result->DameTipoPuertaResult->IdLocker == 0){
		die( json_encode( array( 'status' => 'no-existe') ) );
	}else{
		die( json_encode( array( 'status' => 'existe') ) );
	}
}
?>