<?php

session_start();

require('ws2_informes.php');

$hoy = date('Ymd');
$idLocker = $_SESSION['idLocker'];


// --- LLAMAR WS : DameEstadoLockerPorFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameEstadoLockerPorFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'fecha'=>$hoy);
$soap_result_DELPF = $client->DameEstadoLockerPorFecha($parametros_dameEstadoLockerPorFecha);

$array_dameEstadoLockerPorFecha = $soap_result_DELPF->DameEstadoLockerPorFechaResult->LineaEstado;


?>