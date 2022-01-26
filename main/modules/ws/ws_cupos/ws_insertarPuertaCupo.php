<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : InsertarPuertaCupo --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_insertarPuertaCupo = array('token'=>$token_ws, 'IdLocker' => $idLocker, 'IdOperador'=>$idOperador, 'IdPuerta'=>$numPuertaEntero);
$soap_result_IPC = $client->InsertarPuertaCupo($parametros_insertarPuertaCupo);




?>