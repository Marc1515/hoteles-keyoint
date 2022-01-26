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


if(isset($_POST['example-email']) && isset($_POST['localizador']) && isset($_POST['nombre']) && isset($_POST['operador']) && isset($_POST['entrada']) && isset($_POST['salida']) && isset($_POST['movilOperador']) && isset($_POST['pinEntrada']) && isset($_POST['ubiLocker'])) {

  $email = $_POST['example-email'];
  $nombre = $_POST['nombre'];
  $operador = $_POST['operador'];
  $entrada = $_POST['entrada'];
  $salida = $_POST['salida'];
  $movilOperador = $_POST['movilOperador'];
  $pin = $_POST['pinEntrada'];
  $ubicacion = $_POST['ubiLocker'];
  
  
  $entradaFormatada = date("d-m-Y", strtotime($entrada));
  $salidaFormatada = date("d-m-Y", strtotime($salida));
  
  $canal ='';
  
  $txt_accion = '';
  $txt_msg = "Dear Mr / Mrs ".$nombre.",<br>
  We send you directions to collect the keys of the accommodation booked with <strong>".$operador."</strong>.<br>
  Go to the SMART KEY STATION point located in this <a href='".$ubicacion."'>LOCATION</a> and follow the instructions through the screen.";
  $txt_sub = '';

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
                <style>
                  @font-face {
                      font-family: DeliciousRoman;
                      src: url(http://www.font-face.com/fonts/delicious/Delicious-Roman.otf);
                  }
                </style>
                </head>
                <body style="background-color: #EFEFEF;">
                <table width="70%" border="0" align="center" style="margin-left: auto; margin-right: auto; background-color: #FFFFFF; color: #000000; font-size: .9em; text-align: left;">
                  <tbody>
                    <tr style="margin-top: 20px; margin-bottom: 20px;">
                      <td style="padding:10px;"><img src="http://infortur.com/img/keys/smart_key_logo_1.png" width="180"></td>
                      <td style="padding:10px;" align="right"><img style=" opacity: 0; src="http://infortur.com/images/openroom_logo.jpg" width="180"> </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"><p>'.$txt_msg.'</p><p>Booking details:</p>
                    </tr>
                    <tr>
                      <td width="16%">&nbsp;</td>
                      <td width="84%"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" style="padding:0px; font-size:1.17em;">
                            <ul>
                                <li><strong>Reservation Number: </strong>'.$idReserva.'</li>
                                <li><strong>Name and Surname: </strong>'.$nombre.'</li>
                                <li><strong>Locator: </strong>'.$localizador.'</li>
                                <li><strong>Check in day: </strong>'.$entradaFormatada.'</li>
                                <li><strong>Check out day: </strong>'.$salidaFormatada.'</li>
                                <li><strong>PIN: </strong>'.$pin.'</li>
                                <li><strong>Contact: </strong>'.$movilOperador.'</li>
                            </ul>        
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">
                        <h3>Codigo QR</h3>
                        <img src="cid:qr_image" width="180"> 
                        </td>
                    </tr>
                    <tr>
                      <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">
                        <p style="margin-top:30px">Enjoy your holiday!</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" style="padding-left:15px; font-size:.85em;"><br /><hr /><br />
                        <div>
                        '.$operador.'<br />
                        '.$direccionOperador.'<br />
                        '.$poblacionOperador.'<br />
                        '.$telefonoOperador.'<br />
                        '.$emailOperador.'<br /></div></td>
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

                $mail = new PHPMailer(true);
                //Server settings
                //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                $mail->CharSet = "UTF-8";
                $mail->isSMTP();                                            //Send using SMTP
                $mail->Host       = 'smtp.dondominio.com';                     //Set the SMTP server to send through
                $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                $mail->Username   = 'smartkeystation@keypoint.es';                     //SMTP username
                $mail->Password   = 'Keypoint2021+';                               //SMTP password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
                $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            

                $mail->addEmbeddedImage($fileName, 'qr_image');

                //Recipients
                $mail->setFrom('smartkeystation@keypoint.es', 'Smart Key Station');
                $mail->addAddress($email);
                $mail->addBCC('smartkeystation@gmail.com');                                 //Add a recipient
                $mail->addReplyTo('noresponder@keypoint.es', 'No Responder'); 
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Your key is avaliable in SMART KEY STATION';
                $mail->Body    = $mensaje;
                $mail->send();
}
?>