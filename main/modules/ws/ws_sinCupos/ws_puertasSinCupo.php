<?php

session_start();

include('ws2.php');

$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DamePuertasSinCupo --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_damePuertasSinCupo = array('token'=>$token_ws, 'IdLocker'=>$idLocker);
$soap_result_DPSC = $client->DamePuertasSinCupo($parametros_damePuertasSinCupo);

$array_damePuertasSinCupo = $soap_result_DPSC;


?>