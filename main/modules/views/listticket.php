<?php
session_start();
require_once("./tcpdf/tcpdf.php");


// --- ESTABLECER URL WEB SERVICES Y TOKEN -------------------------------------------------------------------------------------------------------------------------------------------------->
require './../ws/ws_reservas/ws2.php';

$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['idLocker'];


$desdeForm = $_GET['desde_disponiblidad'];
$desde = date("Ymd", strtotime($desdeForm));


$hastaForm = $_GET['hasta_disponiblidad'];
$hasta = date("Ymd", strtotime($hastaForm));


// --- LLAMAR WS : DameOcupacionEntreFechas --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOcupacionEntreFechas = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
$soap_result_DOEP = $client->DameOcupacionEntreFechas($parametros_dameOcupacionEntreFechas);


$array_dameOcupacionEntreFechas = $soap_result_DOEP->DameOcupacionEntreFechasResult->DisponibleDia;


/* // --- LLAMAR WS : DameOcupacionEntreFechas ------------------------------------------------------------------------------------------------------------------>
require './../ws/ws_reservas/ws_dameOcupacionEntreFechas.php'; */

// --- LLAMAR WS : DameOperador ------------------------------------------------------------------------------------------------------------------>
require './../ws/ws_operadores/ws_dameOperador.php';


$tbl = '
<style>
  .tabla { border-bottom: solid 1px black; font-weight: bold; }
  .tabla2 { border-bottom: solid 1px #243D7B; }
  .izquierda { text-align:left }
  .derecha { text-align:right }
  .medio { text-align:center }
</style>

<h1 class="medio">'.$objeto_dameOperador->Nombre.'</h1>

<table width="100%" cellpadding="5" style="border-collapse:collapse;">
  <thead>
    <tr class="tabla">
      <th>Fecha</th>
      <th>Libres</th>
      <th>Reservadas</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody>';

  /* if((array)$soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->IdLocker){ // SÓLO 1 */
    // FECHA Y HORA

    /* var_dump($array_dameOcupacionEntreFechas); */

if(is_array($array_dameOcupacionEntreFechas)) {



    for($step=0; $step<count($array_dameOcupacionEntreFechas); $step++){
    $txt_fecha = new DateTime($soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->Fecha);

    $fecha = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas[$step]->Fecha));


    $tbl .= '
      <tr>
        <td>'.$fecha.'</td>
        <td>'.$array_dameOcupacionEntreFechas[$step]->Libres.'</td>
        <td>'.$array_dameOcupacionEntreFechas[$step]->Reservadas.'</td>
        <td>'.$array_dameOcupacionEntreFechas[$step]->Total.'</td>
      </tr>
    ';

    }

  $tbl .= '
    </tbody>
  </table>
  ';

// --- IMPRIMIR LISTADO ------------------------------------------------------------------------------------------------------------------------------------------------------->
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  # Page header ( encabezado de página )
  public function Header() {
    # Set header data
/*     $desde_get = new DateTime($_GET['fecha_desde']);
    $hasta_get = new DateTime($_GET['fecha_hasta']);
    $SoapClient = new SoapClient('http://localhost/consigna/gestionWS.asmx?WSDL', array('trace' => 1));
    $token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";
    $soap_dametickets = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'Desde'=>$desde_get->format('d/m/Y'), 'Hasta'=>$hasta_get->format('d/m/Y'));
    $soap_dametickets_result = $SoapClient->__soapCall('DameTicketsEntreFechas', array($soap_dametickets));
    if((array)$soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->IdLocker){ // SÓLO 1
      $cuantoshay = 'Mostrando 1 tiquet.';
    }else{
      $cuantoshay = 'Mostrando '.count((array)$soap_dametickets_result->DameTicketsEntreFechasResult->Ticket).' tiquets.';
    } */
    # Set logo
    //$image_file = K_PATH_IMAGES.'keypoint_logo20.png'; // logo está en tcpdf/examples/images
    //$this->Image($image_file, 2, 2, 25, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);

    # Set Texto 1
    $this->SetFont('helvetica', 'B', 16);
    $this->SetY(10);
    $this->Cell(0, 0, 'Disponiblidad de Puertas', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
        
    # Set Texto 2
    $this->SetFont('helvetica', 'I', 11);
    $this->SetY(18);
    /* $this->Cell(0, 12, 'Listado desde el '.$desde_get->format('d/m/Y').' hasta el '.$hasta_get->format('d/m/Y'), 0, 2, 'L', 0, '', 0, false, 'C', 'M'); */

    # Set Texto 3
    $this->SetFont('helvetica', 'I', 11);
    /* $this->Cell(0, 12, $cuantoshay, 0, 2, 'L', 0, '', 0, false, 'C', 'M'); */
  }

    # Page footer ( pie de página )
    public function Footer() {
      // Position at 10 mm from bottom
      $this->SetY(-20);
      // Set font
      $this->SetFont('helvetica', 'I', 10);
      // Page number
      $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
      $this->SetFont('helvetica', 'I', 14);
      //$this->Cell(0, 5, 'primera linia', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
      //$this->Cell(0, 5, 'segona linia', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
      //$this->Cell(0, 5, 'tercera linia', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('KeyPoint');
$pdf->SetTitle('Disponiblidad de Puertas');
$pdf->SetSubject('Tickets del '.$buscar_desde.' al '.$buscar_hasta);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(20, 35, 20);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font ( fuente cuerpo principal )
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage('P', 'A4');

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('list_tickets.pdf', 'I');

} elseif ($array_dameOcupacionEntreFechas) {

  $txt_fecha = new DateTime($soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->Fecha);

  $fecha = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas->Fecha));


  $tbl .= "
    <tr>
      <td>".$fecha."</td>
      <td>".$array_dameOcupacionEntreFechas->Libres."</td>
      <td>".$array_dameOcupacionEntreFechas->Reservadas."</td>
      <td>".$array_dameOcupacionEntreFechas->Total."</td>
    </tr>
  ";


  $tbl .= '
    </tbody>
  </table>
  ';

