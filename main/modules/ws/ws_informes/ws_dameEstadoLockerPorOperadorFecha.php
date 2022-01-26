<?php

require('ws2_informes.php');

session_start();

$hoy = date('Ymd');
$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];



if($_POST['idOperador']) {

    $idOperador = $_POST['idOperador'];

}

// --- LLAMAR WS : DameEstadoLockerPorOperadorFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameEstadoLockerPorOperadorFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'fecha'=>$hoy, 'idoperador'=>$idOperador);
$soap_result_DELPOF = $client->DameEstadoLockerPorOperadorFecha($parametros_dameEstadoLockerPorOperadorFecha);

$array_dameEstadoLockerPorOperadorFecha = $soap_result_DELPOF->DameEstadoLockerPorOperadorFechaResult->LineaEstado;

/* var_dump($parametros_dameEstadoLockerPorOperadorFecha); */

?>