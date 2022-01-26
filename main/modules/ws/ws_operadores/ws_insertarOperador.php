<?php

    require('ws2.php');

    session_start();

    $idLocker = $_SESSION['idLocker'];

    // --- LLAMAR WS : InsertarOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_insertarOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'Nombre'=>$nombre, 'Email'=>$email, 'Movil'=>$movil);
    $soap_result_IO = $client->InsertarOperador($parametros_insertarOperador);

?>