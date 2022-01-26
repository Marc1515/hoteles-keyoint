<?php

session_start();

require('ws2.php');


$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameEjerciciosConReservas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameEjerciciosConReservas = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
$soap_result_DECR = $client->DameEjerciciosConReservas($parametros_dameEjerciciosConReservas);

$array_dameEjerciciosConReservas = $soap_result_DECR->DameEjerciciosConReservasResult->int;


?>