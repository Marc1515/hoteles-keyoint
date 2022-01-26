<?php

session_start();

require('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

$idUser = $_GET['upd'];

// --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdUsuario'=>$idUser);
$soap_result_DU = $client->DameUsuario($parametros_dameUsuario);

$objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;


?>