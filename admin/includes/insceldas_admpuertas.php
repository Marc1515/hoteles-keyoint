<?php
// RECIBO ARRAY DE LAS PUERTAS Y SI HAY O NO QUE MODIFICAR CUPO
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}
$pagweb = $_SERVER['SERVER_NAME'];
$dominio = explode(".", $pagweb);
$subdominio = $dominio[1];
if($subdominio != "keypoint"){
	header("location:http://www.keypoint.es");
	exit();	
}
include_once('../../../ws_include/ws_Keys_reserva.php');

$recibo = (array)json_decode($_POST['ArrJson']);
$cuantas_puertas = count($recibo);
$error = 0;
for($i = 0; $i < $cuantas_puertas; $i++){
	switch ($recibo[$i+1]->Nuevo){
		case 'ocupar':
			// --- LLAMAR WS : InsertarPuertaCupo 
			$soap_InsertarPuertaCupo = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>(int)$recibo[$i+1]->IdOperador, 'IdPuerta'=>$i+1);
			$soap_InsertarPuertaCupo_result = $SoapClient_KeysReserva->InsertarPuertaCupo($soap_InsertarPuertaCupo);
			if(!$soap_InsertarPuertaCupo_result->InsertarPuertaCupoResult){
				$error++;
			}
			//$resultado[$i] = $soap_InsertarPuertaCupo;
			break;
		case 'liberar':
			// --- LLAMAR WS : BorrarPuertaCupo 
			$soap_BorrarPuertaCupo = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$recibo[$i+1]->IdOperador, 'IdPuerta'=>$i+1);
			$soap_BorrarPuertaCupo_result = $SoapClient_KeysReserva->BorrarPuertaCupo($soap_BorrarPuertaCupo);
			if(!$soap_BorrarPuertaCupo_result->BorrarPuertaCupoResult){
				$error++;
			}
			//$resultado[$i] = $soap_BorrarPuertaCupo;
			break;
		case '';
		break;
	}
}
if($error > 0){
	$resultado = 'ErrorWS';
}else{
	$resultado = 'OK';
}
die( json_encode( array( 'status' => $resultado) ) );
?>