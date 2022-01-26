<?php

    require('./../ws/ws_reservas/ws2.php');

    session_start();

    $idOperador = $_SESSION['idOperador'];
    $idLocker = $_SESSION['idLocker'];

    // --- LLAMAR WS : GenerarQRTexto --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_generarQRTexto = array('token'=>$token_ws, 'IdLocker'=>$idLocker = 11051, 'IdOperador'=>$idOperador, 'IdReserva'=>$idReserva);
    $soap_result_GQRT = $client->GenerarQRTexto($parametros_generarQRTexto);

    $codigoQR = $soap_result_GQRT->GenerarQRTextoResult;

    require 'ws_decodificarQR.php';
    

    require 'phpqrcode/qrlib.php';


    $dir = "C:\inetpub/wwwroot/keysWeb/main/modules/views/temp/";


    $fileName = $dir.$objeto_decodificarQR.'.png';



    /* if(!file_exists($firstFileName)) { */

        $size = 15;
        $level = 'M';
        $frameSize = 1;
        $contenido = $codigoQR;

        
        QRcode::png($contenido, $fileName, $level, $size, $frameSize);

        $imagenQR = '<img src="'.$fileName.'" width="180">';


    

    /* } */


            

?>
