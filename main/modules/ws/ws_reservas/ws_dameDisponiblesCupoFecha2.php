<?php

session_start();

require 'ws2.php';

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];
$entrada = $_POST['fecha'];

// --- LLAMAR WS : DameDisponiblesCupoFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameDisponiblesCupoFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'IdOperador'=>$idOperador, 'fecha'=>$entrada);
$soap_result_DDCF = $client->DameDisponiblesCupoFecha($parametros_dameDisponiblesCupoFecha);

$objeto_dameDisponiblesCuposFecha = ($soap_result_DDCF->DameDisponiblesCupoFechaResult->Puerta);

if (!is_array($objeto_dameDisponiblesCuposFecha) && !is_null($objeto_dameDisponiblesCuposFecha)) {

    die(json_encode( array( 'cupo' => $objeto_dameDisponiblesCuposFecha) ) );

} elseif (is_array($objeto_dameDisponiblesCuposFecha)) {

    die(json_encode( array( 'cupo' => $objeto_dameDisponiblesCuposFecha) ) );

} else {

    die(json_encode( array( 'cupo' => $objeto_dameDisponiblesCuposFecha) ) );

}


?>