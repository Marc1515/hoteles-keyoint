<?php

include('ws2.php');

session_start();

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

$desde = date("Ymd");
$hoy = time(); 
$quinceDiasEnSegundos = 24*60*60*6;
$quinceDias = $hoy + $quinceDiasEnSegundos;
$quinceDias=date("Ymd", $quinceDias);
$hasta = $quinceDias;



// --- LLAMAR WS : DameOcupacionEntreFechas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOcupacionEntreFechas = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
$soap_result_DOEP = $client->DameOcupacionEntreFechas($parametros_dameOcupacionEntreFechas);


$array_dameOcupacionEntreFechas = $soap_result_DOEP->DameOcupacionEntreFechasResult->DisponibleDia;


?>