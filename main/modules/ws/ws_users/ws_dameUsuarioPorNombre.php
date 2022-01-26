<?php

session_start();

require('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : DameUsuarioPorNombre --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameUsuariosPorNombre = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'nombreUsuario'=>$_SESSION['user']);
$soap_result_DUPN = $client->DameUsuarioPorNombre($parametros_dameUsuariosPorNombre);


if ($_SESSION['user'] !== 'keypoint') {

    $usersArrayN = $soap_result_DUPN->DameUsuarioPorNombreResult->IdRol;


} else {

    $usersArrayN = $soap_result_DUPN;

}


?>