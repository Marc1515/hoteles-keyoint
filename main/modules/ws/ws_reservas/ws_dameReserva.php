<?php

require('ws2.php');

$idReserva = $_GET['upd'];

if ($_POST['idReserva']) {

$idReserva = $_POST['idReserva'];

}


$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva);
$soap_result_DR = $client->DameReserva($parametros_dameReserva);

$objeto_dameReserva = $soap_result_DR->DameReservaResult;


$newInPutDate = $objeto_dameReserva->Entrada;

$newInPutDate = date("Y-m-d", strtotime($newInPutDate));


$newOutPutDate = $objeto_dameReserva->Salida;

$newOutPutDate = date("Y-m-d", strtotime($newOutPutDate));


?>