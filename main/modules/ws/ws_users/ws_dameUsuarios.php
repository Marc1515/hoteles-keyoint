<?php

session_start();

require 'ws2.php';

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

/* if($_POST) {

    $idOperador = $_POST['idOperador'];

} */


// --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idOperador'=>$idOperador,  'OrdenAoN'=>'A', 'idrol'=>0);
$soap_result_DU = $client->DameUsuarios($parametros_dameUsuarios);

$usersArray = $soap_result_DU->DameUsuariosResult->Usuario;


?>