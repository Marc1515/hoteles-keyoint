<?php

session_start();

include('ws2.php');

$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];

    // --- LLAMAR WS : DameDisponiblesCupoFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=> $idLocker, 'IdOperador'=>$idOperador, 'IdReserva'=> 3);
    $soap_result_DR = $client->DameReserva($parametros_dameReserva);

    $object_dameReserva = $soap_result_DR->DameReservaResult;

/* $array_dameReserva = (array) $object_dameReserva; */


?>