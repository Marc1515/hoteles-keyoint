<?php
    session_start();

    include_once('../../../ws_include/ws_Keys_reserva.php');

    $idLocker = $_SESSION['IdLocker'];

    $idOperadorString = $_POST['operador'];
    $idOperador = intval($idOperadorString);

    
    if(isset($_SESSION['IdLocker']) && isset($_POST['operador'])) {

        // --- LLAMAR WS : BorrarContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_borrarContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
        $soap_result_BC = $SoapClient_KeysReserva->BorrarContrato($parametros_borrarContrato);
        
        $objeto_borrarContrato = $soap_result_BC->BorrarContratoResult;

        if ($objeto_borrarContrato === true) {

            header('location:contratos.php');
            exit;
            
        }

    }
?>