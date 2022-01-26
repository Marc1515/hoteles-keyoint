<?php
session_start();
require_once("./tcpdf/tcpdf.php");


// --- ESTABLECER URL WEB SERVICES Y TOKEN ------------------------------------------------------------------------------------------------------------------------------------------>
require './../ws/ws_reservas/ws2.php';

require './../ws/ws_reservas/ws_dameOcupacionEntreFechas.php';

for ($step=0; $step<count($array_dameOcupacionEntreFechas); $step++) {

$tbl = '
<style>
  .tabla { border-bottom: solid 1px black; }
  .tabla2 { border-bottom: solid 1px #243D7B; }
  .derecha { text-align:right }
  .medio { text-align:center }
</style>

<table width="100%" cellpadding="5" style="border-collapse:collapse;">
  <thead>
    <tr>
      <th width="45%" class="tabla"><b>Fecha</b></th>
      <th width="15%" class="tabla medio"><b>Libres</b></th>
      <th width="20%" class="tabla derecha"><b>Reservadas</b></th>
      <th width="20%" class="tabla derecha"><b>Total</b></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td width="45%">'.$array_dameOcupacionEntreFechas[$step]->Fecha.'</td>
      <td width="15%" class="medio">'.$array_dameOcupacionEntreFechas[$step]->Libres.'</td>
      <td width="20%" class="derecha">'.$array_dameOcupacionEntreFechas[$step]->Reservadas.' €</td>
      <td width="20%" class="derecha">'.$array_dameOcupacionEntreFechas[$step]->Total.' €</td>
    </tr>
  </tbody>

</table>

'; }

// --- IMPRIMIR TIQUET ------------------------------------------------------------------------------------------------------------------------------------------------------->
// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {
  # Page header ( encabezado de página )
  public function Header() {
    # Set header data
    include('./includes/ws_consigna.php');    
    $soap_confticket = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
    $soap_confticket_result = $SoapClient_Consigna->__soapCall('DameConfiguracionTicket', array($soap_confticket));

    # Set logo
    //$image_file = K_PATH_IMAGES.'keypoint_logo20.png'; // logo está en tcpdf/examples/images
    //$this->Image($image_file, 2, 2, 25, '', 'PNG', '', 'T', false, 300, 'C', false, false, 0, false, false, false);
    # Set Texto 1
    $this->SetFont('helvetica', 'B', 7);
    $this->SetY(8);
    $this->Cell(0, 0, $soap_confticket_result->DameConfiguracionTicketResult->Texto1, 0, 2, 'C', 0, '', 0, false, 'C', 'M');
        
    # Set Texto 2
    $this->SetFont('helvetica', '', 5);
    $this->SetY(11);
    $this->Cell(0, 5, $soap_confticket_result->DameConfiguracionTicketResult->Texto2, 0, 2, 'C', 0, '', 0, false, 'C', 'M');

    # Set Texto 3
    $this->SetFont('helvetica', '', 5);
    $this->Cell(0, 5, $soap_confticket_result->DameConfiguracionTicketResult->Texto3, 0, 2, 'C', 0, '', 0, false, 'C', 'M');
  }

    # Page footer ( pie de página )
    public function Footer() {
      include('./includes/ws_consigna.php');
      $soap_confticket = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
      $soap_confticket_result = $SoapClient_Consigna->__soapCall('DameConfiguracionTicket', array($soap_confticket));

      $codigo = explode("-", $_GET['code']);
      include('./includes/ws_gestion.php');
      $soap_ticket = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'Ejercicio'=>$codigo[0], 'Serie'=>$codigo[1], 'Numero'=>$codigo[2]);
      $soap_ticket_result = $SoapClient_Gestion->__soapCall('DameTicket', array($soap_ticket));
      $soap_autoriza = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdTerminal'=>$soap_ticket_result->DameTicketResult->IdTerminal, 'IdTransaccion'=>$soap_ticket_result->DameTicketResult->IdTransaccion);
      $soap_autoriza_result = $SoapClient_Gestion->__soapCall('DameTransaccion', array($soap_autoriza));

      // Position at 10 mm from bottom
      $this->SetY(-10);
      // Set font
      $this->SetFont('helvetica', 'I', 3);
      // Page number
      //$this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
      $this->Cell(0, 3, 'Nº Transacción: '.$soap_autoriza_result->DameTransaccionResult->Codigo, 0, 2, 'L', 0, '', 0, false, 'C', 'M');
      //$this->Cell(0, 3, 'Nº Transacción: '.var_dump($soap_ticket_result), 0, 2, 'L', 0, '', 0, false, 'C', 'M');
      $this->Cell(0, 3, 'Nº Autorización: '.$soap_autoriza_result->DameTransaccionResult->Autorizacion, 0, 2, 'L', 0, '', 0, false, 'C', 'M');
      $this->SetFont('helvetica', 'I', 5);
      $this->Cell(0, 5, $soap_confticket_result->DameConfiguracionTicketResult->Texto4, 0, 2, 'C', 0, '', 0, false, 'C', 'M');
      $this->Cell(0, 5, $soap_confticket_result->DameConfiguracionTicketResult->Texto5, 0, 2, 'C', 0, '', 0, false, 'C', 'M');
      $this->Cell(0, 5, $soap_confticket_result->DameConfiguracionTicketResult->Texto6, 0, 2, 'C', 0, '', 0, false, 'C', 'M');
    }
}

// Create new PDF document
//$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf = new MYPDF('P','mm',array(80,100), true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('KeyPoint');
$pdf->SetTitle('Ticket');
$pdf->SetSubject('Resumen de compra');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(5, 18, 5);
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
$pdf->SetFont('helvetica', '', 5);

// add a page
//$pdf->AddPage('P', 'A7');
$pdf->AddPage();

$pdf->writeHTML($tbl, true, false, false, false, '');

//Close and output PDF document
$pdf->Output('ticket.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>