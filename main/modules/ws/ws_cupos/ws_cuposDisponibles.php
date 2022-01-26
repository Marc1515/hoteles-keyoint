<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameDisponiblesCupoFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameDisponiblesCupoFecha = array('token'=>$token_ws, 'idlocker' => $idLocker, 'IdOperador'=>$idOperador, 'fecha'=> '20210630');
$soap_result_DDCF = $client->DameDisponiblesCupoFecha($parametros_dameDisponiblesCupoFecha);

$array_dameDisponiblesCupoFecha = $soap_result_DDCF->DameDisponiblesCupoFechaResult->Puerta;


?>