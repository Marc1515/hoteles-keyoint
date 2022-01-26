<?php

session_start();

require('ws2.php');


$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];
$desde = date("Y0101");
$hasta = date("Y1231");
$estado = 1;

// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DRPO = $client->DameReservasPorOperador($parametros_dameReserva);

$array_dameReservasPorOperador = $soap_result_DRPO->DameReservasPorOperadorResult->Reserva;


    if ($array_dameReservasPorOperador->IdReserva) {

        $reservasAnoAnuladas = 1;

    } elseif (is_array($array_dameReservasPorOperador)) {

        $reservasAnoAnuladas = count($array_dameReservasPorOperador);

    } else {

        $reservasAnoAnuladas = 0;

    }


?>