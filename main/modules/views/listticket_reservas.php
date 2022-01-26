<?php
session_start();
require_once("./tcpdf/tcpdf.php");


// --- ESTABLECER URL WEB SERVICES Y TOKEN -------------------------------------------------------------------------------------------------------------------------------------------------->
require './../ws/ws_reservas/ws2.php';

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



// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);


$reservasArray = $soap_result_DR->DameReservasPorOperadorResult->Reserva;



// --- LLAMAR WS : DameOperador ------------------------------------------------------------------------------------------------------------------>
require './../ws/ws_operadores/ws_dameOperador.php';


$tbl = '
<style>
  .tabla { border-bottom: solid 1px black; font-weight: bold; }
  .tabla2 { border-bottom: solid 1px #243D7B; }
  .izquierda { text-align:left }
  .derecha { text-align:right }
  .medio { text-align:center; background-color: #2b2f3a; color: #ffffff; border-top: 2px solid #000000; border-left: 2px solid #000000; border-right: 2px solid #000000; }
</style>

<h1 class="medio">'.$objeto_dameOperador->Nombre.'</h1>

<table width="100%" cellpadding="5" style="border: 2px solid #000000;">
  <thead>
    <tr class="tabla">
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; border-left-color: #000000; border-left-style:solid; border-left-width:2px; background-color: #2b2f3a; color: #ffffff">Nº Reserva</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Nombre</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Localizador</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Entrada</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Salida</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Movil</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Puerta</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; border-right-color: #000000; border-right-style:solid; border-right-width:2px; background-color: #2b2f3a; color: #ffffff">Estado</th>
    </tr>
  </thead>
  <tbody>';

  /* if((array)$soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->IdLocker){ // SÓLO 1 */
    // FECHA Y HORA


if (is_array($reservasArray)) {

    
    for($step=0; $step<count($reservasArray); $step++){


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

    /* $txt_fecha = new DateTime($soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->Fecha);

    $fecha = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas[$step]->Fecha)); */


    $tbl .= '
      <tr>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$reservasArray[$step]->IdReserva.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$reservasArray[$step]->Nombre.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$reservasArray[$step]->Localizador.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$newInPutDate.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$newOutPutDate.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$reservasArray[$step]->Movil.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$reservasArray[$step]->IdPuertaEntrada.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$estado.'</td>
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
$pdf->SetTitle('Lista Reservas');
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
$pdf->SetFont('helvetica', '', 10);

// add a page
$pdf->AddPage('L', 'A4');

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('list_tickets.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

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

    /* $txt_fecha = new DateTime($soap_dametickets_result->DameTicketsEntreFechasResult->Ticket->Fecha);

    $fecha = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas->Fecha)); */


    $tbl .= "
      <tr>
        <td>".$reservasArray->IdReserva."</td>
        <td>".$reservasArray->Nombre."</td>
        <td>".$reservasArray->Localizador."</td>
        <td>".$newInPutDate."</td>
        <td>".$newOutPutDate."</td>
        <td>".$reservasArray->Movil."</td>
        <td>".$reservasArray->IdPuertaEntrada."</td>
        <td>".$estado."</td>
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
$pdf->SetTitle('Lista Reservas');
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
$pdf->SetFont('helvetica', '', 8);

// add a page
$pdf->AddPage('L', 'A4');

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('list_tickets.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+


}

?>