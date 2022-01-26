<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
    header("location:../index.php");
    exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0) || empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

include_once('../../../ws_include/ws_Keys_consigna.php');

$idoperadorString = $_POST['idop'];
$idoperador = intval($idoperadorString);

$_SESSION['crearOActualizar'] = $_POST['crearOActualizar'];


$nombre = $_POST['nombre'];
$nombreUser = $_POST['nombreUsuario'];
$pwd = $_POST['pwd'];
$pwd2 = $_POST['pwd2'];
$idRolString = $_POST['idRol'];
$idRol = intval($idRolString);

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
    if($pwd==$pwd2) {
        // --- LLAMAR WS : InsertarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_insertarUsuarios = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idoperador,  'IdUsuario'=>0, 'Nombre'=>$nombre, 'NombreUsuario'=>$nombreUser, 'Pwd'=>$pwd, 'IdRol'=>$idRol, 'Email'=>$email, 'Movil'=>$movil, 'PinSeguridad'=>$pin);       
        $soap_result_IU = $SoapClient_KeysConsigna->InsertarUsuario($parametros_insertarUsuarios);

        if($soap_result_IU->InsertarUsuarioResult->Resultado == TRUE){
            include 'email_user.php';
            header("location:usuarios.php");
        }else{
            header("location:usuarios.php?error=0");
        }
    }else{
         header("location:crear-usuario.php?error=1");
    }
}
?>