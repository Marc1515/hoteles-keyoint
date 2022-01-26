<?php

session_start();

require('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : BorrarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_borrarUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdUsuario'=>$idUser);
$soap_result_BU = $client->BorrarUsuario($parametros_borrarUsuario);


?>