<?php

session_start();

if (!isset($_SESSION['hosvinlogin_user'])) {
	header("location:../index.php");
	exit();
}


// --- ESTABLECE CLASES IMPRESIÓN QR -------------------------------------------------------------------------------------------------------------------------------------------------->

define('CLASS_PATH','../../');

require_once(CLASS_PATH.'tcpdf/tcpdf.php');
require_once(CLASS_PATH."label/class.label.php");
require_once(CLASS_PATH."label/examples/class.labelCab.php");


// --- ESTABLECE LIBRERIAS EXTERNAS -------------------------------------------------------------------------------------------------------------------------------------------------->

require_once("../../../nusoap/lib/nusoap.php");


// --- ESTABLECER URL WEB SERVICES Y TOKEN ------------------------------------------------------------------------------------------------------------------------------------------>

$SoapClient = new nusoap_client('http://ws.infortur.com/gvWS/Service.asmx?WSDL', true);
$token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";

$data = array();


// --- IMPRIME QR MAQUINAS - TODAS LAS MAQUINAS ------------------------------------------------------------------------------------------------------------------------------------->

if ($_GET['envia'] == 'maq-todas') {

	$soap_damemaquinas = array('token'=>$token_ws, 'OrdenAoN'=>'A', 'textoBusquedaMarca'=>'', 'textoBusquedaSerie'=>'');
	$soap_damemaquinas_result = $SoapClient->call('DameTodasMaquinasJSON', $soap_damemaquinas);

	# Convierte de JSON a PHP Array
	$prueba = utf8_encode($soap_damemaquinas_result['DameTodasMaquinasJSONResult']);
	unset($soap_damemaquinas_result);
	$soap_damemaquinas_result = json_decode($prueba, TRUE, 512);
	
	$info = array();
	for ($i = 0; $i < count($soap_damemaquinas_result); $i++) {
		$info[$i]['cab'] = $soap_damemaquinas_result[$i]['NSerie'];
		$info[$i]['typeCAB'] = 'C128B';
	}
	
	for ($j = 0; $j < count($soap_damemaquinas_result); $j++) {
		array_push($data,$info);
	}
	
	$data = $info;
	
}


// --- IMPRIME QR MAQUINAS - UNA ----------------------------------------------------------------------------------------------------------------------------------------------------->

if ($_GET['envia'] == 'maq-una' || $_GET['envia'] == 'maqcli-una' ) {

	$soap_damemaquina = array('token'=>$token_ws, 'NumeroSerie'=>$_GET['serie']);
	$soap_damemaquina_result = $SoapClient->call('DameMaquinaPorNumeroSerieJSON', $soap_damemaquina);

	# Convierte de JSON a PHP Array
	$prueba = utf8_encode($soap_damemaquina_result['DameMaquinaPorNumeroSerieJSONResult']);
	unset($soap_damemaquina_result);
	$soap_damemaquina_result = json_decode($prueba, TRUE, 512);
	
	$info = array();
	$info[0]['cab'] = $soap_damemaquina_result['NSerie'];
	$info[0]['typeCAB'] = 'C128B';
	
	$data = $info;
	
}


// --- IMPRIME QR MAQUINAS CLIENTES - TODAS LAS MAQUINAS ----------------------------------------------------------------------------------------------------------------------------->

if ($_GET['envia'] == 'maqcli-todas') {

	$soap_damemaquinascli = array('token'=>$token_ws, 'IdCliente'=>$_GET['cli']);
	$soap_damemaquinascli_result = $SoapClient->call('DameMaquinasPorClienteJSON', $soap_damemaquinascli);

	# Convierte de JSON a PHP Array
	$prueba = utf8_encode($soap_damemaquinascli_result['DameMaquinasPorClienteJSONResult']);
	unset($soap_damemaquinascli_result);
	$soap_damemaquinascli_result = json_decode($prueba, TRUE, 512);
	
	$info = array();
	for ($i = 0; $i < count($soap_damemaquinascli_result); $i++) {
		$info[$i]['cab'] = $soap_damemaquinascli_result[$i]['NSerie'];
		$info[$i]['typeCAB'] = 'C128B';
	}
	
	for ($j = 0; $j < count($soap_damemaquinascli_result); $j++) {
		array_push($data,$info);
	}
	
	$data = $info;
	
}


/**
* Creation tableau de données
*/
// ------ $data = array();

/**
*
Codebare type in TCPDF : 
C39 : CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.
C39+ : CODE 39 with checksum
C39E : CODE 39 EXTENDED
C39E+ : CODE 39 EXTENDED + CHECKSUM
C93 : CODE 93 - USS-93
S25 : Standard 2 of 5
S25+ : Standard 2 of 5 + CHECKSUM
I25 : Interleaved 2 of 5
I25+ : Interleaved 2 of 5 + CHECKSUM
C128A : CODE 128 A
C128B : CODE 128 B
C128C : CODE 128 C
EAN2 : 2-Digits UPC-Based Extention
EAN5 : 5-Digits UPC-Based Extention
EAN8 : EAN 8
EAN13 : EAN 13
UPCA : UPC-A
UPCE : UPC-E
MSI : MSI (Variation of Plessey code)
MSI+ : MSI + CHECKSUM (modulo 11)
POSTNET : POSTNET
PLANET : PLANET
RMS4CC : RMS4CC (Royal Mail 4-state Customer Code) - CBC (Customer Bar Code)
KIX : KIX (Klant index - Customer index)
IMB: Intelligent Mail Barcode - Onecode - USPS-B-3200
CODABAR : CODABAR
CODE11 : CODE 11
*/

/*------$info = array();
for ($i = 0; $i < count($soap_damemaquinas_result); $i++) {
	$info[$i]['cab'] = $soap_damemaquinas_result[$i]['NSerie'];
	$info[$i]['typeCAB'] = 'C128B';
}*/

/*$info = array();
for ($i = 0; $i < 35; $i++) {
	$info[$i]['cab'] = '0000'.$i;
	$info[$i]['typeCAB'] = 'C128B';
}*/

/*$info = array(
		'cab'		=> 	'1234567890',
		'typeCAB'	=>	'C128B',
		);*/

// Création d'une ligne par étiquette (nbre d'etiquettes = 5)
/*-----for ($j=0; $j < count($soap_damemaquinas_result); $j++){
	array_push($data,$info);
}*/
/*echo '<pre>';
print_r($data);
echo '</pre>';
exit;*/
// -----$data = $info;

/**
*
Extrait de labels.xml :
	<label id="1">
		<name><![CDATA[Planche L4]]></name>
		<description><![CDATA[48 etiquettes - 45.7x21.2]]></description>
		<brand>Avery L6009</brand>
		<supplier/>
		<width>45.7</width>
		<height>21.2</height>
		<margin>2.5</margin>

		<sheet format="A4">
			<cols>4</cols>
			<rows>12</rows>
			<margins>
				<topmargin>21.41</topmargin>
				<leftmargin>9.75</leftmargin>
			</margins>
		</sheet>
	</label>
*/

// Establece id de etiqueta para tamaños en archivo labels.xml
$label_id = 10;

// Creation de l'objet label
$pdf = new labelCab( $label_id, $data , CLASS_PATH.'label/', '', true);

// Afficher les bordures
$pdf->border = true;

$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Infortur Software');
$pdf->SetTitle("Hostelera Vinaròs");
$pdf->SetSubject("Impresión de Etiquetas QR");

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(0);

$pdf->SetAutoPageBreak( true, 0);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  

/*************************/
// Création
$pdf->Addlabel();
/************************/
// Affichage
$pdf->Output("etiquetas.pdf", "I");

?>