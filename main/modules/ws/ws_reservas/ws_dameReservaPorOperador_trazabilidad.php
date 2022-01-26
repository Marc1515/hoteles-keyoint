<?php

session_start();

require('ws2.php');


    $idOperadorForm = $_SESSION['idOperador'];
    $idOperador = intval($idOperadorForm);

    $idLocker = $_SESSION['idLocker'];
    

if(isset($_POST) && $_SESSION['idOperador']==0) {

    $idReserva = $_POST['idReserva'];

    $idOperador = $_POST['idOperador'];

} elseif (isset($_POST) && !$_SESSION['idOperador']==0) {

    $idReserva = $_POST['idReserva'];

    $idOperador = $_SESSION['idOperador'];

}


$desde = '20210101';
$hasta = '20211231';
$estado = 9;


// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);


$reservasArray = $soap_result_DR->DameReservasPorOperadorResult->Reserva;


?>