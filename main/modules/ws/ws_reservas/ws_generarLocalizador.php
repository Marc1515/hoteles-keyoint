<?php

// ESTABLECER URL WEB SERVICES Y TOKEN
include('ws2.php');

session_start();

$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];


// --- LLAMAR WS : GenerarLocalizador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_generarLocalizador = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador);
$soap_result_GL = $client->GenerarLocalizador($parametros_generarLocalizador);

$objeto_generarLocalizador = $soap_result_GL->GenerarLocalizadorResult;


?>