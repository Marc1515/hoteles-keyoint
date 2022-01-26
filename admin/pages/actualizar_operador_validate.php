<?php
session_start();
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../../../exemples/PHPMailer/src/Exception.php';
require '../../../exemples/PHPMailer/src/PHPMailer.php';
require '../../../exemples/PHPMailer/src/SMTP.php';
require_once("class.phpmailer.php");
require_once("class.smtp.php");

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}

if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

$idOperadorString = $_POST['idOperador'];
$idOperador = intval($idOperadorString);

$nombre = $_POST['nombre'];
$email = $_POST['email'];
$movil = $_POST['full_phone'];
$direccion = $_POST['direccion'];
$cp = $_POST['cp'];
$poblacion = $_POST['poblacion'];
$provincia = $_POST['provincia'];
$telefono = $_POST['telefono'];

include_once('../../../ws_include/ws_Keys_consigna.php');


if(isset($_POST)) {
    
  // --- LLAMAR WS : DameLocker 
  $parametros_dameLockerPorId = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
  $soap_result_DLPI = $SoapClient_KeysConsigna->DameLocker($parametros_dameLockerPorId);
  
  $objeto_dameLocker = $soap_result_DLPI->DameLockerResult;


	// --- LLAMAR WS : ActualizarOperador 
  $parametros_actualizarOperador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$idOperador, 'Nombre'=>$nombre, 'Direccion'=>$direccion, 'Cp'=>$cp, 'Poblacion'=>$poblacion, 'Provincia'=>$provincia, 'Email'=>$email, 'Telefono'=>$telefono, 'Movil'=>$movil);
  $soap_result_AO = $SoapClient_KeysConsigna->ActualizarOperador($parametros_actualizarOperador);

  $objeto_actualizarOperador = $soap_result_AO->ActualizarOperadorResult;

}

/*       if($objeto_actualizarOperador === true){
          $txt_msg = "Tu Operador ha sido actualizado para la cuenta <strong>".$nombre."</strong> en la plataforma de <strong>SMART KEY STATION</strong>, desde la que podrás gestionar tus taquillas.<br><br>
          Para acceder a ella, <a href='http://operadorsks.keypoint.es/'>PINCHA AQUÍ</a>";
          //Create an instance; passing `true` enables exceptions
          $plantilla = 
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
                    <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"><p>'.$txt_msg.'</p><p>Usuario y claves de acceso:</p>
                  </tr>
                  <tr>
                    <td width="16%">&nbsp;</td>
                    <td width="84%"></td>
                  </tr>
                  <tr>
                      <td colspan="2" align="left" style="padding:0px; font-size:1.17em;">
                          <ul>
                              <li><strong>Nº Operador: </strong>'.$idOperador.'</li>
                              <li><strong>Nombre: </strong>'.$nombre.'</li>
                              <li><strong>Dirección: </strong>'.$direccion.'</li>
                              <li><strong>Código Postal: </strong>'.$cp.'</li>
                              <li><strong>Población: </strong>'.$poblacion.'</li>
                              <li><strong>Provincia: </strong>'.$provincia.'</li>
                              <li><strong>Teléfono: </strong>'.$telefono.'</li>
                              <li><strong>Móvil: </strong>'.$movil.'</li>
                              <li><strong>Email: </strong>'.$email.'</li>
                          </ul>        
                      </td>
                  </tr>
                  <tr>
                    <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">
                      <br><br><p>Este PIN te permitirá abrir la puerta de su taquilla físicamente así como de forma virtual a través de la plataforma.</p><br>
                      <p>Tus taquillas ya están disponibles en SMART KEY STATION! <a href="'.$objeto_dameLocker->URLMaps.'">Localización</a>.</p><br>
                      </td>
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
          $mail->addAddress($email);
          $mail->addBCC('smartkeystation@gmail.com');                                 //Add a recipient
          $mail->addReplyTo('noresponder@keypoint.es', 'No Resonder'); 
      
          //Content
          $mail->isHTML(true);                                  //Set email format to HTML
          $mail->Subject = 'Nuevo Usuario';
          $mail->Body    = $plantilla;
          $mail->send();
          header("location:operadores.php");
      }else{
          header("location:operadores.php?error=1");
      }

} */




?>