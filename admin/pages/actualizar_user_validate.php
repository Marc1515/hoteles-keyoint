<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

include_once('../../../ws_include/ws_Keys_consigna.php');

$idUsuarioString = $_POST['idUsuario'];
$idUsuario = intval($idUsuarioString);

$idoperadorString = $_POST['idop'];
$idoperador = intval($idoperadorString);

$idRolString = $_POST['idRol'];
$idRol = intval($idRolString);

$_SESSION['crearOActualizar'] = $_POST['crearOActualizar'];

$nombre = $_POST['nombre'];
$nombreUser = $_POST['nombreUsuario'];
$pwd = $_POST['pwd'];
$movil = $_POST['full_phone'];
$email = $_POST['example-email'];
$pinString = $_POST['pin'];

$pin = str_pad($pinString, 6, 0, STR_PAD_LEFT);


// --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idoperador);
$soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);

$objeto_dameOperador = $soap_result_DO->DameOperadorResult;


// --- LLAMAR WS : DameLocker --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameLocker = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
$soap_result_DL = $SoapClient_KeysConsigna->DameLocker($parametros_dameLocker);

$objeto_dameLocker = $soap_result_DL->DameLockerResult;



$_SESSION['nombreOperador'] = $objeto_dameOperador->Nombre;
$_SESSION['emailOperador'] = $objeto_dameOperador->Email;
$_SESSION['ubiLocker'] = $objeto_dameLocker->URLMaps;

if(isset($_POST)) {  
      
    // --- LLAMAR WS : ActualizarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_actualizarUsuario = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idoperador,  'IdUsuario'=>$idUsuario, 'Nombre'=>$nombre, 'NombreUsuario'=>$nombreUser,
    'Pwd'=>$pwd, 'IdRol'=>$idRol, 'Email'=>$email, 'Movil'=>$movil, 'PinSeguridad'=>$pin);
    
    $soap_result_AU = $SoapClient_KeysConsigna->ActualizarUsuario($parametros_actualizarUsuario);

    if($soap_result_AU->ActualizarUsuarioResult){
        include 'email_user.php';
        header("location:usuarios.php");
        die();
    }else{
        header("location:usuarios.php?error=1");
        die();
    }

}else{
    header("location:usuarios.php");
}

?>