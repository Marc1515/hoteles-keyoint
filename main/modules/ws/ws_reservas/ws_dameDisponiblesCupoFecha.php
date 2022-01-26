<?php

require('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameDisponiblesCupoFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameDisponiblesCupoFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'IdOperador'=>$idOperador, 'fecha'=>$fechaForm);
$soap_result_DDCF = $client->DameDisponiblesCupoFecha($parametros_dameDisponiblesCupoFecha);

$disponiblesCuposFecha_array = ($soap_result_DDCF->DameDisponiblesCupoFechaResult->Puerta);


?>