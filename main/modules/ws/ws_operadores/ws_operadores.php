<?php

require('ws2.php');

session_start();

$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'OrdenAoN'=>'A');
$soap_result_DO = $client->DameOperadores($parametros_dameOperadores);

$operadoresArray = $soap_result_DO->DameOperadoresResult->Operador;


?>