<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameEntradasEntreFechas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameEntradasEntreFechas = array('token'=>$token_ws, 'idlocker' => $idLocker, 'idoperador'=>$idOperador, 'desde'=> '20210101', 'hasta'=>'20211231', 'estado'=>9);
$soap_result_DEEF = $client->DameEntradasEntreFechas($parametros_dameEntradasEntreFechas);

$array_dameEntradasEntreFechas = $soap_result_DEEF->DameEntradasEntreFechasResult->Reserva;


?>