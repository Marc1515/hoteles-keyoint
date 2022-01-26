<?php

    session_start();

    require 'ws_consigna.php';
    require 'ws2.php';

    $url = $_SERVER['HTTP_HOST'];
    $urlPrefijo = explode('.', $url);

    $idOperador = $_POST['idOperador'];


    // --- LLAMAR WS : DameLockerPorPrefijoWeb --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameLockerPorPrefijoWeb = array('token'=>$token_ws, 'PrefijoWeb'=>$urlPrefijo[0]);
    $soap_result_DLPPW = $client_consigna->DameLockerPorPrefijoWeb($parametros_dameLockerPorPrefijoWeb);

    $objeto_dameLockerPorPrefijoWeb = $soap_result_DLPPW->DameLockerPorPrefijoWebResult;

    
    // --- LLAMAR WS : ExisteContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_existeContrato = array('token'=>$token_ws, 'IdLocker'=>$objeto_dameLockerPorPrefijoWeb->IdLocker, 'IdOperador'=>$idOperador);
    $soap_result_EC = $client->ExisteContrato($parametros_existeContrato);

    if (isset($soap_result_EC) && !is_null($soap_result_EC)) {

        $objeto_existeContrato = $soap_result_EC->ExisteContratoResult;

        die(json_encode( array( 'existeContrato' => $objeto_existeContrato) ) );

    }


?>