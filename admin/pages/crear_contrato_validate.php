<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0) || empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$idLocker = $_SESSION['IdLocker'];
$idOperador = $_POST['operador'];

$desdeDate = DateTime::createFromFormat('d/m/Y', $_POST['desde']);
$desde = $desdeDate->format('Ymd');

$hastaDate = DateTime::createFromFormat('d/m/Y', $_POST['hasta']);
$hasta = $hastaDate->format('Ymd');

$cupoString = $_POST['cupo'];
$cupo = intval($cupoString);


include_once('../../../ws_include/ws_Keys_reserva.php');

if(isset($_POST)) {
    // --- LLAMAR WS : GrabarContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_grabarContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'Desde'=>$desde, 'Hasta'=>$hasta, 'Cupo'=>$cupo);
    $soap_result_GC = $SoapClient_KeysReserva->GrabarContrato($parametros_grabarContrato);
    
    $objeto_grabarContrato = $soap_result_GC->GrabarContratoResult;


    if($objeto_grabarContrato === TRUE){
        header("location:contratos.php");
    }else{
        header("location:contratos.php?error=1");
    }
}
?>