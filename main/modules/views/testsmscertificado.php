<?php
require_once("mensatek.inc.php");
// Crear instancia Clase
$Mensatek=new cMensatek("Su correo electrónico registrado en Mensatek.com o SMSCertificado.es","Su contraseña");
$variables=array(
"Remitente"=>"Remitente",  //Remitente que aparece, puede ser n�mero de m�vil o texto (hasta 11 caracteres)
"Destinatarios"=>"34600000000", // Destinatarios del mensaje, si es m�s de 1 sep�relos por punto y coma
"Mensaje"=>"Esta es la notificación que se enviará, entregará y certificará", //Mensaje, si se env�an m�s de 160 caracteres se enviar� en varios mensajes
"Report"=>1,  //Report de entrega al correo electr�nico por defecto
"Fecha"=>"2016-09-30 10:20", //Si quiere programar el env�o
"VPD"=>3, // D�as de validez de la notificaci�n certificada
"VPH"=>2, // Horas de validez de la notificaci�n certificada
"VPM"=>1, // Minutos de validez de la notificaci�n certificada
"Contacto"=>"Empresa o Persona que envía la notificación",
"TelContacto"=>"Teléfono de contacto de la empresa o persona que envía",
"CifContacto"=>"CIF o NIF de la empresa o persona que envía",
"Resp"=>"JSON" //La librer�a se ha desarrollado con respustas en JSON por tanto no modificar este par�metro 
);


$res=$Mensatek->enviarCertificado($variables);

$msgid=0;
if ($res["Res"]<0) echo "Ha ocurrido un error al intentar enviar el mensaje, el c&oacute;digo de error es: ".$res["Res"]."<br/><br/>Las variables devueltas son:<br/><pre>".print_r($res,true)."</pre>";
else 
{
    echo "<br>Se enviaron ".$res["Res"]." mensajes a ".$res["Destinatarios"]." destinatarios y le restan ".$res["Cred"]." cr&eacute;ditos (se han utilizado ".$res["CreditosUsados"]." cr&eacute;ditos). El identidicador del mensaje es : ".$res["Msgid"]."<br/><br/>Las variables devueltas son:<br/><pre>".print_r($res,true)."</pre>";
    $msgid=$res["Msgid"];
}


// Se actualiza el valor de los cr�ditos restantes:
echo "<br> Obtenido en el resultado del env&iacute;o le restan ".$Mensatek->Creditos." cr&eacute;ditos";


// Ejemplo de obtendi�n directa de cr�ditos restantes en su cuenta, no es necesario (es redundante) ya que se obtienen tambi�n como resultado del env�o en la variable $res["Cred"]
echo "<br>Obtenido con la funci&oacute;n de consulta de cr&eacute;ditos le restan ".$Mensatek->creditos()." cr&eacute;ditos";


// Obtenci�n de un report. Es recomendable recibir en su web los resultados en tiempo real ya que obtendr� los estados de cada mensaje enviado en cuanto estos sean entregados.
// A�n as�, puede consultar el estado del mensaje de la siguiente forma $Mensatek->report($msgid) donde $msgid es el identificado de mensaje devuelto en la funci�n enviar.
if ($msgid>0) 
{
    $report=$Mensatek->reportCertificado($msgid);

    if ($report>0)
    {
        echo "<br/><br/>Resultado del mensaje ".$msgid." que tiene ".$report." destinatarios es:<br/>";

        foreach ($Mensatek->Res as $i=>$r)
        {
            echo "<br/>";
            foreach ($r as $variable=>$valor) echo $variable."=".$valor."---";
        }
    }
    else echo "<br/>Ha ocurrido un error al obtener el report del mensaje con identificador ".$msgid.". El error retornado es: ".$report;
}




?>