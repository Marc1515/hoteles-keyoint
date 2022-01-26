<?php

    require('ws2.php');

    $idLocker = $_SESSION['idLocker'];

    // --- LLAMAR WS : InsertarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_insertarReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'Entrada'=>$entradaFrom, 'Salida'=>$salidaFrom, 'Localizador'=>$localizador,
    'Referencia'=>$referencia, 'Nombre'=>$nombre, 'Movil'=>$movilConPrefijo, 'Email'=>$email, 'PinEntrada'=>$pinEntrada, 'PinSalida'=>0, 'IdPuertaEntrada'=>$idPuertaEntrada,
    'IdPuertaSalida'=>0, 'TipoNotificacion'=>$notificacion, 'Observaciones'=>$observaciones, 'Estado'=>0);


?>