<?php
ini_set('display_errors','1');
ini_set('display_startup_errors','1');
error_reporting (E_ALL);

require_once("mensatek.inc.php");
// Crear instancia Clase
$Mensatek=new cMensatek("su usuario en Mensateks","su contraseña");
$ContenidoB64=base64_encode(file_get_contents("./ejemplopdf.pdf"));




$variables=array(
    "MedioComunicacion"=>2,


    "Documentos"=>'[
    {
       "Tipo":"PDF","Contenido":"'.$ContenidoB64.'",
       "Nombre":"CONDICIONES CONTRATO",
       "Aceptacion":1
    },
    {
       "Tipo":"PLANTILLA",
       "Plantilla":"37522-35",
       "Nombre":"MANDATO SEPA áéíóú",
       "Aceptacion":0
    },
    {
        "Tipo":"CHECKBOX",
        "Texto":"¿Nos da permiso para la utilización de sus datos personales con el único fin del perfeccionamiento del presente contrato?",
        "Inicial":"0",
        "FINAL":"1"
    },
    {
        "Tipo":"CHECKBOX",
        "Texto":"¿Nos da permiso para enviarle ofertas puntuales de nuestros productos basados en sus preferencias?. Podrá darse de baja en cualquier momento.",
        "Inicial":"0",
        "FINAL":"2"
    }
    ]',
    "Firmantes"=>'[
    {
        "Nombre":"Elias Barroso",
        "Orden":7,
        "Nif":"01234567U",
        "Email":"elias@monitor.es",
        "Telefono":"606404343"
    },
    {
        "Nombre":"El 2 Barroso",
        "Orden":7,
        "Nif":"875342617H",
        "Email":"elias2@monitor.es",
        "Telefono":"717700222"
    }
    ]',
    "Personalizacion"=>'{
       "referencia_del_mandato":"23456789",
       "nombre_de_la_empresa":"El nombre de la empresa",
       "cif_de_la_empresa":"B000343555",
       "codigo_posta":"28043",
       "poblacion":"Madrid",
       "provincia":"Madrid",
       "pais":"España",
       "bic":"el que sea",
       "Dirección de la Empresa":"Jaenar 27",
       "Código Postal":"28043",
       "País de la Empresa":"España"
    }',
    "Mensaje"=>"A la atención de [NOMBRE] con Nif [NIF], según lo acordado, le enviamos el contrato para su firma. Pulse en el siguiente link [LINK] para comenzar el proceso.",
    "Recordatorios"=>3, // tiempo en días entre recordatorios de firma.


);



// Ejemplo de env�o
$res=$Mensatek->enviarContrato($variables);
if ($res["Res"]>0)
    echo "<br>Se enviaron ".$res["Res"]." contratos y le restan ".$Mensatek->Creditos." cr&eacute;ditos, el id del contrato es: ".$res["ContratoId"];
else echo "<br/>El resultado de la petici&oacute;n es:<pre>".print_r($res,true)."</pre>";



// Ejemplo de obtenci�n de reports de env�o
/*
echo "<br>N&uacute;mero de reports en el mensaje:".$Mensatek->report($res["Msgid"]);
foreach ($Mensatek->Res as $res) echo "<br>Mensaje enviado en ".$res["Fecha"]." al tel&eacute;fono ".$res["Movil"]." lleg&oacute; en ".$res["Tiempo"]." segundos";
*/


?>