<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0) || empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$id_puerta = $_POST['id_puerta'];
$nombre = $_POST['nombre'];
$puertocu = $_POST['puertocu'];
if($_POST['activa'] == 'No'){
    $activa = False;
}else{
    $activa = True;
}
$idtipo = $_POST['idtipo'];
$idcontrola = $_POST['idcontrola'];
$posicion = $_POST['posicion'];

include_once('../../../ws_include/ws_Keys_consigna.php');
if(isset($_POST)) {
    // --- LLAMAR WS : ActualizarPuerta 
    $parametros_actPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdPuerta'=>$id_puerta, 'Nombre'=>$nombre, 'PuertoCU'=>$puertocu, 'Activa'=>$activa, 'IdTipoPuerta'=>$idtipo, 'IdControlador'=>$idcontrola, 'Posicion'=>$posicion);
    $soap_result_AP = $SoapClient_KeysConsigna->ActualizarPuerta($parametros_actPuerta);

    if($soap_result_AP->ActualizarPuertaResult == TRUE){
        header("location:puertas.php");
    }else{
        header("location:puertas.php?error=1");
    }
}
?>