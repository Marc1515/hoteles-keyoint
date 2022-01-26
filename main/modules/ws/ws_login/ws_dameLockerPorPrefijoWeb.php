<?php
    

    require './../ws/ws_login/ws2_consignaConsigna.php';

    $url = $_SERVER['HTTP_HOST'];

    $urlArray = explode('.', $url);


    // --- LLAMAR WS : DameLockerPorPrefijoWeb --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameLockerPorPrefijoWeb = array('token'=>$token_ws, 'PrefijoWeb'=>$urlArray[0]);
    $soap_result_DLPPW = $client->DameLockerPorPrefijoWeb($parametros_dameLockerPorPrefijoWeb);
    
    
    $objeto_dameLockerPorPrefijoWeb = $soap_result_DLPPW->DameLockerPorPrefijoWebResult;
    
    /* var_dump($objeto_dameLockerPorPrefijoWeb);die; */

?>