<?php

require('./../ws/ws_reservas/ws2.php');

// --- LLAMAR WS : DecodificarQR --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_decodificarQR = array('token'=>$token_ws, 'textoCodificado'=>$codigoQR);

$soap_result_DQR = $client->DecodificarQR($parametros_decodificarQR);

$objeto_decodificarQR = $soap_result_DQR->DecodificarQRResult;


?>