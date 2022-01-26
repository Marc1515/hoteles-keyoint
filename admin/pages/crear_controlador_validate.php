<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0) || empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$idcontr = $_POST['id_controla'];
$nombre = $_POST['nombre'];
$ip = $_POST['ip'];
$puerto = $_POST['puerto'];
$espserie = $_POST['pserie'];

include_once('../../../ws_include/ws_Keys_consigna.php');
if(isset($_POST)) {
    // --- LLAMAR WS : InsertarControlador 
    $parametros_insertarContr = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdControlador'=>$idcontr, 'Nombre'=>$nombre, 'IP'=>$ip, 'Puerto'=>$puerto, 'esPuertoSerie'=>$espserie);
    $soap_result_IC = $SoapClient_KeysConsigna->InsertarControlador($parametros_insertarContr);

    if($soap_result_IC->InsertarControladorResult == TRUE){
        header("location:controladores.php");
    }else{
        header("location:controladores.php?error=1");
    }
}
?>