// --- IMPRIMIR LISTADO ------------------------------------------------------------------------------------------------------------------------------------------------------->
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  # Page header ( encabezado de página )
  public function Header() {
    # Set header data
/*     $desde_get = new DateTime($_GET['fecha_desde']);
    $hasta_get = new DateTime($_GET['fecha_hasta']);
    $SoapClient = new SoapClient('http://localhost/consigna/gestionWS.asmx?WSDL', array('trace' => 1));
    $token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";
    $soap_dametickets = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'Desde'=>$desde_get->format('d/m/Y'), 'Hasta'=>$hasta_get->format('d/m/Y'));
    $soap_dametickets_result = $SoapClient->__soapCall('DameTicketsEntreFechas', array($soap_dametickets));
    if((array)$soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->IdLocker){ // SÓLO 1
      $cuantoshay = 'Mostrando 1 tiquet.';
    }else{
      $cuantoshay = 'Mostrando '.count((array)$soap_dametickets_result->DameTicketsEntreFechasResult->Ticket).' tiquets.';
    } */
    # Set logo
    //$image_file = K_PATH_IMAGES.'keypoint_logo20.png'; // logo está en tcpdf/examples/images
    //$this->Image($image_file, 2, 2, 25, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);

    # Set Texto 1
    $this->SetFont('helvetica', 'B', 16);
    $this->SetY(10);
    $this->Cell(0, 0, 'Disponiblidad de Puertas', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
        
    # Set Texto 2
    $this->SetFont('helvetica', 'I', 11);
    $this->SetY(18);
    /* $this->Cell(0, 12, 'Listado desde el '.$desde_get->format('d/m/Y').' hasta el '.$hasta_get->format('d/m/Y'), 0, 2, 'L', 0, '', 0, false, 'C', 'M'); */

    # Set Texto 3
    $this->SetFont('helvetica', 'I', 11);
    /* $this->Cell(0, 12, $cuantoshay, 0, 2, 'L', 0, '', 0, false, 'C', 'M'); */
  }

    # Page footer ( pie de página )
    public function Footer() {
      // Position at 10 mm from bottom
      $this->SetY(-20);
      // Set font
      $this->SetFont('helvetica', 'I', 10);
      // Page number
      $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
      $this->SetFont('helvetica', 'I', 14);
      //$this->Cell(0, 5, 'primera linia', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
      //$this->Cell(0, 5, 'segona linia', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
      //$this->Cell(0, 5, 'tercera linia', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('KeyPoint');
$pdf->SetTitle('Disponiblidad de Puertas');
$pdf->SetSubject('Tickets del '.$buscar_desde.' al '.$buscar_hasta);

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(20, 35, 20);
//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font ( fuente cuerpo principal )
$pdf->SetFont('helvetica', '', 12);

// add a page
$pdf->AddPage('P', 'A4');

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('list_tickets.pdf', 'I');


}

//============================================================+
// END OF FILE
//============================================================+

?>