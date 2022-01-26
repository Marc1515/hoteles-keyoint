<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : BorrarPuertaCupo --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_borrarPuertaCupo = array('token'=>$token_ws, 'IdLocker'=> $idLocker, 'IdOperador'=>$idOperador, 'IdPuerta'=>$numEntero);
var_dump($parametros_borrarPuertaCupo);
die;
$soap_result_BPC = $client->BorrarPuertaCupo($parametros_borrarPuertaCupo);



?>