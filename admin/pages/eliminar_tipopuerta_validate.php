<?php
    session_start();

    $idTipoPuerta = $_POST['del_idtipopuerta'];
    include_once('../../../ws_include/ws_Keys_consigna.php');

    if(isset($_POST)) {
        // --- LLAMAR WS : BorrarTipoPuerta 
        $parametros_borrarTipoPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdTipoPuerta'=>$idTipoPuerta);
        $soap_result_BTP = $SoapClient_KeysConsigna->BorrarTipoPuerta($parametros_borrarTipoPuerta);

        if($soap_result_BTP->BorrarTipoPuertaResult){
            header("location:tipospuerta.php");
        }else{
            echo $SoapClient_KeysConsigna->__getLastRequest();
            die();
            header("location:tipospuerta.php?error=1");
        }
    }

?>