<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0) || empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$idlocker = $_POST['id_lock'];
$nombre = $_POST['nombre'];
$numserie = $_POST['serie'];
$estado = $_POST['estado'];
$vpn = $_POST['vpn'];
$bd = $_POST['bd'];
$urlMap = $_POST['urlMaps'];

include_once('../../../ws_include/ws_Keys_consigna.php');
if(isset($_POST)) {
    // --- LLAMAR WS : ActualizarLocker 
    $parametros_actLocker = array('token'=>$token_ws, 'IdLocker'=>$idlocker, 'NumeroSerie'=>$numserie, 'Nombre'=>$nombre, 'Estado'=>$estado, 'VPN'=>$vpn, 'BD'=>$bd, 'UrlMaps'=>$urlMap);
    $soap_result_AL = $SoapClient_KeysConsigna->ActualizarLocker($parametros_actLocker);

    if($soap_result_AL->ActualizarLockerResult == TRUE){
        header("location:lockers.php");
    }else{
        header("location:lockers.php?error=1");
    }
}
?>