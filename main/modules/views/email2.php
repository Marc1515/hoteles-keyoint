<?php


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// --- ESTABLECER LIBRERIAS EXTERNAS ------------------------------------------------------------------------------------------------------------------------------------------------->

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';
require_once("class.phpmailer.php");
require_once("class.smtp.php");

//) --- LEE DATOS GET --------------------------------------------------------------------------------------------------------------------------------------------------------------->


$email = $_POST['Cor'];
$reserva = $_POST['Reserva'];
$localizador = $_POST['Loc'];
$nombre = $_POST['NomApe'];
$operador = $_POST['oper'];
$entrada = $_POST['entrada'];
$salida = $_POST['salida'];
$movilOperador = $_POST['movilOper'];
$pin = $_POST['pin'];
/* $canal = $_GET['canal'];
$accion = $_GET['accion']; */


$entradaFormatada = date("d-m-Y", strtotime($entrada));
$salidaFormatada = date("d-m-Y", strtotime($salida));

$canal ='';

$txt_accion = '';
$txt_msg = "Ha recibido una nueva reserva de <strong>".$operador."</strong>";;
$txt_sub = '';

require 'ws_generarQRTexto.php';

/* switch ($accion) {
    case "N" :
        $txt_accion = "¡ Ha recibido una nueva reserva !";
		$txt_msg = "Ha recibido una nueva reserva mediante Open Room";
		$txt_sub = "Nueva reserva OpenRoom - ";
        break;
    case "M" :
        $txt_accion = '<span style="color:#0000FF">Ha recibido una modificación de reserva</span>';
		$txt_msg = "Ha recibido una modificación de reserva mediante Open Room";
		$txt_sub = "Modificación de reserva OpenRoom - ";
        break;
    case "C" :
        $txt_accion = '<span style="color:#FF0000">Ha recibido una cancelación de reserva</span>';
		$txt_msg = "Ha recibido una cancelación de reserva mediante Open Room";
		$txt_sub = "Cancelación de reserva OpenRoom - ";
        break;
} */

// --- ENVIAR EMAIL NOTIFICACION RESERVA A HOTEL ----------------------------------------------------------------------------------------------------------------------------------->

$mensaje =
'<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body style="background-color: #EFEFEF; font-family: Segoe, Helvetica, Verdana, sans-serif">
<table width="70%" border="0" align="center" style="margin-left: auto; margin-right: auto; background-color: #FFFFFF; color: #000000; font-size: .9em; text-align: left;">
  <tbody>
    <tr style="margin-top: 20px;">
      <td style="padding:10px;"><img src="http://infortur.com/img/keys/smart_key_logo_1.png" width="180"></td>
      <td style="padding:10px;" align="right"><img style=" opacity: 0; src="http://infortur.com/images/openroom_logo.jpg" width="180"> </td>
    </tr>
    <tr>
      <td colspan="2" style="padding:15px;" align="center"><br /><h2><strong>'.$txt_accion.'</strong>&nbsp;&nbsp;</h2><br /></td>
    </tr>
    <tr>
      <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"><p>'.$txt_msg.'</p><p>A continuación le detallamos los detalles de la misma:</p>
    </tr>
    <tr>
      <td width="16%">&nbsp;</td>
      <td width="84%"></td>
    </tr>
    <tr>
        <td colspan="2" align="left" style="padding:0px; font-size:1.17em;">
            <ul>
                <li><strong>Nombre y Apellidos: </strong>'.$nombre.'</li>
                <li><strong>Localizador: </strong>'.$localizador.'</li>
                <li><strong>Entrada: </strong>'.$entradaFormatada.'</li>
                <li><strong>Salida: </strong>'.$salidaFormatada.'</li>
                <li><strong>PIN: </strong>'.$pin.'</li>
                <li><strong>Contacto: </strong>+'.$movilOperador.'</li>
            </ul>        
        </td>
    </tr>
    <tr>
        <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">
        <h3>Codigo QR</h3>
        '.$imagenQR.'
        </td>
    </tr>
    <tr>
      <td colspan="2" align="left" style="padding-left:15px; font-size:.85em;"><br /><hr /><br />
        <div>
		Keypoint Solutions, S.L.<br />
		C/. Saragossa, 6 - 43540 - Sant Carles de la Ràpita (Tarragona)<br />
		Tlf: +34 977 74 50 02 - Fax: +34 877 05 39 27<br />
		<a href="mailto:software@infortur.com">software@infortur.com</a> - <a href="https://www.infortur.com">www.infortur.com</a></div><br /></td>
    </tr>
    <tr>
      <td colspan="2" align="center" style="font-size:.85em;"></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
  </tbody>
</table>

<div style="text-align: center;"></div>	

</body>
</html>
';

# Correo a Cliente		
$mail = new PHPMailer();
$mail->CharSet = "UTF-8";
$mail->IsSMTP();								// telling the class to use SMTP
$mail->Host = "smtp.dondominio.com";				// SMTP server
$mail->SMTPAuth = true;							// Enable SMTP authentication
$mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
$mail->Username = "smartkeystation@keypoint.es";	// SMTP account username
$mail->Password = "Keypoint2021+";				// SMTP account password


$mail->AddAddress($email);	// Correo de reservas del hotel

	
/* $mail->Subject = $txt_sub."Localizador: ".$localizador; */
$mail->isHTML(true);
/* $mail->CharSet = 'UTF-8'; */
$mail->From = "smartkeystation@keypoint.es";
$mail->FromName = "Smart Key Station";
$mail->Subject = 'Reserva Locker Smart Key Station';
/* $mail->AddCC("jmojica@infortur.com"); */
/* $mail->MsgHTML($mensaje); */
$mail->Body = $mensaje;
/*$mail->AddAddress("jmojica@infortur.com");				// Correo de reservas del hotel ( pruebas )*/

$mail->send();
	
/* if (!$mail->Send()) {
	/* header("Location: error.php?res=mail&amp;error=".$mail->ErrorInfo."");
	echo "Mailer Error: " . $mail->ErrorInfo;
	exit();
} */

# Correo a Infortur		
/* $mail = new PHPMailer();
$mail->CharSet = "UTF-8";
$mail->IsSMTP();								// telling the class to use SMTP
$mail->Host = "smtp.dondominio.com";				// SMTP server
$mail->SMTPAuth = true;							// Enable SMTP authentication
$mail->Port = 25;								// set the SMTP port for the GMAIL server
$mail->Username = "smartkeystation@keypoint.es";	// SMTP account username
$mail->Password = "Keypoint2021+";				// SMTP account password
	
$mail->Subject = $txt_sub."Localizador: ".$localizador." (".$email." )";
$mail->From = "smartkeystation@keypoint.es";
$mail->FromName = "Infortur";
// $mail->AddCC("jmojica@infortur.com"); 
$mail->MsgHTML($mensaje);
$mail->AddAddress("software@infortur.com");				// Correo de reservas del hotel ( pruebas ) */
//$mail->AddAddress($email);	// Correo de reservas del hotel
	
/* if (!$mail->Send()) {
	// header("Location: error.php?res=mail&amp;error=".$mail->ErrorInfo.""); 
	echo "Mailer Error: " . $mail->ErrorInfo;
	exit();
} */

?>