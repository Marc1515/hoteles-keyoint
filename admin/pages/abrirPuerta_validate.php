<?php

session_start();

require './../../../ws_include/ws_abrirPuertas.php';


$idLocker = $_SESSION['IdLocker'];

$idPuertaString = $_POST['idPuerta'];
$idPuerta = intval($idPuertaString);


    // --- LLAMAR WS : AbrirPuerta --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_abrirPuerta = array('token'=>$token_ws, 'idLocker'=>$idLocker, 'idPuerta'=>$idPuerta);


    if (isset($parametros_abrirPuerta) && !is_null($parametros_abrirPuerta)) {

        $soap_result_AP = $client->AbrirPuerta($parametros_abrirPuerta);
        $objeto_abrirPuerta = $soap_result_AP->AbrirPuertaResult;

        header('location:estadoActual.php');
        exit();

    }

?>