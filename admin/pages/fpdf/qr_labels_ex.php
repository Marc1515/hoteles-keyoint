<?php
require('PDF_Label.php');

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

/*------------------------------------------------
To create the object, 2 possibilities:
either pass a custom format via an array
or use a built-in AVERY name
------------------------------------------------*/

// Example of custom format
// $pdf = new PDF_Label(array('paper-size'=>'A4', 'metric'=>'mm', 'marginLeft'=>1, 'marginTop'=>1, 'NX'=>2, 'NY'=>7, 'SpaceX'=>0, 'SpaceY'=>0, 'width'=>99, 'height'=>38, 'font-size'=>14));

// Standard format
$pdf = new PDF_Label('L7163');
$pdf->AddPage();
for ($i = 0; $i < count($soap_damemaquinas_result); $i++) {
    $text = sprintf("%s\n",$soap_damemaquinas_result[$i]['NSerie']);
	$pdf->Add_Label($soap_damemaquinas_result[$i]['NSerie']);
	$pdf->Add_Label($pdf->Image('test.png',10)); 	 
}
// Print labels
/*for($i=1;$i<=20;$i++) {
    $text = sprintf("%s\n%s\n%s\n%s %s, %s", "Laurent $i", 'Immeuble Toto', 'av. Fragonard', '06000', 'NICE', 'FRANCE');
    $pdf->Add_Label($text);
	$pdf->Image('test.png');
}*/
$pdf->Output();
?>