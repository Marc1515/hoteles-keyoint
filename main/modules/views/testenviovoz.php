<?php

require_once("mensatek.inc.php");
// Crear instancia Clase
$Mensatek=new cMensatek("su correo registrado en MENSATEK.COM","Su contrase�a");
$variables=array(
"Remitente"=>"349XXXXXXXX",  //Remitente que aparece, ATENCION: Debe ser un n�mero de remitente validado en MENSATEK
//"Destinatarios"=>"34900000000", // Destinatarios del mensaje, si es m�s de 1 sep�relos por punto y coma
    "Destinatarios"=>"34912345678",
    "Mensaje"=>"Su mensaje de prueba.", //Mensaje, si se env�an m�s de 160 caracteres se enviar� en varios mensajes, si quiere a�adir pausas inserte en el mensaje
                                        // (PAUSA:1) que har� una pausa de 1 segundo , el 1 puede modificarlo por el n�mero de segundos que desee.
                                        // Puede deletrear un PIN o palabra insertando (SPELL:1234) que deletrear� 1234 , cambie 1234 por el n�mero o palabra/frase que desee
"Lenguaje"=>"es-ES:1", //voz espa�ola mujer (ver posibilidades en la documentaci�n de la API)
"Reintentos"=>6, //N�mero de reintentos si no contestamn
"Intervalo"=>30, //Intervalo en minutos entre reintentos
"DetectarContestador"=>0, //Qu� hacer si hay un contestador 0, por defecto, espera la se�al y deja el mensaje en el contestador.
"TimeZone"=>"Europe/Madrid", //Zona horaria para los datos de FechaLimite, HoraInicioDiaria y HoraFinDiaria
"FechaLimite"=>"2050-01-01 10:00", //Fecha a partir de la cual ya no se intentar� entregar (aunque no se hayan terminado los reintentos
"HoraInicioDiaria"=>"10:00",// Hora de inicio de las llamadas cada d�a. No se realizar�n llamadas antes de esta hora. Referido a la zona horaria indicadad
"HoraFinDiaria"=>"22:00",// Hora de fin de las llamadas cada d�a. No se realizar�n llamadas despu�s de esta hora. Referido a la zona horaria indicadada
"Descuento"=>0,  // Si utiliza descuento o no. Descuento=0 es sin descuento. Descuento=1 a�adir� (enviado desde MENSATEK.ES) al final del mensaje
"Fecha"=>"2017-09-30 10:20", //Si quiere programar el env�o siempre seg�n zona horaria de Espa�a.
"Report"=>0,  //Report de entrega. Por defecto es 0. (los reports y registros de llamadas siempre est�n en su panel de usuario).
"Referencia"=>"MiReferencia", //Opcional: Si quieres incluir una referencia para recibir reports en la siguiente URL
"URLReport"=>"http://www.midominio.com/getreports.php", // Opcional: URL donde recibir�s, si lo deseas, los reports de cambios de estado en la llamada.
//"IVR"=>0, //Si hay men� IVR o solicitud de una OTP (one time password) o un PIN
//"MenuIVR"=>"" //Valores del men� si IVT es 1 � 2

    /**************************
     * EJEMPLO DE ENVIO DE MEN� IVR
*/
     "IVR"=>1,
    "MenuIVR"=>json_encode(array(
        "Locucion"=>utf8_encode("Pulse 1 para repetir el mensaje, 2 para aceptar la oferta, 3 para hablar con un comercial, 9 para darse de baja de nuestras ofertas"),
        1=>array(
            "Accion"=>1,
            "RepetirMenu"=>1
        ),
        2=>array(
            "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, la Accion 3 hace lo mismo pero enviando un correo a donde desee (el correo en el par�metro Valor)
            "Valor"=>"http://www.midominio.com/aceptacion.php",
            "RepetirMenu"=>0,
            "LocucionFinal"=>utf8_encode("Gracias por su inter�s, le enviaremos su pedido lo antes posible")
        ),
        3=>array(
            "Accion"=>4,
            "Valor"=>"349XXXXXXXXX", //tel�fono destino (donde responde el comercial)
            "RepetirMenu"=>0,
        ),
        9=>array(
            "Accion"=>5,
            "RepetirMenu"=>0,
            "LocucionFinal"=>utf8_encode("Le hemos dado de baja de nuestros sistemas, lamentamos su decisi�n y esperamos que vuelva a contactar con nosotros para volver a recibir nuestras sensacionales ofertas.")
        )
    )),

/*
     **************************/

    /**************************
     *
     * EJEMPLO DE SOLICITUD DE PIN/OTP AL DESTINATARIO
     * Puede haber dos formas de enviar un PIN a un destinatario para validaci�n. 1.- Envi�rselo por SMS o voz para que lo introduzca en un formulario de su web o
     * 2.- Mostrar el PIN/OTP en su web, enviar a su correo electr�nico (de esta forma valida de una vez el correo electr�nico y el n�mero de tel�fono) y solicitar que lo
     * introduzca mediante el teclado del tel�fono. �ste es un ejemplo del modelo 2. La forma 1 puede realizarse directamente sin men� IVR (simplemente enviando el mensaje con el PIN.

    "IVR"=>2,
    "MenuIVR"=>json_encode(
    array(
    "Locucion"=>utf8_encode("Por favor introduzca el PIN que le hemos enviado a su correo electr�nico"),
    "AccionPIN"=>2,
    "ValorAccionPIN"=>"http://www.midominio.com/enviopin.php",
    "LongPIN"=>4,
    "LocucionFinalPIN"=>utf8_encode("Gracias por introducir el PIN, si es correcto habr� validado el proceso.")

    )
    ),

     *
     **************************/
    /**************************
     *
     * EJEMPLO DE SOLICITUD DE PUNTUACI�N 1 a 5 A TRATO COMERCIAL/T�CNICO, ETC...

    "Mensaje"=>utf8_encode("Muchas gracias por utilizar nuestros servicios. Nos gustar�a conocer su feedback puntuando de 1 a 5 la atenci�n que ha recibido de nuestro agente comercial."),
    "IVR"=>1,
    "MenuIVR"=>json_encode(array(
    "Locucion"=>utf8_encode("Por favor, pulse de 1 a 5 siendo 1 muy malo y 5 excelente la puntuaci�n que le merece la atenci�n de nuestro agente comercial"),
    1=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/puntuacion.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por su colaboraci�n, lamentamos que sea una puntuaci�n tan baja, intentaremos revisar y verificar lo sucedido")
    ),
    2=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/puntuacion.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por su colaboraci�n, lamentamos que sea una puntuaci�n tan baja, intentaremos revisar y verificar lo sucedido. Su opini�n nos ayuda a mejorar")
    ),
    3=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/puntuacion.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por su colaboraci�n, Su opini�n nos ayuda a mejorar")
    ),
    4=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/puntuacion.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por su colaboraci�n, Su opini�n nos ayuda a mejorar. Estaremos encantados de volver a atenderle e intentaremos llegar a una puntuaci�n de 5")
    ),
     4=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/puntuacion.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por su colaboraci�n, Su opini�n nos ayuda mucho. Estaremos encantados de volver a atenderle e intentaremos seguir obteniendo la m�xima puntuaci�n.")
    ),
    )),

     *
     **************************/


    /**************************
     *
     * EJEMPLO DE VOTO POR VARIOS CANDIDATOS (2 en este ejemplo pero pueden ser, l�gicamente, m�s)

    "Mensaje"=>utf8_encode("Te llamamos para que votes por tu candidato favorito"),
    "IVR"=>1,
    "MenuIVR"=>json_encode(array(
    "Locucion"=>utf8_encode("Vota por tu candidato preferido. Pulsa uno para votar por Manuel o 2 para votar por Sonia"),
    1=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/voto.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por votar por Manuel, tu voto le ayudar� mucho. ")
    ),
    2=>array(
    "Accion"=>2, //Accion 2 es enviar petici�n a un script de su web, gestionamos autom�ticamente desde este script las puntuaciones de nuestros clientes (tambi�n podr�a enviarse a un email)
    "Valor"=>"http://www.midominio.com/voto.php",
    "RepetirMenu"=>0,
    "LocucionFinal"=>utf8_encode("Gracias por votar por Sonia, tu voto le ayudar� mucho.")
    ),

    )),

     *
     **************************/
);


// Ejemplo de env�o
$res=$Mensatek->enviarVOZ($variables);
if ($res["Res"]>0)
{
    echo "<br/>Se enviaron ".$res["Res"]." mensajes de voz y le restan ".$res["Cred"]." cr&eacute;ditos (se han utilizado ".$res["CreditosUsados"]." cr&eacute;ditos";
    echo "<br/>El resultado completo es:<pre>".print_r($res,true)."</pre>";

// Ejemplo de obtendi�n directa de cr�ditos restantes en su cuenta
    echo "<br>Le restan ".$Mensatek->Creditos." cr&eacute;ditos";
}
else echo "<br/>Se ha producido el error ".$res["Res"]." consulte el significado en la documentaci�n de la API";




?>