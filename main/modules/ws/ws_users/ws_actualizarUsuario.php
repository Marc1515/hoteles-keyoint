<?php

session_start();

require('ws2.php');

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

// --- LLAMAR WS : ActualizarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_actualizarUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdUsuario'=>$idUsuario, 'Nombre'=>$nombre, 'NombreUsuario'=>$nombreUser,
'Pwd'=>$pwd, 'IdRol'=>$idRol, 'Email'=>$email, 'Movil'=>$movil, 'PinSeguridad'=>$pin);

$soap_result_AU = $client->ActualizarUsuario($parametros_actualizarUsuario);

?>