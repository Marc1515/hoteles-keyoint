<?php

require('ws2.php');

// --- LLAMAR WS : DecodificarQR --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_decodificarQR = array('token'=>$token_ws, 'textoCodificado'=>222);

$soap_result_DQR = $client->DecodificarQR($parametros_decodificarQR);

$objeto_decodificarQR = $soap_result_DQR;

?>