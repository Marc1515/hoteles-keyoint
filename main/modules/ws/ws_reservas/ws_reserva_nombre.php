<?php

session_start();

include('ws2.php');

$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];


// --- LLAMAR WS : DameReservaPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=> $idLocker, 'idoperador'=> $idOperador,  'desde'=>'20210101', 'hasta'=>'20211231', 'estado'=>9);
$soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);

$reservasArray = $soap_result_DR->DameReservasPorOperadorResult->Reserva;

// --- LLAMAR WS : DameReservasPorNombre --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReservaPorNombre = array('token'=>$token_ws, 'IdLocker'=> $idLocker, 'IdOperador'=> $idOperador, 'filtroNombre'=>'ANTONIO MORAGREGA ESCARTIN', 'estado'=>9);
$soap_result_DRPN = $client->DameReservasPorNombre($parametros_dameReservaPorNombre);

$object_dameReservaPorNombre = $soap_result_DRPN->DameReservasPorNombreResult;


?>