<?php
    session_start();

    include_once('../../../ws_include/ws_Keys_consigna.php');
    include_once('../../../ws_include/ws_Keys_reserva.php');

    $idOperator = $_POST['del_id_oper'];
    $error = 0;
    
    if(isset($_POST)) {
        // --- LLAMAR WS : BorrarOperador 
        $parametros_borrarOperador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperator);
        $soap_result_BO = $SoapClient_KeysConsigna->BorrarOperador($parametros_borrarOperador);

        if(!(array)$soap_result_BO->BorrarOperadorResult){
            $error++;
        }

        // Busco los usuarios de dicho operador y los elimino
        // --- LLAMAR WS : DameUsuarios 
        $parametros_Usuarios = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idOperador'=>$idOperator, 'OrdenAoN'=>'N', 'idrol'=>0);
        $soap_result_usuarios = $SoapClient_KeysConsigna->DameUsuarios($parametros_Usuarios);        

        if((array)$soap_result_usuarios->DameUsuariosResult->Usuario->IdLocker){ // SÓLO 1
            // --- LLAMAR WS : BorrarUsuario 
            $parametros_BorraUser = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperator, 'IdUsuario'=>$soap_result_usuarios->DameUsuariosResult->Usuario->IdUsuario);
            $soap_result_BorraUser = $SoapClient_KeysConsigna->BorrarUsuario($parametros_BorraUser); 

            if(!(array)$soap_result_BorraUser->BorrarUsuarioResult){
                $error++;
            }
        }else{
            
            for ($i = 0; $i < count((array)$soap_result_usuarios->DameUsuariosResult->Usuario); $i++){
                // --- LLAMAR WS : BorrarUsuario 
                $parametros_BorraUser = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperator, 'IdUsuario'=>$soap_result_usuarios->DameUsuariosResult->Usuario[$i]->IdUsuario);
                $soap_result_BorraUser = $SoapClient_KeysConsigna->BorrarUsuario($parametros_BorraUser);
                if(!(array)$soap_result_BorraUser->BorrarUsuarioResult){
                    $error++;
                }
            }
        }

        // ELIMINAR CUPOS
        $parametros_Cupos = array('token'=>$token_ws, 'idlocker'=>$_SESSION['IdLocker'], 'idoperador'=>$idOperator);
        $soap_result_cupos = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($parametros_Cupos);

        if((array)$soap_result_cupos->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta){ // SÓLO 1
            $parametros_BorraCupo = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperator, 'IdPuerta'=> $soap_result_cupos->DamePuertasCupoPorOperadorResult->Puerta->IdPuerta);
            $soap_result_borracupos = $SoapClient_KeysReserva->BorrarPuertaCupo($parametros_BorraCupo);

            if(!(array)$soap_result_borracupos->BorrarPuertaCupoResult){
                $error++;
            }
        }else{
            for ($i = 0; $i < count((array)$soap_result_cupos->DamePuertasCupoPorOperadorResult->Puerta); $i++){
                $parametros_BorraCupo = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperator, 'IdPuerta'=> $soap_result_cupos->DamePuertasCupoPorOperadorResult->Puerta[$i]->IdPuerta);
                $soap_result_borracupos = $SoapClient_KeysReserva->BorrarPuertaCupo($parametros_BorraCupo);

                if(!(array)$soap_result_borracupos->BorrarPuertaCupoResult){
                    $error++;
                }
            }
        }

        if($error === 0){
            header("location:operadores.php");
        }else{
            header("location:operadores.php?error=1");
        }
    }
?>