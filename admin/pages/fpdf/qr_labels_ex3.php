<?php
require('html2pdf.php');

// --- ESTABLECE LIBRERIAS EXTERNAS -------------------------------------------------------------------------------------------------------------------------------------------------->

require_once("../nusoap/lib/nusoap.php");


// --- ESTABLECER URL WEB SERVICES Y TOKEN ------------------------------------------------------------------------------------------------------------------------------------------>

$SoapClient = new nusoap_client('http://ws.infortur.com/gvWS/Service.asmx?WSDL', true);
$token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";


// --- LLAMAR WS : DAMETODASMAQUINASJSON -------------------------------------------------------------------------------------------------------------------------------------------->

$soap_damemaquinas = array('token'=>$token_ws, 'OrdenAoN'=>'A', 'textoBusquedaMarca'=>'', 'textoBusquedaSerie'=>'');
$soap_damemaquinas_result = $SoapClient->call('DameTodasMaquinasJSON', $soap_damemaquinas);

# Convierte de JSON a PHP Array
$prueba = utf8_encode($soap_damemaquinas_result['DameTodasMaquinasJSONResult']);
unset($soap_damemaquinas_result);
$soap_damemaquinas_result = json_decode($prueba, TRUE, 512);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);

$pdf=new PDF_HTML();
$pdf->SetFont('Arial','',12);
$pdf->AddPage();

$html = '<table>
<tbody>
<tr>
<td><img src="test.png"></td>
<td><img src="test.png"></td>
</tr>
</tbody>
</table>';
                        

$pdf->WriteHTML($html);
$pdf->Output();



/*if(isset($_POST['text']))
{
    $pdf=new PDF_HTML();
    $pdf->SetFont('Arial','',12);
    $pdf->AddPage();
    $pdf->WriteHTML($_POST['text']);
    $pdf->Output();
    exit;
}*/
?>