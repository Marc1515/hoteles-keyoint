<?php
require('fpdf.php');

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

//$pdf->Cell(95,10, $pdf->Image('test.png',95,10), 1,0,"C");
$image1 = "test.png";
for ($i = 0; $i < count($soap_damemaquinas_result); $i++) {
$pdf->Cell(95,30,$pdf->Image($image1, $pdf->GetX()+2, $pdf->GetY()+2, 20.78),1,0,'C');
$pdf->Cell(95,30,$pdf->Image($image1, $pdf->GetX()+2, $pdf->GetY()+2, 20.78),1,1,'C');
}
$pdf->Output();
?>