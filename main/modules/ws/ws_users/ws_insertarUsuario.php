<?php

require('ws2.php');

session_start();

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];


// --- LLAMAR WS : InsertarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_insertarUsuarios = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdUsuario'=>0, 'Nombre'=>$nombre, 'NombreUsuario'=>$nombreUser, 'Pwd'=>$pwd, 'IdRol'=>$idRol, 'Email'=>$email, 'Movil'=>$movil, 'PinSeguridad'=>$pin);
$soap_result_IU = $client->InsertarUsuario($parametros_insertarUsuarios);


?>