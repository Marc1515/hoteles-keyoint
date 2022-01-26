<?php

session_start();

require './../ws/ws_reservas/ws2.php';

$txt_resultado = '';

$desdeForm = $_POST['desde'];
$desde = date("Ymd", strtotime($desdeForm));

$hastaForm = $_POST['hasta'];
$hasta = date("Ymd", strtotime($hastaForm));

$estado = $_POST['estado'];

$idOperador = $_SESSION['idOperador'];

$idLocker = $_SESSION['idLocker'];


    // --- LLAMAR WS : DameReservaPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameReservaPorOperador = array('token'=>$token_ws, 'idlocker'=>$idLocker = 11051, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
    $soap_result_DRPO = $client->DameReservasPorOperador($parametros_dameReservaPorOperador);

    $reservasArray = (array)$soap_result_DRPO->DameReservasPorOperadorResult->Reserva;


    $resultado = "
    
    
    
    ";
    














?>