<?php

session_start();

include('ws2_consigna.php');

$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DamePuertas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_damePuertas = array('token'=>$token_ws, 'idLocker'=>$idLocker, 'OrdenAoN'=>'N');
$soap_result_DP = $client->DamePuertas($parametros_damePuertas);

$array_damePuertas = $soap_result_DP->DamePuertasResult->Puerta;

?>