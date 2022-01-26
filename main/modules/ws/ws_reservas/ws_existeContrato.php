<?php

    session_start();

    require 'ws2.php';

    $idLocker = $_SESSION['idLocker'];
    $idOperador = $_POST['idOperador'];
    
    // --- LLAMAR WS : ExisteContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_existeContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
    $soap_result_EC = $client->ExisteContrato($parametros_existeContrato);

    if (isset($soap_result_EC) && !is_null($soap_result_EC)) {

        $objeto_existeContrato = $soap_result_EC->ExisteContratoResult;

        die(json_encode( array( 'existeContrato' => $objeto_existeContrato) ) );

    }


?>