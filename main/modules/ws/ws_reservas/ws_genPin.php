<?php

session_start();

require 'ws2.php';

$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : GenerarPin --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_generarPin = array('token'=>$token_ws, 'IdLocker' => $idLocker, 'fecha'=>$entradaFrom);
$soap_result_GP = $client->GenerarPin($parametros_generarPin);

$stringPin = $soap_result_GP->GenerarPinResult;

echo $stringPin;


?>