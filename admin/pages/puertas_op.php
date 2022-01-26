<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

include_once('../../../ws_include/ws_Keys_consigna.php');
include_once('../../../ws_include/ws_Keys_reserva.php');

if($_POST['id'] == 0){
	die( json_encode( array( 'status' => 'no-existe') ) );
}else{
	// --- LLAMAR WS : DamePuertasSinCupo 
	$soap_puertaslibres = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
	$soap_puertaslibres_result = $SoapClient_KeysReserva->__soapCall('DamePuertasSinCupo', array($soap_puertaslibres));
	if((array)$soap_puertaslibres_result->DamePuertasSinCupoResult->Puerta->IdLocker){ // SÓLO 1
		$puertas_op['Libres'][0]['Nombre'] = $soap_puertaslibres_result->DamePuertasSinCupoResult->Puerta->Nombre;
		$puertas_op['Libres'][0]['id'] = $soap_puertaslibres_result->DamePuertasSinCupoResult->Puerta->IdPuerta;
	}else{
		for ($i = 0; $i < count((array)$soap_puertaslibres_result->DamePuertasSinCupoResult->Puerta); $i++){
			$lista_libres = (array)$soap_puertaslibres_result->DamePuertasSinCupoResult->Puerta;
			$datos_libres = $lista_libres[$i];
			$puertas_op['Libres'][$i]['Nombre'] = $datos_libres->Nombre;
			$puertas_op['Libres'][$i]['id'] = $datos_libres->IdPuerta;
		}
	}

	// --- LLAMAR WS : DamePuertasCupoPorOperador 
	$soap_cupos = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$_POST['id']);
	$soap_cupos_result = $SoapClient_KeysReserva->__soapCall('DamePuertasCupoPorOperador', array($soap_cupos));

	if((array)$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta->IdLocker){ // SÓLO 1
		$puertas_op['Ocupadas'][0]['Nombre'] = $soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta->Nombre;
		$puertas_op['Ocupadas'][0]['id'] = $soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta;
	}else{
		for ($i = 0; $i < count((array)$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta); $i++){
			$lista_puertas = (array)$soap_cupos_result->DamePuertasCupoPorOperadorResult->Puerta;
			$datos_puertas = $lista_puertas[$i];

			$puertas_op['Ocupadas'][$i]['Nombre'] = $datos_puertas->Nombre;
			$puertas_op['Ocupadas'][$i]['id'] = $datos_puertas->IdPuerta;
		}
	}
	
	die( json_encode( array( 'status' => $puertas_op) ) );
}
?>