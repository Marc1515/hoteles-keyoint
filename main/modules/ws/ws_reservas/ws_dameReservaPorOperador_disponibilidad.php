<?php

session_start();

require('ws2.php');

require 'ws_dameEjerciciosConReservas.php';

    $desde = date("Ymd");
    $hoy = time(); 
    $quinceDiasEnSegundos = 24*60*60*15;
    $quinceDias = $hoy + $quinceDiasEnSegundos;
    $quinceDias = date("Ymd", $quinceDias);
    $hasta = $quinceDias;

    
    $idOperadorForm = $_SESSION['idOperador'];
    $idOperador = intval($idOperadorForm);

    $idLocker = $_SESSION['idLocker'];
    $estado = 9;



if(isset($_POST['desde']) && isset($_POST['hasta']) && isset($_POST['idOperador']) && isset($_POST['estado'])) {

    $operadorForm = $_POST['idOperador'];
    $idOperador = intval($operadorForm);


    $_SESSION['desde'] = $_POST['desde'];

    $desdeForm = $_POST['desde'];
    $desde = date("Ymd", strtotime($desdeForm));


    $hastaForm = $_POST['hasta'];
    $hasta = date("Ymd", strtotime($hastaForm));

    $estadoString = $_POST['estado'];
    $estado = intval($estadoString);
    
} 


if(isset($_SESSION['desde']) && isset($_SESSION['hasta']) && isset($_SESSION['estado'])) {

    $desdeForm = $_SESSION['desde'];
    $desde = date("Ymd", strtotime($desdeForm));

    $hastaForm = $_SESSION['hasta'];
    $hasta = date("Ymd", strtotime($hastaForm));

    $estadoString = $_SESSION['estado'];
    $estado = intval($estadoString);


}


// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);


$reservasArray = $soap_result_DR->DameReservasPorOperadorResult->Reserva;


?>