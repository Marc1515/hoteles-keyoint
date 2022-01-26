<?php


//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
/* require 'vendor/autoload.php'; */

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require_once("class.phpmailer.php");
require_once("class.smtp.php");

    
    if (isset($_POST)) {
        
        $name = $_POST['nombre'];
        $nickName = $_POST['nombreUsuario'];
        $email = $_POST['example-email'];
        $emailOperador = $_SESSION['emailOperador'];
        $pwd = $_POST['pwd'];
        /* $pin = $_POST['pin']; */
        $operador = $_SESSION['nombreOperador'];
        $numOperador = $_POST['idop'];
        $ubiLocker = $_SESSION['ubiLocker'];

        switch($_SESSION['crearOActualizar']) {

          case 'crear':

            $txt_msg = "Tu usuario ha sido creado para la cuenta ".$operador." en la plataforma de SMART KEY STATION, desde la que podrás gestionar tus taquillas";

          break;


          case 'actualizar':

            $txt_msg = "Tu usuario ha sido actualizada para la cuenta ".$operador." en la plataforma de SMART KEY STATION, desde la que podrás gestionar tus taquillas";

          break;
          
        }
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);
        
        $txt_accion = '';
        $plantilla = 
        
        '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns="http://www.w3.org/1999/xhtml">
        <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        </head>
        <body style="background-color: #EFEFEF; font-family: Segoe, Helvetica, Verdana, sans-serif">
        <table width="70%" border="0" align="center" style="margin-left: auto; margin-right: auto; background-color: #FFFFFF; color: #000000; font-size: .9em; text-align: left;">
          <tbody>
            <tr>
              <td style="padding:10px;"><img src="http://infortur.com/img/keys/smart_key_logo_1.png" width="180"></td>
              <td style="padding:10px;" align="right"><img style=" opacity: 0; src="http://infortur.com/images/openroom_logo.jpg" width="180"> </td>
            </tr>
            <tr>
              <td colspan="2" style="padding:15px;" align="center"><br /><h2><strong>'.$txt_accion.'</strong>&nbsp;&nbsp;</h2><br /></td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;"><p>'.$txt_msg.'</p><p>Para acceder a ella, <a href="http://operadorsks.keypoint.es/">PINCHA AQUÍ</a>:</p>
              <br>
              <br>
            </tr>

            <tr>
              <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Usuario y claves de acceso:</td>
            </tr>
            <tr>
              <td width="16%">&nbsp;</td>
              <td width="84%"></td>
            </tr>
            <tr>
                <td colspan="2" align="left" style="padding:0px; font-size:1.17em;">
                    <ul>
                        <li><strong>Número Operador: </strong>'.$numOperador.'</li>
                        <li><strong>Nomre y Apellidos: </strong>'.$name.'</li>
                        <li><strong>Usuario: </strong>'.$nickName.'</li>
                        <li><strong>Email: </strong>'.$emailOperador.'</li>
                        <li><strong>Contraseña: </strong>'.$pwd.'</li>
                        <li><strong>PIN: </strong>'.$pin.'</li>
                    </ul>        
                </td>
            </tr>

            <tr>
              <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Este PIN te permitirá abrir la puerta de su taquilla físicamente así como de forma virtual a través de la plataforma.</td>
              <br>
            </tr>
            <tr>
              <td colspan="2" style="text-align:left; padding-left:15px; font-size:1.17em;">Tus taquillas ya están disponibles en <a href="'.$ubiLocker.'">SMART KEY STATION!</a></td>
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

                </div><br/>
              </td>
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

        
        
        try {
            //Server settings
//            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
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
            $mail->addAddress($email);                                 //Add a recipient
           /*  $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('info@example.com', 'Information');
            $mail->addCC('cc@example.com');
            $mail->addBCC('bcc@example.com'); */
        
            //Attachments
            /* $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name */
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Correo de contacto';
            $mail->Body    = $plantilla;
            $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            $mail->send();
            header("location:usuarios.php");

        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {

        return;

    }


