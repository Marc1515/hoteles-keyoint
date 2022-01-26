<?php

    session_start();

    require 'ws2.php';

    $idLocker = $_SESSION['idLocker'];
    $idOperador = $_POST['idOperador'];

    $entradaString = $_POST['entrada'];
    $entrada = date("Ymd", strtotime($entradaString));
    
    $salidaString = $_POST['salida'];
    $salida = date("Ymd", strtotime($salidaString));
    
    // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
    $soap_result_DC = $client->DameContrato($parametros_dameContrato);


    $objeto_dameContrato = $soap_result_DC->DameContratoResult;


    if (isset($objeto_dameContrato) && !is_null($objeto_dameContrato)) {

        $objeto_dameContrato = $soap_result_DC->DameContratoResult;

        die(json_encode( array( 'dameContratoEntrada' => $objeto_dameContrato->Desde, 'dameContratoSalida' => $objeto_dameContrato->Hasta) ) );

    }


?>