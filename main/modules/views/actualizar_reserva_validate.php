<?php

    $idReserva = $_POST['idReserva'];
    $estado = $_POST['estado'];
    $entrada = $_POST['entrada'];
    $salida = $_POST['salida'];
    $referencia = $_POST['referencia'];
    $nombre = $_POST['nombre'];
    $movil = $_POST['movil'];
    $movilConPrefijo = $_POST['full_phone'];
    $localizador = $_POST['localizador'];
    $email = $_POST['example-email'];
    $observaciones = $_POST['observaciones'];
    $pinEntrada = $_POST['pinEntrada'];
    $idPuertaEntrada = $_POST['idPuertaEntrada'];
    $notificacion = $_POST['notificacion'];
    $operador = $_POST['operador'];
    $movilOperador = $_POST['movilOperador'];
    $url = $_POST['ubiLocker'];
    $missatgeSiONo = $_POST['styled_radio'];
    $idioma = $_POST['idioma'];
    $idOperadorString = $_POST['idOperador'];
    $idOperador = intval($idOperadorString);

    $direccionOperador = $_POST['direccionOperador'];
    $poblacionOperador = $_POST['poblacionOperador'];
    $telefonoOperador = $_POST['telefonoOperador'];
    $emailOperador = $_POST['emailOperador'];


    session_start();

    $entradaFrom = date("Ymd", strtotime($entrada));
    $salidaFrom = date("Ymd", strtotime($salida));

    require './../ws/ws_operadores/ws_dameOperador.php';

    // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['idLocker'], 'IdOperador'=>$idOperador);
    $soap_result_DO = $client->DameOperador($parametros_dameOperador);

    $objeto_dameOperador = $soap_result_DO->DameOperadorResult;

    
    $idOperador = $_SESSION['idOperador'];


    if(isset($_POST)) {
        require('./../ws/ws_reservas/ws2.php');
        
        // --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['idLocker'], 'IdOperador'=>$idOperador, 'IdReserva'=>$idReserva, );
        $soap_result_DRPO = $client->DameReserva($parametros_dameReserva);
        
        $objeto_dameReserva = $soap_result_DRPO->DameReservaResult;


            if($reservasArray[$let]->Estado == 0) {

                
                // --- LLAMAR WS : ActualizarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                require('./../ws/ws_reservas/ws_actualizarReserva.php');

                // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
                require('ws_generarQRTexto.php');

                if ($notificacion == 1/*  && $objeto_dameReserva->ActualizarReservaResult == true */) {


                    if ($missatgeSiONo == 1 && $idioma == 1) {

                        require 'testenviosms.php';
                        require 'emailParaOperadorAlEnviarSMS.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 2) {

                        require 'testenviosms_ingles.php';
                        require 'emailParaOperadorAlEnviarSMS_ingles.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 3) {

                        require 'testenviosms_aleman.php';
                        require 'emailParaOperadorAlEnviarSMS_aleman.php';
                        header("location:reservas.php?error=2");
                        die();

                    }



                } elseif ($notificacion == 2/*  && $objeto_dameReserva->ActualizarReservaResult == true */) {

                
                    if($missatgeSiONo == 1 && $idioma == 1) {
                        
                        // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
                       // require('ws_generarQRTexto.php');

                        require './email.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 2) {
                        
                        // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
                       // require('ws_generarQRTexto.php');
                        
                        require './email_ingles.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 3) {
                        
                        // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
                      //  require('ws_generarQRTexto.php');
                        
                        require './email_aleman.php';
                        header("location:reservas.php?error=2");
                        die();

                    }

                }

                header("location:reservas.php?error=2");
                die();



            } elseif ($reservasArray[$let]->Estado == 2) {

                //$estado = 2; // Es para que no se ponga en el estado 9

                // --- LLAMAR WS : ActualizarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                require('./../ws/ws_reservas/ws_actualizarReserva.php');

                // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
                require('ws_generarQRTexto.php');

                if ($notificacion == 1/*  && $objeto_dameReserva->ActualizarReservaResult == true */) {
                    
                    if ($missatgeSiONo == 1 && $idioma == 1) {

                        require 'testenviosms.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 2) {

                        require 'testenviosms_ingles.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 3) {

                        require 'testenviosms_aleman.php';
                        header("location:reservas.php?error=2");
                        die();

                    }


                } elseif ($notificacion == 2/*  && $objeto_dameReserva->ActualizarReservaResult == true */) {

                
                    if($missatgeSiONo == 1 && $idioma == 1) {
                        
                        require './email.php';
                        header("location:reservas.php?error=2");
                        die();
            
                    } elseif ($missatgeSiONo == 1 && $idioma == 2) {

                        require './email_ingles.php';
                        header("location:reservas.php?error=2");
                        die();

                    } elseif ($missatgeSiONo == 1 && $idioma == 3) {

                        require './email_aleman.php';
                        header("location:reservas.php?error=2");
                        die();

                    }
         
                }

                header("location:reservas.php");
                die();
            }
        }
    /* } */

?>