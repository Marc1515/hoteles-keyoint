<?php

require('ws2.php');

$idLocker = $_SESSION['idLocker'];

$parametros_actualizarReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva, 'Entrada'=>$entradaFrom, 'Salida'=>$salidaFrom,
'Localizador'=>$localizador, 'Referencia'=>$referencia, 'Nombre'=>$nombre, 'Movil'=>$movilConPrefijo, 'Email'=>$email, 'PinEntrada'=>$pinEntrada, 'PinSalida'=>0,
'IdPuertaEntrada'=>$idPuertaEntrada, 'IdPuertaSalida'=>0, 'TipoNotificacion'=>$notificacion, 'Observaciones'=>$observaciones, 'Estado'=>$estado);

/* var_dump($parametros_actualizarReserva); die; */

$soap_result_AR = $client->ActualizarReserva($parametros_actualizarReserva);

$objeto_dameReserva = $soap_result_AR->ActualizarReservaResult;


?>