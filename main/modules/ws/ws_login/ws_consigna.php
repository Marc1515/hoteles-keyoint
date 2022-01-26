<?php

session_start();

// ESTABLECER URL WEB SERVICES Y TOKEN
include('ws_consigna2.php');

// --- LLAMAR WS : DameUsuarioPorNombre --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperator, 'nombreUsuario'=>$login_user);
$soap_result_DUPN = $client->DameUsuarioPorNombre($parametros);


$user = $soap_result_DUPN->DameUsuarioPorNombreResult->NombreUsuario;
$pwd = $soap_result_DUPN->DameUsuarioPorNombreResult->Pwd;
$oper = $soap_result_DUPN->DameUsuarioPorNombreResult->IdOperador;
$rol = $soap_result_DUPN->DameUsuarioPorNombreResult->IdRol;

// --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'OrdenAoN'=>'A');
$soap_result_DO = $client->DameOperadores($parametros_dameOperadores);

$operatorArray = $soap_result_DO->DameOperadoresResult->Operador;


/* for($let = 0; $let < count($operatorArray); $let++) {



} */

?>