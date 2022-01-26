<?php

session_start();

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

    require('ws2.php');

        // --- LLAMAR WS : ActualizarOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_actualizarOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker,  'IdOperador'=>$idOperador, 'Nombre'=>$nombre, 'Email'=>$email, 'Movil'=>'+34'.$movil);
        var_dump($parametros_actualizarOperador);die;
        $soap_result_AO = $client->ActualizarOperador($parametros_actualizarOperador);

        header("location:operadores.php");
        die();
    
?>