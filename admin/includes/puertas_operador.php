<?php
// RECIBO LA ID DEL OPERADOR Y DEVUELVO ARRAY CON LAS PUERTAS QUE TIENE DE CONTRATO Y CUPO ACTUAL
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

include_once('../../../ws_include/ws_Keys_consigna.php');
include_once('../../../ws_include/ws_Keys_reserva.php');

// --- LLAMAR WS : DamePuertasCupoPorOperador 
$soap_cupo = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$_POST['id']);
$soap_cupo_result = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($soap_cupo);

$cupo = 0;
if((array)$soap_cupo_result->DamePuertasCupoPorOperadorResult->Puerta->IdLocker){ // SÓLO 1
	$cupo = 1;
}else{
	$cupo = count((array)$soap_cupo_result->DamePuertasCupoPorOperadorResult->Puerta);

}
// --- LLAMAR WS : DameContrato 
$soap_contrato = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$_POST['id']);
$soap_contrato_result = $SoapClient_KeysReserva->DameContrato($soap_contrato);
if((array)$soap_contrato_result->DameContratoResult->Cupo){ // SÓLO 1
	$contrato = $soap_contrato_result->DameContratoResult->Cupo;
}

die( json_encode( array( 'cupo' => $cupo, 'contrato' => $contrato) ) );
?>