<?php

session_start();

require('ws2.php');

    $desde = date("Ymd");
    $hoy = time(); 
    $sieteDiasEnSegundos = 24*60*60*7;
    $sieteDias = $hoy + $sieteDiasEnSegundos;
    $sieteDias = date("Ymd", $sieteDias);
    $hasta = $sieteDias;

    
    $idOperadorForm = $_SESSION['idOperador'];
    $idOperador = intval($idOperadorForm);

    $idLocker = $_SESSION['idLocker'];
    $estado = 9;




// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);

var_dump($parametros_dameReserva);

$soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);


$reservasArray = $soap_result_DR->DameReservasPorOperadorResult->Reserva;


?>