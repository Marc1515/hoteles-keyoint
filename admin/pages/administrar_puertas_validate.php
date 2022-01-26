<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

include_once('../../../ws_include/ws_Keys_reserva.php');

// OBTENGO LAS PUERTAS DEL OPERADOR
// --- LLAMAR WS : DamePuertasCupoPorOperador 
$soap_cupos = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$_POST['select_operadores']);
$soap_cupos_result = $SoapClient_KeysReserva->__soapCall('DamePuertasCupoPorOperador', array($soap_cupos));

// ELIMINAMOS TODAS LAS PUERTAS
if((array)$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta->IdLocker){ // SÓLO 1
	// --- LLAMAR WS : BorrarPuertaCupo 
	$soap_supr_puerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$_POST['select_operadores'], 'IdPuerta'=>$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta);
	echo print_r($soap_supr_puerta);
	$soap_supr_puerta_result = $SoapClient_KeysReserva->__soapCall('BorrarPuertaCupo', array($soap_supr_puerta));
}else{
	for ($i = 0; $i < count((array)$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta); $i++){
		$lista_puertas = (array)$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta;
		$datos_puertas = $lista_puertas[$i];

		// --- LLAMAR WS : BorrarPuertaCupo 
		$soap_supr_puerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$_POST['select_operadores'], 'IdPuerta'=>$datos_puertas->IdPuerta);
		echo print_r($soap_supr_puerta);
		$soap_supr_puerta_result = $SoapClient_KeysReserva->__soapCall('BorrarPuertaCupo', array($soap_supr_puerta));
	}
}

// INSERTAMOS LAS QUE NOS LLEGAN
for ($i = 0; $i < count($_POST['puertas_cupo']); $i++){
	// --- LLAMAR WS : InsertarPuertaCupo 
	$soap_ins_puerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$_POST['select_operadores'], 'IdPuerta'=>$_POST['puertas_cupo'][$i]);
	echo print_r($soap_ins_puerta);
	$soap_ins_puerta_result = $SoapClient_KeysReserva->__soapCall('InsertarPuertaCupo', array($soap_ins_puerta));

	if($soap_ins_puerta_result->InsertarPuertaCupoResult == False){
		header("location:administrar-puertas.php?error=1");
	}
}
header("location:administrar-puertas.php");
?>