<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$idLocker = $_SESSION['IdLocker'];

$idOperadorString = $_POST['idOperador'];
$idOperador = intval($idOperadorString);

$desdeDate = DateTime::createFromFormat('d/m/Y', $_POST['desde']);
$desde = $desdeDate->format('Ymd');

$hastaDate = DateTime::createFromFormat('d/m/Y', $_POST['hasta']);
$hasta = $hastaDate->format('Ymd');

$cupoString = $_POST['cupo'];
$cupo = intval($cupoString);

include_once('../../../ws_include/ws_Keys_reserva.php');


if(isset($_POST)) {


  // --- LLAMAR WS : DameCupoDisponible --------------------------------------------------------------------------------------------------------------------------------------------------->
  $parametros_dameCupoDisponible = array('token'=>$token_ws, 'IdLocker'=>$idLocker);
  $soap_result_DCD = $SoapClient_KeysReserva->DameCupoDisponible($parametros_dameCupoDisponible);
  
  $objeto_dameCupoDisponible = $soap_result_DCD->DameCupoDisponibleResult;


  // --- LLAMAR WS : DamePuertasCupoPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
  $parametros_damePuertasCupoPorOperador = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador);
  $soap_result_DPCPO = $SoapClient_KeysReserva->DamePuertasCupoPorOperador($parametros_damePuertasCupoPorOperador);
  
  $objeto_damePuertasCupoPorOperador = $soap_result_DPCPO->DamePuertasCupoPorOperadorResult->Puerta;

    if (!is_array($objeto_damePuertasCupoPorOperador) && !is_null($objeto_damePuertasCupoPorOperador)) {

      $numeroPuertas = 1;

    } elseif (is_array($objeto_damePuertasCupoPorOperador)) {

      $numeroPuertas = count($objeto_damePuertasCupoPorOperador);

    } else {

      $numeroPuertas = 0;

    }



  if ($cupo <= $objeto_dameCupoDisponible) {

    // --- LLAMAR WS : GrabarContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_grabarContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'Desde'=>$desde, 'Hasta'=>$hasta, 'Cupo'=>$cupo);
    $soap_result_GC = $SoapClient_KeysReserva->GrabarContrato($parametros_grabarContrato);
    
    $objeto_grabarContrato = $soap_result_GC->DameContratoResult;

    header("location:contratos.php");
    die();

  } else {

    header("location:actualizar-contrato.php?upd=$idOperador");
    die();

  }

}
?>