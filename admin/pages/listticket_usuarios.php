<?php
session_start();
require_once("./../includes/tcpdf/tcpdf.php");


// --- ESTABLECER URL WEB SERVICES Y TOKEN -------------------------------------------------------------------------------------------------------------------------------------------------->
require './../../../ws_include/ws_Keys_consigna.php';


$idOperadorForm = $_SESSION['id_operador'];
$idOperador = intval($idOperadorForm);

$idLocker = $_SESSION['IdLocker'];
$tbl='';

// --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$idLocker,  'OrdenAoN'=>'A');
$soap_result_DOs = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

$objeto_dameOperadores = $soap_result_DOs->DameOperadoresResult->Operador;

$tbl .= '
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
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; border-left-color: #000000; border-left-style:solid; border-left-width:2px; background-color: #2b2f3a; color: #ffffff">Operador</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Nombre</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Usuario</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Rol</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; background-color: #2b2f3a; color: #ffffff">Email</th>
      <th style="border-bottom-color: #000000; border-bottom-style:solid; border-bottom-width:2px; border-top-color: #000000; border-top-style:solid; border-top-width:2px; border-right-color: #000000; border-right-style:solid; border-right-width:2px; background-color: #2b2f3a; color: #ffffff">Movil</th>
    </tr>
  </thead>
  <tbody>';



if (!is_array($objeto_dameOperadores) && !is_null($objeto_dameOperadores)) {

  if ($objeto_dameOperadores->IdOperador !== 0) {

    // --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idOperador'=>$objeto_dameOperadores->IdOperador,  'OrdenAoN'=>'A', 'idrol'=>0);
    $soap_result_DU = $SoapClient_KeysConsigna->DameUsuarios($parametros_dameUsuarios);

    $objeto_dameUsuarios = $soap_result_DU->DameUsuariosResult->Usuario;

    $todosLosUsuarios = $objeto_dameUsuarios;


    // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker,  'IdOperador'=>$todosLosUsuarios->IdOperador);
    $soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);

    $objeto_dameOperador = $soap_result_DO->DameOperadorResult;


    if ($todosLosUsuarios->IdOperador === $objeto_dameOperador->IdOperador) {

      $nombreOperador = $objeto_dameOperador->Nombre;

    }


    // --- LLAMAR WS : DameRol --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameRol = array('token'=>$token_ws, 'IdLocker'=>$idLocker,  'IdRol'=>$todosLosUsuarios->IdRol);
    $soap_result_DO = $SoapClient_KeysConsigna->DameRol($parametros_dameRol);

    $objeto_dameRol = $soap_result_DO->DameRolResult;


    if ($todosLosUsuarios->IdRol === $objeto_dameRol->IdRol) {

      $rol = $objeto_dameRol->Nombre;

    }


    $tbl .= '
    <tr>
      <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$nombreOperador.'</td>
      <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios->Nombre.'</td>
      <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios->NombreUsuario.'</td>
      <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$rol.'</td>
      <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios->Email.'</td>
      <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios->Movil.'</td>
    </tr>
  ';

  $tbl .= '
  </tbody>
</table>';

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
    $this->Cell(0, 0, 'Todos los Usuarios', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
        
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

  }

} elseif (is_array($objeto_dameOperadores)) {

  $todosLosUsuarios = array();

  for ($step=0; $step<count($objeto_dameOperadores); $step++) {

    if ($objeto_dameOperadores[$step]->IdOperador !== 0) {

      // --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
      $parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idOperador'=>$objeto_dameOperadores[$step]->IdOperador,  'OrdenAoN'=>'A', 'idrol'=>0);
      $soap_result_DU = $SoapClient_KeysConsigna->DameUsuarios($parametros_dameUsuarios);

      $objeto_dameUsuarios = $soap_result_DU->DameUsuariosResult->Usuario;

      $todosLosUsuarios[$step] = $objeto_dameUsuarios;


      // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
      $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker,  'IdOperador'=>$todosLosUsuarios[$step]->IdOperador);
      $soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);

      $objeto_dameOperador = $soap_result_DO->DameOperadorResult;


      if ($todosLosUsuarios[$step]->IdOperador === $objeto_dameOperador->IdOperador) {

        $nombreOperador = $objeto_dameOperador->Nombre;

      }


      // --- LLAMAR WS : DameRol --------------------------------------------------------------------------------------------------------------------------------------------------->
      $parametros_dameRol = array('token'=>$token_ws, 'IdLocker'=>$idLocker,  'IdRol'=>$todosLosUsuarios[$step]->IdRol);
      $soap_result_DO = $SoapClient_KeysConsigna->DameRol($parametros_dameRol);

      $objeto_dameRol = $soap_result_DO->DameRolResult;


      if ($todosLosUsuarios[$step]->IdRol === $objeto_dameRol->IdRol) {

        $rol = $objeto_dameRol->Nombre;

      }




      $tbl .= '
      <tr>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$nombreOperador.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios[$step]->Nombre.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios[$step]->NombreUsuario.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$rol.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios[$step]->Email.'</td>
        <td style="border-bottom-color: #B8B8B8; border-bottom-style:solid; border-bottom-width:1px; border-top-color: #B8B8B8; border-top-style:solid; border-top-width:1px;">'.$todosLosUsuarios[$step]->Movil.'</td>
      </tr>
    ';

    }
    
  }
  

  $tbl .= '
  </tbody>
</table>';



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
    $this->Cell(0, 0, 'Todos los Usuarios', 0, 2, 'C', 0, '', 0, false, 'C', 'M');
        
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

} else {

  // Sin Operadores

}



?>