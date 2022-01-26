<?php
session_start();
require_once("./tcpdf/tcpdf.php");

require './../ws/ws_reservas/ws2.php';

/* require './../ws/ws_reservas/ws_dameReservaPorOperador.php'; */

$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];

/* if(isset($_POST['desde']) && isset($_POST['hasta']) && isset($_POST['idOperador']) && isset($_POST['estado'])) { */

  $desdeForm = $_GET['desde'];
  $desde = date("Ymd", strtotime($desdeForm));


  $hastaForm = $_GET['hasta'];
  $hasta = date("Ymd", strtotime($hastaForm));


  $idOperadorForm = $_SESSION['idOperador'];
  $idOperator = $estado = intval($idOperadorForm);
  $estadoString = $_GET['estado'];
  $estado = intval($estadoString);
  
/* } */


// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);


$reservasArray = $soap_result_DR->DameReservasPorOperadorResult->Reserva;


$fichero = " <table>
                <thead>
                  <tr>
                    <th>".utf8_decode('Nº Reserva')."</th>
                    <th>Nombre</th>
                    <th>Localizador</th>
                    <th>Entrada</th>
                    <th>Salida</th>
                    <th>Movil</th>
                    <th>Puerta</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>";


if (is_array($reservasArray)) {

for ($step=0; $step<count($reservasArray); $step++){

    
    // Fecha de entrada con formato
    $newInPutDate = $reservasArray[$step]->Entrada;

    $newInPutDate = date("d-m-Y", strtotime($newInPutDate));

    // Fecha de salida con formato
    $newOutPutDate = $reservasArray[$step]->Salida;

    $newOutPutDate = date("d-m-Y", strtotime($newOutPutDate));



    if ($reservasArray[$step]->Estado == 0) {
        $estado = "Confirmada";
    } elseif ($reservasArray[$step]->Estado == 1) {
        $estado = "Anulada";
    } elseif ($reservasArray[$step]->Estado == 2) {
        $estado = "Entrada";
    } elseif ($reservasArray[$step]->Estado == 3) {
        $estado = "Salida";
    }
   
    
  /* $txt_fecha = new DateTime($array_dameOcupacionEntreFechas[$step]->Fecha); */

    $fichero .= "
    <tr>
        <td>".$reservasArray[$step]->IdReserva."</td>
        <td>".utf8_decode($reservasArray[$step]->Nombre)."</td>
        <td>".$reservasArray[$step]->Localizador."</td>
        <td>".$newInPutDate."</td>
        <td>".$newOutPutDate."</td>
        <td>".$reservasArray[$step]->Movil."</td>
        <td>".$reservasArray[$step]->IdPuertaEntrada."</td>
        <td>".$estado."</td>
    </tr>
    ";
}
  

$fichero .= "</tbody>
            </table>";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
/* header("Content-Type: application/vnd.ms-excel; charset=utf-8"); */
header("Content-Disposition: attachment; filename=reservas.xls");
header("Expires: 0");
echo $fichero;
} elseif ($reservasArray) {

    
    // Fecha de entrada con formato
    $newInPutDate = $reservasArray->Entrada;

    $newInPutDate = date("d-m-Y", strtotime($newInPutDate));

    // Fecha de salida con formato
    $newOutPutDate = $reservasArray->Salida;

    $newOutPutDate = date("d-m-Y", strtotime($newOutPutDate));



    if ($reservasArray->Estado == 0) {
        $estado = "Confirmada";
    } elseif ($reservasArray->Estado == 1) {
        $estado = "Anulada";
    } elseif ($reservasArray->Estado == 2) {
        $estado = "Entrada";
    } elseif ($reservasArray->Estado == 3) {
        $estado = "Salida";
    }
   
    
  /* $txt_fecha = new DateTime($array_dameOcupacionEntreFechas->Fecha); */

    $fichero .= "
    <tr>
        <td>".$reservasArray->IdReserva."</td>
        <td>".utf8_decode($reservasArray->Nombre)."</td>
        <td>".$reservasArray->Localizador."</td>
        <td>".$newInPutDate."</td>
        <td>".$newOutPutDate."</td>
        <td>".$reservasArray->Movil."</td>
        <td>".$reservasArray->IdPuertaEntrada."</td>
        <td>".$estado."</td>
    </tr>
    ";
  

$fichero .= "</tbody>
            </table>";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
/* header("Content-Type: application/vnd.ms-excel; charset=utf-8"); */
header("Content-Disposition: attachment; filename=reservas.xls");
header("Expires: 0");
echo $fichero;
}
?>