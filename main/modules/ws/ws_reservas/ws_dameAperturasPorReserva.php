<?php

require('./../ws/ws_reservas/ws2.php');

session_start();


$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];



if(isset($_POST) && $_SESSION['idOperador']) {

    $idReserva = $_POST['idReserva'];

    $idOperador = $_POST['idOperador'];

} elseif (isset($_POST) && !$_SESSION['idOperador']) {

    $idReserva = $_POST['idReserva'];

    $idOperador = $_SESSION['idOperador'];

}


// --- LLAMAR WS : DameAperturasPorReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameAperturasPorReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdReserva'=>$idReserva);
$soap_result_DAPR = $client->DameAperturasPorReserva($parametros_dameAperturasPorReserva);

$array_dameAperturasPorReserva = $soap_result_DAPR->DameAperturasPorReservaResult->Apertura;


?>