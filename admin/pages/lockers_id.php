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
	// --- LLAMAR WS : DameLocker 
	$soap_lockers = array('token'=>$token_ws, 'IdLocker'=>$_POST['id']);
	$soap_lockers_result = $SoapClient_KeysConsigna->__soapCall('DameLocker', array($soap_lockers));

	if($soap_lockers_result->DameLockerResult->IdLocker == 0 && $soap_lockers_result->DameLockerResult->Estado == 0){
		die( json_encode( array( 'status' => 'no-existe') ) );
	}else{
		die( json_encode( array( 'status' => 'existe') ) );
	}
}
?>