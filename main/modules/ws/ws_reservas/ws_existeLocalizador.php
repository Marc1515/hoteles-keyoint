<?php

    session_start();

    require('ws2.php');

    $idLocker = $_SESSION['idLocker'];
    
    // --- LLAMAR WS : ExisteLocalizador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_existeLocalizador = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'localizador'=>$localizador);
    $soap_result_ELoc = $client->ExisteLocalizador($parametros_existeLocalizador);

?>