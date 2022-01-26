<?php

session_start();

require('ws2.php');


$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];
$desde = date("Y0101");
$hasta = date("Y1231");
$estado = 9;

// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DRPO = $client->DameReservasPorOperador($parametros_dameReserva);

$array_dameReservasPorOperador = $soap_result_DRPO->DameReservasPorOperadorResult->Reserva;


    if ($array_dameReservasPorOperador->IdReserva) {

        $reservasAno = 1;

    } elseif (is_array($array_dameReservasPorOperador)) {

        $reservasAno = count($array_dameReservasPorOperador);

    } else {

        $reservasAno = 0;

    }


?>