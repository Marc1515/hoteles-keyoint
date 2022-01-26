<?php

    require('ws2.php');

    $idOperador = $_SESSION['idOperador'];
    $idLocker = $_SESSION['idLocker'];

        // --- LLAMAR WS : borrarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_borrarReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdReserva'=>$idReserva);
        $soap_result_BR = $client->BorrarReserva($parametros_borrarReserva);
        header("location:reservas.php");
        die();

?>