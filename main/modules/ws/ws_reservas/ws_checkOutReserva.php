<?php

require('ws2.php');


$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];


require 'ws_dameReserva.php';


$parametros_actualizarReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva, 'Entrada'=>$entrada, 'Salida'=>$salida,
'Localizador'=>$localizador, 'Referencia'=>$referencia, 'Nombre'=>$nombre, 'Movil'=>$movil, 'Email'=>$email, 'PinEntrada'=>$pinEntrada, 'PinSalida'=>0,
'IdPuertaEntrada'=>$idPuertaEntrada, 'IdPuertaSalida'=>0, 'TipoNotificacion'=>$notificacion, 'Observaciones'=>$observaciones, 'Estado'=>$estado);
$soap_result_AR = $client->ActualizarReserva($parametros_actualizarReserva);

$objeto_dameReserva = $soap_result_AR;

?>