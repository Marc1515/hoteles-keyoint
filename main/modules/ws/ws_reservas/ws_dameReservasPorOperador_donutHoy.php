<?php

session_start();

require('ws2.php');


$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];
$desde = date("Ymd");
$hasta = date("Ymd");
$estado = 9;

// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DRPO = $client->DameReservasPorOperador($parametros_dameReserva);

$array_dameReservasPorOperador = $soap_result_DRPO->DameReservasPorOperadorResult->Reserva;


    if ($array_dameReservasPorOperador->IdReserva) {

        $reservasHoy = 1;

    } elseif (is_array($array_dameReservasPorOperador)) {

        $reservasHoy = count($array_dameReservasPorOperador);

    } else {

        $reservasHoy = 0;

    }


?>