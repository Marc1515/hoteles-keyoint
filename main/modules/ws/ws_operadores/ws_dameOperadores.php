<?php

    require('ws2.php');

    /* session_start(); */

    /* $idLocker = $_SESSION['idLocker']; */

    // --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'OrdenAoN'=>'A');
    $soap_result_DO = $client->DameOperadores($parametros_dameOperadores);


    $operadoresArraySinInv = $soap_result_DO->DameOperadoresResult->Operador;

    $operadoresArray = array_reverse($operadoresArraySinInv);

    $nextIdOperator = count($operadoresArray)+1;

?>