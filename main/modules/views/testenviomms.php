<?php
require_once("mensatek.inc.php");
// Crear instancia Clase

$Mensatek=new cMensatek("su correo registrado en MENSATEK.COM","Su contrase�a");
$variables=array(
    "Remitente"=>"MiEmpresa", //N�mero o nombre de la empresa/persona que env�a.
    "Asunto"=>"Este es el asunto",  //Asunto del mensaje (obligatorio)
    "Destinatarios"=>"34601234567", // Destinatarios del mensaje, si es m�s de 1 sep�relos por punto y coma
    "SMIL"=>1, //0 formato SMIL, 1 formato enviar como adjuntos
    "adj1"=>"http://www.mensatek.com/pix/logo.jpg",
    "ini1"=>1, //Empieza en el segundo 1(no tiene sentido si SMIL=0)
    "dur1"=>5,//Duracion 5 segundos (no tiene sentido si SMIL=0)
    "adj2"=>"texto:Este es el texto de la diapositiva segunda",
    "ini2"=>5,//Empieza a mostrarse en el segundo 5 (no tiene sentido si SMIL=0)
    "dur2"=>5,//Duracion 5 segundos (no tiene sentido si SMIL=0)
    "adj3"=>"http://www.mensatek.com/pix/exito.jpg",
    "ini3"=>10,//Empieza a mostrarse en el segundo 5 (no tiene sentido si SMIL=0)
    "dur3"=>5,//Duracion 5 segundos (no tiene sentido si SMIL=0)
    "adj4"=>"texto:Y �ste es el texto que vamos a enviar en nuestra �ltima diapositiva",
    "ini4"=>15,//Empieza a mostrarse en el segundo 5 (no tiene sentido si SMIL=0)
    "dur4"=>5 //Duracion 5 segundos (no tiene sentido si SMIL=0)
);


// Ejemplo de env�o
$res=$Mensatek->enviarMMS($variables);
if ($res["Res"]>0)
{
    echo "<br/>Se enviaron ".$res["Res"]." MMS y le restan ".$res["Cred"]." cr&eacute;ditos (se han utilizado ".$res["CreditosUsados"]." cr&eacute;ditos";
    echo "<br/>El resultado completo es:<pre>".print_r($res,true)."</pre>";

// Ejemplo de obtendi�n directa de cr�ditos restantes en su cuenta
    echo "<br>Le restan ".$Mensatek->Creditos." cr&eacute;ditos";
}
else echo "<br>Se ha producido el error ".$res["Res"]." consulte el significado en la documentaci�n de la API";




?>