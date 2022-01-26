<?php

    session_start();

    $idReserva = $_POST['del_id_usr'];

    require('./../ws/ws_reservas/ws_dameReserva.php');

    /* var_dump($objeto_dameReserva);
    die(); */

    $idReserva = $objeto_dameReserva->IdReserva;
    $entrada = $objeto_dameReserva->Entrada;
    $salida = $objeto_dameReserva->Salida;
    $referencia = $objeto_dameReserva->Referencia;
    $nombre = $objeto_dameReserva->Nombre;
    $movil = $objeto_dameReserva->Movil;
    $localizador = $objeto_dameReserva->Localizador;
    $email = $objeto_dameReserva->Email;
    $observaciones = $objeto_dameReserva->IdReserva;
    $pinEntrada = $objeto_dameReserva->PinEntrada;
    $idPuertaEntrada = $objeto_dameReserva->IdPuertaEntrada;
    $notificacion = $objeto_dameReserva->TipoNotificación;
    $estado = $objeto_dameReserva->Estado;
    
    if(isset($_POST)) {
        

        $estado=3;

        // --- LLAMAR WS : actualizarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('./../ws/ws_reservas/ws_checkOutReserva.php');
        header("location:reservas.php?error=2");
        die();

    }


?>