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

/* $email = 'bsabate@keypoint.es';

$emailFramg = explode('@', $email);

$nombreEmail = $emailFramg[0];
$tipoEmail = $emailFramg[1]; */


$emailOperador = 'mespana@keypoint.es';

/* $emailOperFramg = explode('@', $emailOperador);

$nombreOperEmail = $emailOperFramg[0];
$tipoOperEmail = $emailOperFramg[1]; */

/* var_dump($nombreOperEmail);
echo '<br>';
echo '<br>';
var_dump($tipoOperEmail);
die; */


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
                      <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"><p></p><p>A continuación le detallamos los detalles de la misma:</p>
                    </tr>
                    <tr>
                      <td width="16%">&nbsp;</td>
                      <td width="84%"></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="left" style="padding:0px; font-size:1.17em;">
                            <ul>
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
                        <p style="margin-top:30px">Feliz Estancia!</p>
                      </td>
                    </tr>
                    <tr>
                      <td colspan="2" align="left" style="padding-left:15px; font-size:.85em;"><br /><hr /><br />

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
            
                //Recipients
                $mail->setFrom('smartkeystation@keypoint.es', 'Smart Key Station');
                $mail->addAddress($emailOperador);
                /* $mail->addBCC('smartkeystation@gmail.com');   */                               //Add a recipient
                $mail->addReplyTo('noresponder@keypoint.es', 'No Resonder'); 
            
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Nuevo Usuario';
                $mail->Body    = $mensaje;
                $mail->send();

?>