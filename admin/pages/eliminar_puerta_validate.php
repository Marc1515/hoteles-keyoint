<?php
    session_start();

    $idPuerta = $_POST['del_idpuerta'];
    include_once('../../../ws_include/ws_Keys_consigna.php');
    
    if(isset($_POST)) {
        // --- LLAMAR WS : BorrarPuerta 
        $parametros_borrarPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdPuerta'=>$idPuerta);
        $soap_result_BP = $SoapClient_KeysConsigna->BorrarPuerta($parametros_borrarPuerta);

        if($soap_result_BP->BorrarPuertaResult){
            header("location:puertas.php");
        }else{
            header("location:puertas.php?error=1");
        }
    }

?>