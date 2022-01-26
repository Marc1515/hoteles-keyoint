<?php

session_start();

require('ws2_consigna.php');

$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameLocker --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameLocker = array('token'=>$token_ws, 'IdLocker'=> $idLocker);
$soap_result_DL = $client->DameLocker($parametros_dameLocker);

$objeto_dameLocker = $soap_result_DL->DameLockerResult;


?>