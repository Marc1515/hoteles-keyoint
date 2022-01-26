<?php

    require('ws2.php');

    $idOperador = $_SESSION['idOperador'];
    $idLocker = $_SESSION['idLocker'];

        // --- LLAMAR WS : anularReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_anularReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdReserva'=>$idReserva);
        $soap_result_AR = $client->AnularReserva($parametros_anularReserva);

?>