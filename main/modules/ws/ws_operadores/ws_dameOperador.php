<?php

require('ws2.php');

session_start();

$idOperador = $_GET['upd'];
$idLocker = $_SESSION['idLocker'];


if (isset($_SESSION['idOperador'])) {

    $idOperator = $_SESSION['idOperador'];

}

// --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
$soap_result_DO = $client->DameOperador($parametros_dameOperador);

$objeto_dameOperador = $soap_result_DO->DameOperadorResult;


?>