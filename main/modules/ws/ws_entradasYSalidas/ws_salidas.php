<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameSalidasEntreFechas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameSalidasEntreFechas = array('token'=>$token_ws, 'idlocker' => $idLocker, 'idoperador'=>$idOperador, 'desde'=> '20210101', 'hasta'=>'20211231', 'estado'=>9);
$soap_result_DSEF = $client->DameSalidasEntreFechas($parametros_dameSalidasEntreFechas);

$array_dameSalidasEntreFechas = $soap_result_DSEF->DameSalidasEntreFechasResult->Reserva;


?>