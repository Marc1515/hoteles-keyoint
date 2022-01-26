<?php

    if (isset($_SESSION)) {

        session_destroy();

    }

    $loginIdOperadorString = $_POST['operator'];
    $loginIdOperador = intval($loginIdOperadorString);

    $login_user = $_POST['user'];
    $login_pass = $_POST['pass'];

    session_start();

    require './../ws/ws_login/ws_dameLockerPorPrefijoWeb.php';

    $idLocker = $objeto_dameLockerPorPrefijoWeb->IdLocker;
    $_SESSION['idLocker'] = $idLocker;


    require './../ws/ws_operadores/ws_dameOperadores.php';


    $nombreOperador = $objeto_dameOperador->Nombre;
    $movilOperador = $objeto_dameOperador->Movil;

    include '../ws/ws_login/ws_consigna.php';
    include '../ws/ws_reservas/ws2_verificarPass.php';
    
    $_SESSION['user'] = $login_user;
    $_SESSION['rol'] = $rol;
    $_SESSION['idOperador'] = $loginIdOperador;
    $_SESSION['movilOper'] = $movilOperador;

    // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$_SESSION['idOperador']);
    $soap_result_DO = $client->DameOperador($parametros_dameOperador);

    $objeto_dameOperador = $soap_result_DO->DameOperadorResult;
    
    
    $nombreOperador = $objeto_dameOperador->Nombre;

    $_SESSION['operator'] = $nombreOperador;


    $idOperadorBD = $objeto_dameOperador->IdOperador;

    require './../../../../ws_include/ws_Keys_reserva.php';


    // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$_SESSION['idOperador']);
    $soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);

    $objeto_dameContrato = $soap_result_DC->DameContratoResult;

    $_SESSION['contrato_desde'] = $objeto_dameContrato->Desde;
    $_SESSION['contrato_hasta'] = $objeto_dameContrato->Hasta;

    /* var_dump($objeto_dameContrato);die; */


        // Coincide con el Operador?
        if ($loginIdOperador === $idOperadorBD) {

            // --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idOperador'=>$_SESSION['idOperador'],  'OrdenAoN'=>'A', 'idrol'=>0);
            $soap_result_DU = $client->DameUsuarios($parametros_dameUsuarios);

            $objeto_dameUsuarios = $soap_result_DU->DameUsuariosResult->Usuario;


            if (!is_array($objeto_dameUsuarios) && !is_null($objeto_dameUsuarios)) {


                if ($login_user == $objeto_dameUsuarios->NombreUsuario && $login_pass == $objeto_dameUsuarios->Pwd) {  
                    
                    // --- LLAMAR WS : ComprobarNoShow --------------------------------------------------------------------------------------------------------------------------------------------------->
                    $parametros_comprobarNoShow = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameUsuarios->IdOperador);
                    $soap_result_CNS = $client_reservas->ComprobarNoShow($parametros_comprobarNoShow);

                    $objeto_comprobarNoShow = $soap_result_CNS->ComprobarNoShowResult;

                    if ($objeto_comprobarNoShow === true) {
                    
                        setcookie("tiempoUsuario", "Maximo tiempo de sesion para un Usuario", time() + 1200);
                        header("location:dashboard.php");
                        die;

                    }

                } else {

                    header("location:index.php?error=1");
                    die;

                }

            } elseif (is_array($objeto_dameUsuarios)) {

                for ($step=0; $step<count($objeto_dameUsuarios); $step++) {

                    if ($login_user === $objeto_dameUsuarios[$step]->NombreUsuario && $login_pass === $objeto_dameUsuarios[$step]->Pwd) {

                        // --- LLAMAR WS : ComprobarNoShow --------------------------------------------------------------------------------------------------------------------------------------------------->
                        $parametros_comprobarNoShow = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameUsuarios[$step]->IdOperador);
                        $soap_result_CNS = $client_reservas->ComprobarNoShow($parametros_comprobarNoShow);

                        $objeto_comprobarNoShow = $soap_result_CNS->ComprobarNoShowResult;

                        setcookie("tiempoUsuario", "Maximo tiempo de sesion para un Usuario", time() + 1200);
                        header("location:dashboard.php");
                        die();    

                    } else {

                        header("location:index.php?error=1");
                        die;

                    }

                }

            }

        } else {

            header("location:index.php?error=2");

        }



?>
