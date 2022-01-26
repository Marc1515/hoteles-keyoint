<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0) || empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$id_tipopuerta = $_POST['id_tipopuerta'];
$nombre = $_POST['nombre'];
$siglas = $_POST['siglas'];
if($_POST['control'] == 'No'){
    $control = False;
}else{
    $control = True;
}
if($_POST['cargador'] == 'No'){
    $cargador = False;
}else{
    $cargador = True;
}
$ancho = $_POST['ancho'];
$alto = $_POST['alto'];
$prof = $_POST['prof'];

include_once('../../../ws_include/ws_Keys_consigna.php');
if(isset($_POST)) {
    // --- LLAMAR WS : InsertarTipoPuerta 
    $parametros_insertarTipoPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdTipoPuerta'=>$id_tipopuerta, 'Nombre'=>$nombre, 'Siglas'=>$siglas, 'EsControl'=>$control, 'EsCargador'=>$cargador, 'Ancho'=>$ancho, 'Alto'=>$alto, 'Profundo'=>$prof);
    $soap_result_ITP = $SoapClient_KeysConsigna->InsertarTipoPuerta($parametros_insertarTipoPuerta);

    if($soap_result_ITP->InsertarTipoPuertaResult == TRUE){
        header("location:tipospuerta.php");
    }else{
        header("location:tipospuerta.php?error=1");
    }
}
?>