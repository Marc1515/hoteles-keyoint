<?php

session_start();

require('ws2.php');


$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];
$desde = date("Ym01");
$hasta = date("Ymt");
$estado = 9;

// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DRPO = $client->DameReservasPorOperador($parametros_dameReserva);

$array_dameReservasPorOperador = $soap_result_DRPO->DameReservasPorOperadorResult->Reserva;

$dia01 = 0;
$dia02 = 0;
$dia03 = 0;
$dia04 = 0;
$dia05 = 0;
$dia06 = 0;
$dia07 = 0;
$dia08 = 0;
$dia09 = 0;
$dia10 = 0;
$dia11 = 0;
$dia12 = 0;
$dia13 = 0;
$dia14 = 0;
$dia15 = 0;
$dia16 = 0;
$dia17 = 0;
$dia18 = 0;
$dia19 = 0;
$dia20 = 0;
$dia21 = 0;
$dia22 = 0;
$dia23 = 0;
$dia24 = 0;
$dia25 = 0;
$dia26 = 0;
$dia27 = 0;
$dia28 = 0;
$dia29 = 0;
$dia30 = 0;
$dia31 = 0;



if (is_array($array_dameReservasPorOperador)) {

    for ($step=0; $step<count($array_dameReservasPorOperador); $step++) {

        
        if ($array_dameReservasPorOperador[$step]->Entrada === date('Ym01')) {

            $dia01 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym02')) {

            $dia02 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym03')) {

            $dia03 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym04')) {

            $dia04 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym05')) {

            $dia05 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym06')) {

            $dia06 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym07')) {

            $dia07 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym08')) {

            $dia08 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym09')) {

            $dia09 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym10')) {

            $dia10 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym11')) {

            $dia11 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym12')) {

            $dia12 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym13')) {

            $dia13 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym14')) {

            $dia14 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym15')) {

            $dia15 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym16')) {

            $dia16 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym17')) {

            $dia17 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym18')) {

            $dia18 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym19')) {

            $dia19 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym20')) {

            $dia20 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym21')) {

            $dia21 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym22')) {

            $dia22 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym23')) {

            $dia23 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym24')) {

            $dia24 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym25')) {

            $dia25 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym26')) {

            $dia26 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym27')) {

            $dia27 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym28')) {

            $dia28 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym29')) {

            $dia29 ++;

        } elseif ($array_dameReservasPorOperador[$step]->Entrada === date('Ym30')) {

            $dia30 ++;

        } else {

            $dia31 ++;

        }

    }

}


    if ($array_dameReservasPorOperador->IdReserva) {

        $reservasMes = 1;

    } elseif (is_array($array_dameReservasPorOperador)) {

        $reservasMes = count($array_dameReservasPorOperador);

    } else {

        $reservasMes = 0;

    }


?>