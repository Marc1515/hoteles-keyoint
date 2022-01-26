<?php

require_once("mensatek.inc.php");
// Crear instancia Clase
$Mensatek=new cMensatek("su correo registrado en MENSATEK.COM","Su contrase�a");

$variables=array(
"Remitente"=>"Remitente",  //Remitente que aparece, puede ser n�mero de m�vil o texto (hasta 11 caracteres)
"Destinatarios"=>"3460000000", // Destinatarios del mensaje, si es m�s de 1 sep�relos por punto y coma
"Mensaje"=>"Su mensaje de prueba.", //Mensaje, si se env�an m�s de 160 caracteres se enviar� en varios mensajes
"Fecha"=>"2017-01-15 10:00", // Fecha en la que se entregar� el mensaje.
);


// Ejemplo de env�o
$res=$Mensatek->enviar($variables);
if ($res["Res"]>0)
    echo "<br>Se enviaron ".$res["Res"]." mensajes y le restan ".$Mensatek->Creditos." cr&eacute;ditos";
else echo "<br/>El resultado de la petici&oacute;n es:<pre>".print_r($res,true)."</pre>";



// Ejemplo de obtenci�n de reports de env�o
/*
echo "<br>N&uacute;mero de reports en el mensaje:".$Mensatek->report($res["Msgid"]);
foreach ($Mensatek->Res as $res) echo "<br>Mensaje enviado en ".$res["Fecha"]." al tel&eacute;fono ".$res["Movil"]." lleg&oacute; en ".$res["Tiempo"]." segundos";
*/


?>