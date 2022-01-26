<?php

session_start();

require './../ws/ws_operadores/ws2.php';

//) --- LEE DATOS POST --------------------------------------------------------------------------------------------------------------------------------------------------------------->

    $idLocker = $_SESSION['IdLocker'];
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
    $movilOperador = $_POST['movilOperador'];
    $operador = $_POST['operador'];
    $url = $_POST['ubiLocker'];
    $missatgeSiONo = $_POST['styled_radio'];
    $idioma = $_POST['idioma'];

    $idOperadorString = $_POST['idOperador'];
    $idOperador = intval($idOperadorString);

    $direccionOperador = $_POST['direccionOperador'];
    $poblacionOperador = $_POST['poblacionOperador'];
    $telefonoOperador = $_POST['telefonoOperador'];
    $emailOperador = $_POST['emailOperador'];



    $entradaFrom = date("Ymd", strtotime($entrada));
    $salidaFrom = date("Ymd", strtotime($salida));

    /* // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['idLocker'] = 11051, 'IdOperador'=>$idOperador);
    $soap_result_DO = $client->DameOperador($parametros_dameOperador);

    $objeto_dameOperador = $soap_result_DO->DameOperadorResult;

    $emailOperador = $objeto_dameOperador->Email; */


    if ($localizador === '') {

        // --- LLAMAR WS : generarLocalizador --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('./../ws/ws_reservas/ws_generarLocalizador.php'); 

        $localizador = $objeto_generarLocalizador;

    }


    // --- LLAMAR WS : dameReservaPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_reservas/ws_dameReservaPorOperador.php');

    // --- LLAMAR WS : GenerarPin --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('../ws/ws_reservas/ws_genPin.php');

    // --- LLAMAR WS : ExisteLocalizador --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_reservas/ws_existeLocalizador.php');

    // --- LLAMAR WS : ExistePinFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_reservas/ws_existePinFecha.php');

    // --- LLAMAR WS : InsertarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_reservas/ws_insertarReserva.php');



    if($soap_result_EPF->ExistePinFechaResult == false && $soap_result_ELoc->ExisteLocalizadorResult == false) {
        
      
      $soap_result_IR = $client->InsertarReserva($parametros_insertarReserva);

      $idReservaString = $soap_result_IR->InsertarReservaResult->Msg;

      $idReserva = intval($idReservaString);

        // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('ws_generarQRTexto.php');

      if ($notificacion == 1 /* && $soap_result_IR->InsertarReservaResult->Resultado == true */) {

        if ($missatgeSiONo == 1 && $idioma == 1) {
          
        require 'testenviosms.php';
        require 'emailParaOperadorAlEnviarSMS.php';
        header("location:reservas.php?error=0");

        } elseif ($missatgeSiONo == 1 && $idioma == 2) {

        require 'testenviosms_ingles.php';
        require 'emailParaOperadorAlEnviarSMS_ingles.php';
        header("location:reservas.php?error=0");

        } elseif ($missatgeSiONo == 1 && $idioma == 3) {

        require 'testenviosms_aleman.php';
        require 'emailParaOperadorAlEnviarSMS_aleman.php';
        header("location:reservas.php?error=0");

        }

      } elseif ($notificacion == 2 /* && $soap_result_IR->InsertarReservaResult->Resultado == true */) {

        if($missatgeSiONo == 1 && $idioma == 1) {
        
          require 'email.php';
          header("location:reservas.php?error=0");

        } elseif ($missatgeSiONo == 1 && $idioma == 2) {
          
          require 'email_ingles.php';
          header("location:reservas.php?error=0");

        } elseif ($missatgeSiONo == 1 && $idioma == 3) {
          
          require 'email_aleman.php';
          header("location:reservas.php?error=0");
        }
        /* header("location:reservas.php");
        die(); */

      } 
      
      header("location:reservas.php?error=0");

    } else {
        header("location:reservas.php");
        die();
    }


?>

