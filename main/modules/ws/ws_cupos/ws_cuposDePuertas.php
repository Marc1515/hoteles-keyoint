<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DamePuertasCupo --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_damePuertasCupo = array('token'=>$token_ws, 'IdLocker' => $idLocker, 'IdOperador'=>$idOperador);
$soap_result_DPC = $client->DamePuertasCupo($parametros_damePuertasCupo);

$array_damePuertasCupo = $soap_result_DPC->DamePuertasCupoResult->Puerta;


?>