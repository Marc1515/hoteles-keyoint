<?php
session_start();

require './../ws/ws_reservas/ws2.php';

require_once("./tcpdf/tcpdf.php");

$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];

/* if(isset($_POST['desde']) && isset($_POST['hasta']) && isset($_POST['idOperador']) && isset($_POST['estado'])) { */

  $desdeForm = $_GET['desde_disponiblidad'];
  $desde = date("Ymd", strtotime($desdeForm));


  $hastaForm = $_GET['hasta_disponiblidad'];
  $hasta = date("Ymd", strtotime($hastaForm));

// --- LLAMAR WS : DameOcupacionEntreFechas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOcupacionEntreFechas = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
$soap_result_DOEP = $client->DameOcupacionEntreFechas($parametros_dameOcupacionEntreFechas);

/* echo '<br>';
var_dump($parametros_dameOcupacionEntreFechas); */
$array_dameOcupacionEntreFechas = $soap_result_DOEP->DameOcupacionEntreFechasResult->DisponibleDia;

/* require './../ws/ws_reservas/ws_dameOcupacionEntreFechas.php'; */


$fichero = " <table>
                <thead>
                  <tr>
                    <th>Fecha</th>
                    <th>Libres</th>
                    <th>Reservadas</th>
                    <th>Total</th>
                  </tr>
                </thead>
                <tbody>";


    
if (is_array($array_dameOcupacionEntreFechas)) {

for ($step=0; $step<count($array_dameOcupacionEntreFechas); $step++){
   
    
  $txt_fecha = new DateTime($array_dameOcupacionEntreFechas[$step]->Fecha);

    $fichero .= "
    <tr>
        <td>".$txt_fecha->format('d/m/Y')."</th>
        <td>".number_format($array_dameOcupacionEntreFechas[$step]->Libres)."</td>
        <td>".number_format($array_dameOcupacionEntreFechas[$step]->Reservadas)."</td>
        <td>".number_format($array_dameOcupacionEntreFechas[$step]->Total)."</td>
    </tr>
    ";
}
  

$fichero .= "</tbody>
            </table>";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment; filename=disponiblidad.xls");
header("Expires: 0");
echo $fichero;

} elseif ($array_dameOcupacionEntreFechas) {
   
    
    $txt_fecha = new DateTime($array_dameOcupacionEntreFechas->Fecha);
  
      $fichero .= "
      <tr>
          <td>".$txt_fecha->format('d/m/Y')."</th>
          <td>".number_format($array_dameOcupacionEntreFechas->Libres)."</td>
          <td>".number_format($array_dameOcupacionEntreFechas->Reservadas)."</td>
          <td>".number_format($array_dameOcupacionEntreFechas->Total)."</td>
      </tr>
      ";

  
  $fichero .= "</tbody>
              </table>";
  
  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
  header("Content-Disposition: attachment; filename=disponiblidad.xls");
  header("Expires: 0");
  echo $fichero;

}

?>