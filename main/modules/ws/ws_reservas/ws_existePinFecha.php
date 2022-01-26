<?php

    session_start();

    require('ws2.php');

    $idLocker = $_SESSION['idLocker'];

    // --- LLAMAR WS : ExistePinFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_existePinFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'fecha'=>$entradaFrom, 'pin'=>$pinEntrada);
    $soap_result_EPF = $client->ExistePinFecha($parametros_existePinFecha);

?>