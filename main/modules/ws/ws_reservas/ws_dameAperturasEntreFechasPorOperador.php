<?php

session_start();

require('./../ws/ws_reservas/ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];


if(isset($_POST['idOperador']) && isset($_POST['desde_trazabilidad']) && isset($_POST['hasta_trazabilidad']) && $_SESSION['idOperador']==0) {

    $desdeForm = $_SESSION['desde_trazabilidad'];
    $desde = date("Ymd", strtotime($desdeForm));

    $hastaForm = $_SESSION['hasta_trazabilidad'];
    $hasta = date("Ymd", strtotime($hastaForm));

    $idReserva = $_POST['idReserva'];

    $idOperador = $_POST['idOperador'];

} elseif (isset($_POST['idOperador']) && isset($_POST['desde_trazabilidad']) && isset($_POST['hasta_trazabilidad']) && !$_SESSION['idOperador']==0) {

    $desdeForm = $_SESSION['desde_trazabilidad'];
    $desde = date("Ymd", strtotime($desdeForm));

    $hastaForm = $_SESSION['hasta_trazabilidad'];
    $hasta = date("Ymd", strtotime($hastaForm));

    $idReserva = $_POST['idReserva'];

    $idOperador = $_SESSION['idOperador'];

} else {

    $desdeForm = $_SESSION['desde_trazabilidad'];
    $desde = date("Ymd", strtotime($desdeForm));

    $hastaForm = $_SESSION['hasta_trazabilidad'];
    $hasta = date("Ymd", strtotime($hastaForm));

    $idOperador = $_SESSION['idOperador'];

}


// --- LLAMAR WS : DameAperturasEntreFechasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameAperturasEntreFechasPorOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
$soap_result_DAEFPO = $client->DameAperturasEntreFechasPorOperador($parametros_dameAperturasEntreFechasPorOperador);


$array_DameAperturasEntreFechasPorOperador = $soap_result_DAEFPO->DameAperturasEntreFechasPorOperadorResult->Apertura;


?>