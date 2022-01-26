<?

require_once("mensatek.inc.php");
// Crear instancia Clase
$Mensatek=new cMensatek("su correo registrado en MENSATEK.COM","Su contrase�a");

$variables=array(
"Fichero"=>"./ejemplopdf.pdf", //array con los ficheros incluidos en el mensaje (que se enviar�n como links)
"Nombre"=>"Renombrado.pdf"
    
);


// Ejemplo de carga del fichero
$res=$Mensatek->cargaFichero($variables);

echo "<br>Resultado de la carga de fichero:".$res;


// Ahora listo los ficheros que tengo (no hace falta pero para ver funcionamiento).
$res=$Mensatek->listaFicheros();
echo "<br>Resultado de listado de ficheros:<pre>".print_r($res,true)."</pre>";

//Puedo recorrer el array generado: foreach ($res as $i=>$Nombre) echo "<br/>Fichero:".$Nombre;

// Por �ltimo, env�o el mensaje con el fichero
$variables=array(
    "Remitente"=>"Remitente",  //Remitente que aparece, puede ser n�mero de m�vil o texto (hasta 11 caracteres)
    "Destinatarios"=>"34600000000", // Destinatarios del mensaje, si es m�s de 1 sep�relos por punto y coma
    "Mensaje"=>"Su mensaje de prueba. El fichero de pruebas, pulsa en el siguiente link para verlo: (FILE:Renombrado.pdf) y dentro de un QRCODE (QRCODE:Este es el mensaje que env�o en QRCODE con el fichero que he cargado: (FILE:Renombrado.pdf) pulsa sobre el link anterior para descargar)", //Mensaje, si se env�an m�s de 160 caracteres se enviar� en varios mensajes
    "Links"=>1, //Indicamos al sistema que hemos incluido ficheros, im�genes, links cortos, etc...
    "Fecha"=>"2017-01-10 10:00", // Fecha en la que se entregar� el mensaje.
);

$res=$Mensatek->enviar($variables);
if ($res["Res"]>0)
    echo "<br>Se enviaron ".$res["Res"]." mensajes y le restan ".$Mensatek->Creditos." cr&eacute;ditos";
else echo "<br/>El resultado de la petici&oacute;n es:<pre>".print_r($res,true)."</pre>";


?>