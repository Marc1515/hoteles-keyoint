<?php

session_start();

require 'ws2.php';

$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];
$idReservaString = $_POST['idReserva'];
$idReserva = intval($idReservaString);

$idPuertaEntradaString = $_POST['idPuerta'];
$idPuertaEntrada = intval($idPuertaEntradaString);

// --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva);
$soap_result_DR = $client->DameReserva($parametros_dameReserva);

$objeto_dameReserva = $soap_result_DR->DameReservaResult;


$entrada = $objeto_dameReserva->Entrada;
$salida = $objeto_dameReserva->Salida;
$localizador = $objeto_dameReserva->Localizador;
$referencia = $objeto_dameReserva->Referencia;
$nombre = $objeto_dameReserva->Nombre;
$movil = $objeto_dameReserva->Movil;
$email = $objeto_dameReserva->Email;
$pinEntrada = $objeto_dameReserva->PinEntrada;
$notificacion = $objeto_dameReserva->TipoNotificación;
$observaciones = $objeto_dameReserva->Observaciones;

$estadoString = $_POST['estado'];
$estado = intval($estadoString);

if(isset($objeto_dameReserva) && !is_null($objeto_dameReserva)) {

    // --- LLAMAR WS : ActualizarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_actualizarReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva, 'Entrada'=>$entrada, 'Salida'=>$salida,
    'Localizador'=>$localizador, 'Referencia'=>$referencia, 'Nombre'=>$nombre, 'Movil'=>$movil, 'Email'=>$email, 'PinEntrada'=>$pinEntrada, 'PinSalida'=>0,
    'IdPuertaEntrada'=>$idPuertaEntrada, 'IdPuertaSalida'=>0, 'TipoNotificacion'=>$notificacion, 'Observaciones'=>$observaciones, 'Estado'=>$estado);
    
    /* die(json_encode( array( 'reserva' => $parametros_actualizarReserva) ) ); */

    $soap_result_AR = $client->ActualizarReserva($parametros_actualizarReserva);

    $objeto_actualizarReserva = $soap_result_AR->ActualizarReservaResult;


    if (isset($objeto_actualizarReserva)) {

        die(json_encode( array( 'reserva' => $objeto_actualizarReserva) ) );

    }
    

    /* $objeto_actualizarReserva = $soap_result_AR->ActualizarReservaResult; */


}



?>