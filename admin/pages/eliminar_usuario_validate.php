<?php
    session_start();

    $idUser = $_POST['del_id_usr'];
    $idOp = $_POST['del_id_op'];
    include_once('../../../ws_include/ws_Keys_consigna.php');
    
    if(isset($_POST)) {
        //PUEDO BORRAR USUARIO?
        if($idOp == 0 && $idUser == 0){
            header("location:usuarios.php");
            die();
        }else{
            // --- LLAMAR WS : BorrarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_borrarUsuario = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOp, 'IdUsuario'=>$idUser);
            $soap_result_BU = $SoapClient_KeysConsigna->BorrarUsuario($parametros_borrarUsuario);

            if($soap_result_BU->BorrarUsuarioResult){
                header("location:usuarios.php");
            }
        }
    }

?>