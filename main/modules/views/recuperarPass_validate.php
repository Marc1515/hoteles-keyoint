<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// --- ESTABLECER LIBRERIAS EXTERNAS ------------------------------------------------------------------------------------------------------------------------------------------------->

require './PHPMailer-master/src/Exception.php';
require './PHPMailer-master/src/PHPMailer.php';
require './PHPMailer-master/src/SMTP.php';
require_once("class.phpmailer.php");
require_once("class.smtp.php");

require '../../../../ws_include/ws_Keys_consigna.php';
require '../../../../ws_include/ws2_consignaConsigna.php';


$url = $_SERVER['SERVER_NAME'];
$urlArray = explode('.', $url);



// --- LLAMAR WS : DameLockerPorPrefijoWeb --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameLockerPorPrefijoWeb = array('token'=>$token_ws, 'PrefijoWeb'=>$urlArray[0]);
$soap_result_DLPPW = $client->DameLockerPorPrefijoWeb($parametros_dameLockerPorPrefijoWeb);


$objeto_dameLockerPorPrefijoWeb = $soap_result_DLPPW->DameLockerPorPrefijoWebResult;

$idLocker = $objeto_dameLockerPorPrefijoWeb->IdLocker;
$correo = $_POST['email'];


// --- LLAMAR WS : DameUsuarioPorEmail --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameUsuarioPorEmail = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'Email'=>$correo);
$soap_result_DUPE = $SoapClient_KeysConsigna->DameUsuarioPorEmail($parametros_dameUsuarioPorEmail);

$objeto_dameUsuarioPorEmail = $soap_result_DUPE->DameUsuarioPorEmailResult;

/* var_dump($objeto_dameUsuarioPorEmail);die; */

if (!is_null($objeto_dameUsuarioPorEmail)) {


  $idOperador = $objeto_dameUsuarioPorEmail->IdOperador;
  $idUsuario = $objeto_dameUsuarioPorEmail->IdUsuario;
  $nombre = $objeto_dameUsuarioPorEmail->Nombre;
  $nombreUsuario = $objeto_dameUsuarioPorEmail->NombreUsuario;
  $idRol = $objeto_dameUsuarioPorEmail->IdRol;
  $email = $objeto_dameUsuarioPorEmail->Email;
  $movil = $objeto_dameUsuarioPorEmail->Movil;
  $pinSeguridad = $objeto_dameUsuarioPorEmail->PinSeguridad;

  $pwd =  rand(0,999999);


  // --- LLAMAR WS : ActualizarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
  $parametros_actualizarUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdUsuario'=>$idUsuario, 'Nombre'=>$nombre, 'NombreUsuario'=>$nombreUsuario, 'Pwd'=>$pwd, 'IdRol'=>$idRol, 'Email'=>$email, 'Movil'=>$movil, 'PinSeguridad'=>$pinSeguridad);
  $soap_result_AU = $SoapClient_KeysConsigna->ActualizarUsuario($parametros_actualizarUsuario);

  $objeto_actualizarUsuario = $soap_result_AU->ActualizarUsuarioResult;


  // --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
  $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdUsuario'=>$idUsuario);
  $soap_result_DU = $SoapClient_KeysConsigna->DameUsuario($parametros_dameUsuario);

  $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;


  // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
  $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
  $soap_result_DO = $SoapClient_KeysConsigna->DameOperador($parametros_dameOperador);

  $objeto_dameOperador = $soap_result_DO->DameOperadorResult;



  //) --- LEE DATOS GET --------------------------------------------------------------------------------------------------------------------------------------------------------------->


  if(isset($_POST)) {

    
    $canal ='';
    
    $txt_accion = '';
    $txt_msg = "Estimado cliente,<br>
    Se ha generado una nueva contraseña para acceder a la plataforma de SMART KEY STATION.<br><br>";
    $txt_sub = '';


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
                        <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"><p>'.$txt_msg.'</p>
                      </tr>
                      <tr>
                          <td width="16%">&nbsp;</td>
                          <td width="84%"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Operador: <strong>'.$objeto_dameUsuario->IdOperador.'</strong></td>
                      </tr>
                      <tr>
                          <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Usuario: <strong>'.$objeto_dameUsuario->NombreUsuario.'</strong></td>
                      </tr>
                      <tr>
                          <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Nueva Contraseña: <strong>'.$objeto_dameUsuario->Pwd.'</strong></td>
                      </tr>
                      <tr>
                          <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"></td>
                      </tr>
                      <tr>
                        <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Para volver a iniciar sesión , <a href="http://operadorsks.keypoint.es/">PINCHA AQUÍ</a></td>
                      </tr>
                      <tr>
                        <td width="16%">&nbsp;</td>
                        <td width="84%"></td>
                      </tr>
                      <tr>
                      <td colspan="2" align="left" style="padding-left:15px; font-size:.85em;"><br /><hr /><br />
                      <div>
                        Smart Key Station<br />
                        Oficina Central<br />
                        Calle Montaña Clara, 5 Loc.4 38660 Fañabé, Adeje<br />
                        Tlf: +34 649 732 440   630 046 240<br />
                        smartkeystation@gmail.com<br /><br>
                        
                        Smart Key Station es un servicio de Tu Hotel al día. <a href="https://www.tuhotelaldia.com/politica-de-privacidad">Política de privacidad</a>. Este mensaje y cualquier archivo adjunto son confidenciales, siendo exclusivamente dirigidos a las personas que figuran en el encabezamiento. Si usted no es el destinatario de este mensaje y lo ha recibido por error,
                        deberá ser consciente de que cualquier uso, difusión o copia están absolutamente prohibidos.
                        
                        Según la Ley Orgánica 15/1999, de 13 de Septiembre de Protección de Datos Personales (LOPD) y la Ley 34/2002 de Servicios de la Sociedad de la Información y el Comercio Electrónico (LSSICE), su dirección de correo electrónico forma parte de nuestro fichero con el fin de mantener el contacto y comunicación profesional con usted o la empresa a la que representa.
                        En caso de que desee cancelar o modificar estos datos, le agradecemos nos lo comunique a través del correo electrónico info@tuhotelaldia.com 

                      </div><br /></td>
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
                  

                  $mail->AddAddress($correo);

                  
                      
                  /* $mail->Subject = $txt_sub."Localizador: ".$localizador; */
                  $mail->isHTML(true);
                  /* $mail->CharSet = 'UTF-8'; */
                  $mail->From = "smartkeystation@keypoint.es";
                  $mail->FromName = "Smart Key Station";
                  $mail->Subject = 'Contraseña restablecida en SMART KEY STATION';
                  /* $mail->AddCC("jmojica@infortur.com"); */
                  /* $mail->MsgHTML($mensaje); */
                  $mail->Body = $mensaje;
                  /*$mail->AddAddress("jmojica@infortur.com");				// Correo de reservas del hotel ( pruebas )*/
                  
                  $mail->send();

                  header('location:index.php');
                  exit;

  }

} else {

  header("location:index.php?error=3");
  die;

}
?>