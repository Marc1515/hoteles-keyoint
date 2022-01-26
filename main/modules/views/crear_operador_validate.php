<?php

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $movil = $_POST['phone'];

    session_start();

    require('../ws/ws_operadores/ws2.php');

    $numeroRand1 = rand(0,999999);

    $numToString1 = strval($numeroRand1);

    $numeroRand2 = rand(0,999999);

    $numToString2 = strval($numeroRand2);


    // --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_operadores/ws_dameOperadores.php');


    // --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_users/ws_dameUsuarios.php');

    
    if(isset($_POST)) {

        // --- LLAMAR WS : InsertarOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('./../ws/ws_operadores/ws_insertarOperador.php');

        // --- LLAMAR WS : InsertarUsuario (Admin) --------------------------------------------------------------------------------------------------------------------------------------------------->    
        $parametros_insertarUsuarios = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>1,  'IdUsuario'=>$nextIdUser, 'Nombre'=>$nombre, 'NombreUsuario'=>'Administrador', 'Pwd'=>1234, 'IdRol'=>1, 'Email'=>$email, 'Movil'=>'+34'.$movil, 'PinSeguridad'=>$numToString1);
        $soap_result_IU = $client->InsertarUsuario($parametros_insertarUsuarios);

        // --- LLAMAR WS : InsertarUsuario (User) --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_insertarUsuarios = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>1,  'IdUsuario'=>$nextIdUser2, 'Nombre'=>$nombre, 'NombreUsuario'=>'Usuario', 'Pwd'=>1234, 'IdRol'=>2, 'Email'=>$email, 'Movil'=>'+34'.$movil, 'PinSeguridad'=>$numToString2);
        $soap_result_IU = $client->InsertarUsuario($parametros_insertarUsuarios);

        header("location:operadores.php");
        die();

    }


?>