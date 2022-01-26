<?php

session_start();

include('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

$desde = date("Ymd");
$hoy = time(); 
$quinceDiasEnSegundos = 24*60*60*15;
$quinceDias = $hoy + $quinceDiasEnSegundos;
$quinceDias=date("Ymd", $quinceDias);
$hasta = $quinceDias;


if (isset($_POST['desde_disponiblidad'])) {

    $entrada = $_POST['desde_disponiblidad'];
    $salida = $_POST['hasta_disponiblidad'];

    $desde = date("Ymd", strtotime($entrada));
    $hasta = date("Ymd", strtotime($salida));

}

if(isset($_SESSION['desde_disponiblidad']) && isset($_SESSION['hasta_disponiblidad'])) {

    $desdeForm = $_SESSION['desde_disponiblidad'];
    $desde = date("Ymd", strtotime($desdeForm));

    $hastaForm = $_SESSION['hasta_disponiblidad'];
    $hasta = date("Ymd", strtotime($hastaForm));


}


// --- LLAMAR WS : DameOcupacionEntreFechas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOcupacionEntreFechas = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
$soap_result_DOEP = $client->DameOcupacionEntreFechas($parametros_dameOcupacionEntreFechas);


$array_dameOcupacionEntreFechas = $soap_result_DOEP->DameOcupacionEntreFechasResult->DisponibleDia;


?>