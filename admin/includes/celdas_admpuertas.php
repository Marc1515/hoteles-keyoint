<?php
// RECIBO LA ID DEL OPERADOR Y DEVUELVO ARRAY CON LA CONFIGURACIÓN DE LAS CELDAS
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

// --- LLAMAR WS : DamePuertasSinCupo 
$soap_sincupo = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
$soap_sincupo_result = $SoapClient_KeysReserva->DamePuertasSinCupo($soap_sincupo);
	
if((array)$soap_sincupo_result->DamePuertasSinCupoResult->Puerta->IdLocker){ // SÓLO 1
	$puerta[$soap_sincupo_result->DamePuertasSinCupoResult->Puerta->IdPuerta]['Estado'] = 'Libre';
	$puerta[$soap_sincupo_result->DamePuertasSinCupoResult->Puerta->IdPuerta]['NombrePuerta'] = $soap_sincupo_result->DamePuertasSinCupoResult->Puerta->Nombre;
	$puerta[$soap_sincupo_result->DamePuertasSinCupoResult->Puerta->IdPuerta]['Nuevo'] = "";
}else{
	for ($i = 0; $i < count((array)$soap_sincupo_result->DamePuertasSinCupoResult->Puerta); $i++){
		$puerta[$soap_sincupo_result->DamePuertasSinCupoResult->Puerta[$i]->IdPuerta]['Estado'] = 'Libre';
		$puerta[$soap_sincupo_result->DamePuertasSinCupoResult->Puerta[$i]->IdPuerta]['NombrePuerta'] = $soap_sincupo_result->DamePuertasSinCupoResult->Puerta[$i]->Nombre;
		$puerta[$soap_sincupo_result->DamePuertasSinCupoResult->Puerta[$i]->IdPuerta]['Nuevo'] = "";
	}
}

// OPERADORES
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

if((array)$soap_result_DO->DameOperadoresResult->Operador->IdLocker){ // SÓLO 1
	$soap_cupoopera = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$soap_result_DO->DameOperadoresResult->Operador->IdOperador);
	$soap_cupoopera_result = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($soap_cupoopera);

	if((array)$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta){ // SÓLO 1
		$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['Estado'] = 'Ocupada';
		$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['IdOperador'] = $soap_result_DO->DameOperadoresResult->Operador->IdOperador;
		$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['NombrePuerta'] = $soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->Nombre;
		$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['NombreOperador'] = $soap_result_DO->DameOperadoresResult->Operador->Nombre;
		$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['Nuevo'] = "";

	}else{
		for ($i = 0; $i < count((array)$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta); $i++){
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$i]->IdPuerta]['Estado'] = 'Ocupada';
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$i]->IdPuerta]['IdOperador'] = $soap_result_DO->DameOperadoresResult->Operador->IdOperador;
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$i]->IdPuerta]['NombrePuerta'] = $soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$i]->Nombre;
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$i]->IdPuerta]['NombreOperador'] = $soap_result_DO->DameOperadoresResult->Operador->Nombre;
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$i]->IdPuerta]['Nuevo'] = "";
		}
	}
}else{
	for ($i = 0; $i < count((array)$soap_result_DO->DameOperadoresResult->Operador); $i++){
		$soap_cupoopera = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$soap_result_DO->DameOperadoresResult->Operador[$i]->IdOperador);
		$soap_cupoopera_result = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($soap_cupoopera);

		if((array)$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta){ // SÓLO 1
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['Estado'] = 'Ocupada';
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['IdOperador'] = $soap_result_DO->DameOperadoresResult->Operador[$i]->IdOperador;
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['NombrePuerta'] = $soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->Nombre;
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['NombreOperador'] = $soap_result_DO->DameOperadoresResult->Operador[$i]->Nombre;
			$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta]['Nuevo'] = "";
		}else{
			for ($z = 0; $z < count((array)$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta); $z++){
				$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$z]->IdPuerta]['Estado'] = 'Ocupada';
				$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$z]->IdPuerta]['IdOperador'] = $soap_result_DO->DameOperadoresResult->Operador[$i]->IdOperador;
				$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$z]->IdPuerta]['NombrePuerta'] = $soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$z]->Nombre;
				$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$z]->IdPuerta]['NombreOperador'] = $soap_result_DO->DameOperadoresResult->Operador[$i]->Nombre;
				$puerta[$soap_cupoopera_result->DamePuertasCupoPorOperadorResult->Puerta[$z]->IdPuerta]['Nuevo'] = "";
			}
		}
	}
}
ksort($puerta);
die( json_encode( array( 'status' => $puerta) ) );
?>