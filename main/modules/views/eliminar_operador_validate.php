<?php

    session_start();

    require('../ws/ws_operadores/ws2.php');


    $idOperator = $_POST['del_id_oper'];

    
    if(isset($_POST)) {
        
        // --- LLAMAR WS : BorrarOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_borrarOperador = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>$idOperator);
        $soap_result_BO = $client->BorrarOperador($parametros_borrarOperador);
        header("location:operadores.php");
        die();

    }

        
    


/*     if($soap_result_EPF->ExistePinFechaResult == false && $soap_result_ELoc->ExisteLocalizadorResult == false) {

        $soap_result_IR = $client->InsertarReserva($parametros_insertarReserva);

        header("location:reservas.php");
        die();

    } */


?>