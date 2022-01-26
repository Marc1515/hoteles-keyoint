<?php
    session_start();

    include_once('../../../ws_include/ws_Keys_consigna.php');
    
    $idcontr = $_POST['del_id_contr'];
    if(isset($_POST)) {
        // --- LLAMAR WS : BorrarControlador 
        $parametros_borrarContr = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdControlador'=>$idcontr);
        $soap_result_BC = $SoapClient_KeysConsigna->BorrarControlador($parametros_borrarContr);

        if($soap_result_BC->BorrarControladorResult){
            header("location:controladores.php");
            die();
        }else{
            header("location:controladores.php?error=1");
            die();
        }
    }

?>