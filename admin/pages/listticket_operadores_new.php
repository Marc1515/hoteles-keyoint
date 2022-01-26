<?php
session_start();

/* if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../../index.php");
	exit();
}
error_reporting(0);  */

// --- ESTABLECE LIBRERIAS EXTERNAS -------------------------------------------------------------------------------------------------------------------------------------------------->

require './../nusoap/lib/nusoap.php';

die;
require 'tcpdflabels/tcpdf/tcpdf.php';


// --- ESTABLECER URL WEB SERVICES Y TOKEN -------------------------------------------------------------------------------------------------------------------------------------------------->
$SoapClient_KeysConsigna = new SoapClient('http://localhost/keysWS/consignaWS.asmx?WSDL', array('trace' => 1));
$token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";

// --- OBTIENE DATOS ---------------------------------------------------------------------------------------------------------------------------------------------------------------->

// --- LLAMAR WS : DameOperadores  --------------------------------------------------------------------------------------------------------------------
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'N');
$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

$objeto_dameOperadores = $soap_result_DO->DameOperadoresResult->Operador;

/*echo '<pre>';
print_r($soap_damelicenciasporhotel_result);
echo '</pre>';
exit();*/


// --- CREA TABLA PARA IMPRESIÓN ---------------------------------------------------------------------------------------------------------------------------------------------------->

$tbl = '
<style>
.tabla { border-bottom: solid 1px black; }
.tabla2 { border-bottom: solid 1px #243D7B; }
</style>
<table width="100%" cellpadding="2" class="table table-condensed" style="border-collapse:collapse;">
	<thead>
	<tr>
		<th width="25%" class="tabla"><b>Nº Operador</b></th>
		<th width="25%" class="tabla"><b>Nombre</b></th>
		<th width="25%" class="tabla"><b>Email</b></th>
		<th width="25%" class="tabla"><b>Movil</b></th>
	</tr>
	</thead>
	<tbody>';

    if (!is_array($objeto_dameOperadores) && !is_null($objeto_dameOperadores)) {

        $tbl .= "
        <tr>
            <td width='25%'>".$objeto_dameOperadores->IdOperador."</td>
            <td width='25%'>".$objeto_dameOperadores->Nombre."</td>
            <td width='25%'>".$objeto_dameOperadores->Email."</td>
            <td width='25%'>".$objeto_dameOperadores->Movil."</td>
        </tr>";



    } elseif (is_array($objeto_dameOperadores)) {
  
        for ($step=0; $step<count($objeto_dameOperadores); $step++) {		
            
            $tbl .= "
            <tr>
                <td width='25%'>".$objeto_dameOperadores[$step]->IdOperador."</td>
                <td width='25%'>".$objeto_dameOperadores[$step]->Nombre."</td>
                <td width='25%'>".$objeto_dameOperadores[$step]->Email."</td>
                <td width='25%'>".$objeto_dameOperadores[$step]->Movil."</td>
            </tr>";
        }

    }
    
$tbl .= '
	</tbody>
</table>';


// --- IMPRIME INFORME -------------------------------------------------------------------------------------------------------------------------------------------------------------->

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    # Page header ( encabezado de página )
    public function Header() {
		# Set header data
		$txt_header = $_POST['inf_idhotel']. ' ' .$_POST['inf_nomhotel'];
		$fecha = date('d/M/Y');
		# Set logo
		$image_file = K_PATH_IMAGES.'logo_infortur.jpg'; // logo está en tcpdf/examples/images
        $this->Image($image_file, 10, 10, 35, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        # Set title & font
        $this->SetFont('helvetica', 'B', 12);
        $this->Cell(0, 11, 'LICENCIAS POR HOTEL', 0, true, 'R', 0, '', 0, false, 'M', 'M');
		# Set subtitle & font
		$this->SetFont('helvetica', 'B', 12);
		$this->Cell(0, 11, $txt_header, 0, true, 'R', 0, '', 0, false, 'M', 'M');
		$this->Cell(0, 11, $fecha, 0, false, 'R', 0, '', 0, false, 'M', 'M');
    }

    # Page footer ( pie de página )
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

// Create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Infortur');
$pdf->SetTitle('Informe de licencias por hotel');
$pdf->SetSubject('Informes');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
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
$pdf->AddPage('L');

//$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);
//$pdf->Write(0, '', '', 0, 'L', true, 0, false, false, 0);

// set some text to print
/*$txt = <<<EOD

TCPDF Example 003

Custom page header and footer are defined by extending the TCPDF class and overriding the Header() and Footer() methods.
EOD;*/

//$pdf->writeHTML('<hr>',true,false,false,false,"");
$pdf->writeHTML($tbl, true, false, false, false, '');

// print a block of text using Write()
//$pdf->Write(0, $txt, '', 0, 'L', true, 0, false, false, 0);

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output('listTicket_operadores.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

?>
