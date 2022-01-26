<?php
require_once("mensatek.inc.php");
// Crear instancia Clase
$Mensatek=new cMensatek("software@infortur.com","cachirulo");

$mensajeSMS = "SMART KEY STATION

Reservierungsnummer: ".$idReserva."
Locator: ".$localizador."
Pin: ".$pinEntrada."
Adresse: ".$url."

Glücklicher Aufenthalt!";

/* Folgen Sie den Anweisungen über den Touchscreen */

$variables=array(
"Remitente"=>"SMART KEY STATION",  //Remitente que aparece, puede ser n�mero de m�vil, fijo (formato internacional +346XXXXXXX) o texto (hasta 11 caracteres)
"Destinatarios"=>$movilConPrefijo, // Destinatarios del mensaje, si es m�s de 1 sep�relos por punto y coma
"Mensaje"=>$mensajeSMS, //Mensaje, si se env�an m�s de 160 caracteres se enviar� en varios mensajes
"Report"=>0,  //Report de entrega al correo electr�nico por defecto
"Descuento"=>0,  // Si utiliza descuento o no. Descuento=0 es sin descuento. Descuento=2 a�adir� (MENSATEK.ES) al final del mensaje, Descuento=1 pondr� MENSATEK.ES como remitente
"Fecha"=>"2015-09-30 10:20" //Si quiere programar el env�o
);


// Ejemplo de env�o
$res=$Mensatek->enviar($variables);
if ($res["Res"]>0)
{
    echo "<br/>Se enviaron ".$res["Res"]." mensajes y le restan ".$res["Cred"]." cr&eacute;ditos (se han utilizado ".$res["CreditosUsados"]." cr&eacute;ditos";
    echo "<br/>El resultado completo es:<pre>".print_r($res,true)."</pre>";

// Ejemplo de obtendi�n directa de cr�ditos restantes en su cuenta
    echo "<br>Le restan ".$Mensatek->Creditos." cr&eacute;ditos";
}
else echo "<br>Se ha producido el error ".$res["Res"]." consulte el significado en la documentaci�n de la API";




?>