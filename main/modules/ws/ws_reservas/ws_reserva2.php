<?php

// ESTABLECER URL WEB SERVICES Y TOKEN
include('ws2.php');

session_start();

$idLocker = $_SESSION['idLocker'];
$idOperador = $_SESSION['idOperador'];
$entrada = $_POST['entrada'];
$entradaForm = date("Ymd", strtotime($entrada));


// --- LLAMAR WS : DameDisponiblesCupoFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameDisponiblesCupoFecha = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'IdOperador'=>$idOperador, 'fecha'=>$entradaForm);
$soap_result_DDCF = $client->DameDisponiblesCupoFecha($parametros_dameDisponiblesCupoFecha);

$disponiblesCuposFecha_array = $soap_result_DDCF->DameDisponiblesCupoFechaResult->Puerta;


if (is_array($disponiblesCuposFecha_array)) {

    $arrayInvertido = array_reverse($disponiblesCuposFecha_array);

    for ($step=0; $step<count($disponiblesCuposFecha_array); $step++) {
       $item = $arrayInvertido[$step]->Nombre;
   }


} elseif ($disponiblesCuposFecha_array) {

    $item = $disponiblesCuposFecha_array->Nombre;

} else {

    $item = "No hay puertas disponibles";


}




die( json_encode( array( 'status' => $item) ) );

?>