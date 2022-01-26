<?php
////////////////////////////////////////////////////
// CONEXI�N A MENSATEK POR HTTP/S DESDE PHP
// versi�n PHP 
// versi�n API 5.5
// Primera version 5 Mayo 2005
// �ltima modificaci�n 27 Enero 2017
////////////////////////////////////////////////////


// El puerto por defecto es 3377, se usa para evitar influencia de proxies 
// si no puede utilizar el 3377 por problemas de firewall utilice el puerto 80

/////////////////////////////////////////////////////////////////
// Definiciones necesarias
/////////////////////////////////////////////////////////////////
//PARA CONECTARSE SIN SSL
//define('G_PUERTO',80); //Si tiene un firewall que no deja comunicaciones en el 3377, puede utilizar el puerto 80
//define('G_PUERTO',3377); // si lo desea, puede utilizar el puerto 3377
//define('G_DIR','http://api.mensatek.com');
//PARA CONECTARSE EN FORMA SEGURA SSL
define('G_PUERTO',443); //Si tiene un firewall que no deja comunicaciones en el 3378, puede utilizar el puerto 443
//define('G_PUERTO',3378); // si lo desea, puede utilizar el puerto 3378

 
class cMensatek
{
    var $_correo;
    var $_pass;
    var $Res=array();
    var $Creditos=0;
    var $Resultado=0;
    var $id=0;
    
    // Constructor
    function __construct($correo,$pass)
    {
        $this->_correo=$correo;
        $this->_pass=$pass;

    }
    

    //////////////////////////////////////////////////////
    // OBTIENE EL N�MERO DE CR�DITOS RESTANTES DEL USUARIO
    // DEVUELVE:
    //  Float en $this->Creditos correspondiente al n�mero de cr�ditos en la cuenta.
    ///////////////////////////////////////////////////////

    function creditos()
    {
       $res=$this->_conecta(array("Cred"=>0),"/v5/creditos.php");
       $this->Creditos=$res["Cred"];
       return $this->Creditos;
    }

    //////////////////////////////////////////////////////
    // ENV�A MENSAJES A M�VILES
    // - Valores: Array con todas o alguna de las siguientes variables
    //      Destinatarios: M�vil/M�viles al/a los que se env�a el mensaje, de la forma PrefijoTelefono (Ej:346000000 � para varios destinatarios
    //           346000000;3519760000;443450000) separados por punto y coma ';'
    //      Mensaje: Mensaje que se env�a
    //      Remitente: Es el tel�fono, nombre de la empresa o persona que env�a (aparecer� en el tel�fono destinatario como 'Mensaje de : Remitente)
    //            ATENCI�N: Si es alfanum�rico el M�ximo es de 11 caracteres.
    //      Fecha: Fecha en la que queda progrmado el env�o, el mensaje se enviar� en esa fecha. Por defecto "" que significa enviar ahora. Formato: A�o-Mes-dia hora:minuto
    //          La referencia horaria es GMT+1 (Zona horaria de Espa�a)
    //      Flash: 0=No, 1=S�
    //      Report: 0=No, 1=S�  (1=se env�a report de entrega al correo electr�nico)
    //      Descuento: 0=No, 1=S� 
    //      EmailReport: Correo electr�nico que recibir� el report. Si no se utiliza y se ha seleccionado Report=1, se enviar� al correo registrado como usuario en MENSATEK.(ATENCI�N: Debe ser un correo v�lido). 
    //                   ::Atenci�n::Si desea que se env�e un correo de report personalizado con su nombre de dominio contacte con el Departamento de Soporte
    //      Descuento: Se har� un 10% de descuento (en cr�ditos) si incluye en el mensaje (MENSATEK.ES)
    //      Ficheros: Ver especificaci�n en el PDF se trata de un array con los ficheros incluidos en el mensaje (en forma de links.
    //              ejemplo: array("0001" => "/tmp/elfichero2.pdf","0002"=>"/tmp/elfichero2.pdf")
    //                       y el mensaje ser�a algo como : "Hola, te envio la factura (FILE-0001) y el contrato (FILE-0002)"
    // DEVUELVE: Un array
    //  Res: Int
    //      >0 correspondiente al n�mero de mensajes enviados.
    //      -1 Error de autenticaci�n
    //      -2 no hay cr�ditos suficientes.
    //      -3 Error en los datos de la llamada
    //     -50 Intenta enviar un fichero que no encontramos. Aseg�rese de escribir todo el path.
    //  Msgid: Int
    //      identificador del mensaje enviado para utilizar en el report
    //  Cred: Float
    //      n�mero de cr�ditos que le restan.
    ///////////////////////////////////////////////////////

    function enviar($Valores)
    {
       $res=$this->_conecta($Valores,"/v5/enviar.php");
       $this->Creditos=$res["Cred"];
       $this->id=$res["Msgid"];
       return $res;
    }

    //////////////////////////////////////////////////////
    // ENV�A MENSAJES MMS A M�VILES
    // - Valores: Array con todas o alguna de las siguientes variables
    //      Destinatarios: M�vil/M�viles al/a los que se env�a el mensaje, de la forma PrefijoTelefono (Ej:346000000 � para varios destinatarios
    //           346000000;3519760000;443450000) separados por punto y coma ';'
    //      El contenido se env�a de una de las siguientes formas:
    //          adjN, iniN, durN (donde N es 1, 2, 3 , 4.... para diferenciar el adjunto)
    //              adjN: URL de descarga del fichero (imagen, v�deo, sonido,...)
    //              iniN: segundo en el que se empieza a mostrar/reproducir el fichero multimedia o imagen
    //              durN: duraci�n en segundos que se mostrar�.
    //              Por ejemplo: adj1=http://miservidor/carpeta/dibujo.jpg&ini1=1&dur1=5

    //          o tambi�n como archivos adjuntos:
    //          archivos=texto:texto1_del_mms|url1|url2|texto:texto2_del_mms

    //      Asunto: (obligatorio) Es el asunto del MMS (el texto que se ver� primero)
    //
    // DEVUELVE: Un array
    //  Res: Int
    //      >0 correspondiente al n�mero de mensajes enviados.
    //      -1 Error de autenticaci�n
    //      -2 no hay cr�ditos suficientes.
    //      -3 Error en los datos de la llamada
    //      -4 tel�fono/s no v�lido/s
    //      -5 Tipo de Contenido no admitido o no existe uno de los archivox
    //      -6 El MMS est� vac�o (si se env�a como SMIL) / No hay par�metro archivos si no se env�a como SMIL
    //      -7 No se ha especificado el par�metro Asunto (es obligatorio)
    //      -8 En cada petici�n debe haber un m�ximo de 1000 destinatarios
    //      -9 El tama�o del MMS excede el m�ximo de 300kb
    //     -10 El REemitente no puede estar vac�o
    //     -11 Error en los archivos multimedia incluidos
    //
    //  Msgid: Int
    //      identificador del mensaje enviado para utilizar en el report
    //  Cred: Float
    //      n�mero de cr�ditos que le restan.
    ///////////////////////////////////////////////////////

    function enviarMMS($Valores)
    {
        $res=$this->_conecta($Valores,"/v5/mmshttp.php");
        $this->Creditos=$res["Cred"];
        $this->id=$res["Msgid"];
        return $res;
    }

    //////////////////////////////////////////////////////
    // ENV�A MENSAJES SMS CERTIFICADOS A M�VILES
    // - Valores: Array con todas o alguna de las siguientes variables
    //      Destinatarios: M�vil/M�viles al/a los que se env�a el mensaje, de la forma PrefijoTelefono (Ej:346000000 � para varios destinatarios
    //           346000000;3519760000;443450000) separados por punto y coma ';'
    //      Mensaje: Mensaje que se env�a
    //      Remitente: Es el tel�fono, nombre de la empresa o persona que env�a (aparecer� en el tel�fono destinatario como 'Mensaje de : Remitente)
    //            ATENCI�N: Si es alfanum�rico el M�ximo es de 11 caracteres.
    //      Fecha: Fecha en la que queda progrmado el env�o, el mensaje se enviar� en esa fecha. Por defecto "" que significa enviar ahora. Formato: A�o-Mes-dia hora:minuto
    //          La referencia horaria es GMT+1 (Zona horaria de Espa�a

    //       VPD: Periodo de validez en d�as (0 a 20), se intentar� la entrega durante VPD d�as VPH horas y VPM minutos tras lo cual, el mensaje expirar� y ya no se intentar� la 8 entrega.
    //       VPH: Periodo de validez en horas (0 a 23), se intentar� la entrega durante VPD d�as VPH horas y VPM minutos tras lo cual, el mensaje expirar� y ya no se intentar� la entrega.
    //       VPM: Periodo de validez en minutos (0 a 59), se intentar� la entrega durante VPD d�as VPH horas y VPM minutos tras lo cual, el mensaje expirar� y ya no se intentar� la entrega.
    //       Contacto: Nombre de la Empresa o Persona que env�a la notificaci�n certificada. El objeto es que el receptor pueda consultar qui�n le env�a la notificaci�n y pueda contactar.
    //       TelContacto: Tel�fono de contacto de la Empresa o Persona que env�a la notificaci�n certificada. El objeto es que el receptor pueda consultar qui�n le env�a la notificaci�n y pueda contactar.
    //       Report: 0=No, 1=S� (recibir report por correo electr�nico o por peticiones web si se ha solicitado)
    //       EmailReport: Correo electr�nico que recibir� el report. Si no se utiliza y se ha seleccionado Report=1, se enviar� al correo registrado como usuario en MENSATEK.(ATENCI�N: Debe ser un correo v�lido).
    //       Referencia: Par�metro que se utiliza como referencia para el usuario. Si se selecciona recibir el report en una URL, recibir� este par�metro en el resultado del env�o.
    // DEVUELVE: Un array
    //  Res: Int
    //      >0 correspondiente al n�mero de mensajes enviados.
    //      -1 Error de autenticaci�n
    //      -2 no hay cr�ditos suficientes.
    //      -3 Error en los datos de la llamada
    //  Msgid: Int
    //      identificador del mensaje enviado para utilizar en el report
    //  Cred: Float
    //      n�mero de cr�ditos que le restan.
    ///////////////////////////////////////////////////////

    function enviarCertificado($Valores)
    {
        $res=$this->_conecta($Valores,"/v5/enviarcert.php");
        $this->Creditos=$res["Cred"];
        $this->id=$res["Msgid"];
        return $res;
    }

    /*
     *
     *
     *
     */
    //////////////////////////////////////////////////////
    // ENV�A MENSAJES DE VOZ A TEL�FONOS FIJOS Y M�VILES
    // - Valores: Array con todas o alguna de las siguientes variables
    //      Destinatarios: M�vil/M�viles al/a los que se env�a el mensaje, de la forma PrefijoTelefono (Ej:346000000 � para varios destinatarios
    //           346000000;3519760000;443450000) separados por punto y coma ';'
    //      Mensaje: Mensaje que se env�a, se convierte en voz y se entrega
    //      Remitente: Es el tel�fono que aparece como n�mero llamante. Por seguridad, debe ser un n�mero validado desde los paneles de Mensatek o un n�mero contratado en mensatek. Puede contratar n�meros telef�nicos en m�s de 50 pa�ses.
    //            Si no es un n�mero validado o uno contratado en Mensatek no se realizar� la llamada.
    //      Fecha: Fecha en la que queda progrmado el env�o, el mensaje se enviar� en esa fecha. Por defecto "" que significa enviar ahora. Formato: A�o-Mes-dia hora:minuto
    //          La referencia horaria es GMT+1 (Zona horaria de Espa�a)
    //      Report: 0=No, 1=S�  (1=se env�a report de entrega al correo electr�nico)
    //
    //      Descuento: 0=No, 1=S� (se a�adir� 'Enviado desde Mensatek.es)
    //      URLReport: Uri a la que se envviar�n los cambios de estado de la llamada. Ver estados de llamada posibles en el PDF de especificaciones
    //      Referencia: Referencia del mensaje de VOZ, la recibir� junto con los par�mentros de llamada en la URI especificada en URIReport
    //      Lenguaje: Lenguage y g�nero de la conversi�n de texto a VOZ (opciones disponibles en el PDF de especificaciones)
    //      TimeZone: Zona Horaria, por defecto Europe/Madrid
    //      Reintentos: Si no contesta, n�mero de reintentos
    //      Intervalo: Tiempo en segundos entre reintentos
    //      FechaLimite: Fecha l�mite de reintentos. Por defecto un mes posterior a la fecha de env�o
    //      HoraInicioDiaria: Hora de inicio de las llamadas cada d�a referenciado a la zona horaria indicada. Por defecto 10:00 de la ma�ana
    //      HoraLimiteDiaria: Hora diaria de finalizaci�n de las llamadas referenciada a la zona horaria indicada (por defecto 22:00).
    //      DetectarContestador: Acci�n a realizar si descuelga un contestador autom�tico
    //              0: Esperar Se�al y dejar mensaje en el contestador (Por defecto y opci�n recomendada/m�s econ�mica)
    //              1: Colgar y reintentar de nuevo las veces indicadas
    //              2: Colgar y reintentar las veces indicadas, si al final, responde un contestador (tras todos los reintentos) se esparar� la se�al y se dejar� el mensaje.
    //      IVR:    0=> No hay men� IVR
    //              1=> Hay men� IVR (debe enviarse en �a variable MenuIVR
    //              2=> Hay solicitud de PIN (EWn MenuIVR debe enviar los par�metros)
    //      MenuIVR: JSON con los siguientes datos
    //          Para IVR=1 (Men� IVR)
    //              Locucion: Locuci�n inicial del Men� (por ejemplo pulse 1 para repetir, 2 para enviar email, 3,....)
    //              DIGITO => (n�mero que lanza esta opci�n del men�) Escribir directamente el/los d�gitos, no DIGITO: d�gito (ver ejemplos en testenviovoz.php)
    //                     Accion: Acci�n a realizar:
    //                                  1=> Repetir Mensaje
    //                                  2=> Enviar a URL (Poner URI en la opci�n Valor)
    //                                  3=> Enviar a Email (Poner correo en la Opci�n Valor)
    //                                  4=>Reenviar a n�mero (poner n�mero a reenviar en la opci�n Valor)
    //                                  5=>Dar de baja, el n�mero destinatario quedar� a�adido a la lista negra
    //                                  6=>Colgar, colgar la llamada
    //                      Valor: (valor de la acci�n, s�lo necesario para acciones 2,3 y 4)
    //                      Grabar: 0 (No) o 1 (S�). S�lo v�lido para Acci�n: 4 (reenv�o de llamada): S grabar� la conversaci�n.
    //                      RepetirMenu: 0 (no, se reproducir� la locuci�nFinal y se colgar�)/ 1 (S�, se repetir� la locuci�n del Men� y se solicitar� otra pulsaci�n).
    //                      LocucionFinal: Si se cuelga (RepetirMenu=0)  antes de colgar se reproducir� esta locuci�n (por ejemplo: Gracias por su confirmaci�n),
    //              DIGITO =>.... otra opci�n del men�
    //              ....
    //          Para IVR=2 (solicitud de PIN)
    //              Locucion: Locuci�n inicial del Men� (por ejemplo pulse 1 para repetir, 2 para enviar email, 3,....)
    //              AccionPIN: Acci�n a realizar una vez obtenido el PIN:
    //                      2: Enviar a URL (valor de la URL en ValorAccionPIN)
    //                      3: Enviar a Email (Valor de Email en ValorAccionPIN).
    //              ValorAccionPIN: URI o Email para llevar a cabo la acci�n indicada en AccionPIN.
    //              LongPIN: Longitud en d�gitos del PIN a solicitar, (por defecto 4)
    //              LocucionFinalPIN: Locuci�n final una vez obtenido el PIN (se reproduce y se cuelga).
    //
    // DEVUELVE: Un array
    //  Res: Int
    //      >0 correspondiente al n�mero de mensajes enviados.
    //      -1 Error de autenticaci�n
    //      -2 no hay cr�ditos suficientes.
    //      -3 Error en los datos de la llamada
    //      -19 Remitente no validado en Mensatek
    //      -20 Lenguaje/g�nero no v�lido
    //  Msgid: Int
    //      identificador del mensaje enviado para utilizar en el report
    //  Cred: Float
    //      n�mero de cr�ditos que le restan.
    ///////////////////////////////////////////////////////

    function enviarVOZ($Valores)
    {
        $res=$this->_conecta($Valores,"/v5/enviarvoz.php");
        $this->Creditos=$res["Cred"];
        $this->id=$res["Msgid"];
        return $res;
    }

    ////////////////////
    //
    // Enviar contrato
    ///////////////////
    function enviarContrato($Valores)
    {
        $res=$this->_conecta($Valores,"/api/v2/enviarcontrato","FIRMA");
        $this->Creditos=$res["Cred"];
        $this->id=$res["ContratoId"];
        return $res;
    }


    
    //////////////////////////////////////////////////////
    // REPORT DE ENV�O
    // MsgId: Identificador de mensaje devuelto por la funci�n de env�o.
    // DEVUELVE:
    //  - Entero con el N�mero de reports
    //  - Carga Array en $this->Res con n valores (tantos como tel�fonos de destino) del tipo 
    //         $this->Res[n]["Fecha"] Fecha/Hora de env�o
    //         $this->Res[n]["Movil"] M�vil destino
    //         $this->Res[n]["Tiempo"] Tiempo (en segundos) que tard� en entregarse el mensaje al m�vil (normalmente entre 2 s 20 segundos si el m�vil est� encendido).
    //         $this->Res[n]["Resultado"] String con el resultado del env�o (entregado, m�vil err�neo, etc...). Se compone de:
    //
    ///////////////////////////////////////////////////////

    function report($MsgId)
    {
        $res=$this->_conecta(array("idM"=>$MsgId),"/v5/report.php");
        $this->Res=$res["Informe"];
        return count($this->Res);

    }

    function reportCertificado($MsgId)
    {
        $res=$this->_conecta(array("idM"=>$MsgId),"/v5/reportcert.php");
        $this->Res=$res["Informe"];
        return count($this->Res);

    }
    
    //////////////////////////////////////////////////////
    // SUBVENCIONAR CR�DITOS A OTRA CUENTA DE USUARIO
    // CorreoDestino: Correo del usuario destino de los cr�ditos.
    // Creditos: N�mero de cr�dtos a a�adir al usuario  
    // DEVUELVE:
    //  - Si >0 Entero con el N�mero de cr�ditos efectivamente a�adidos al usuario o error
    //  - Si <0  
    //   -1 Errror de usuario
    //   -2 No hay suficientes cr�ditos
    //   -3 Correo de destino no existe
    //   -4 Cr�ditos <0
    ///////////////////////////////////////////////////////

    function subvencionar($CorreoDestino,$Creditos)       
    {
        $res=$this->_conecta(array("CorreoDest"=>$CorreoDestino,"Creditos"=>$Creditos),"/v5/subvencionar.php");
        
        return $res["Res"];
    }
    
    //////////////////////////////////////////////////////
    // CARGAR FICHERO (REOMENDADO PDF POR COMPATIBILIDAD DE LOS M�VILES AUNQUE TAMBI�N PUEDE SER WORD O EXCEL)
    // Valores: Array con las siguiente variables:
    // Nombre: Es el nombre que se le dar� al fichero con extensi�n. Por ejemplo fichero,pdf . No debe contener m�s que caracteres alfanum�ricos y la extensi�n, un m�ximo de 15 caractees sin contar la extensi�n.
    // Fichero: dichero a cargar, es el fichero con el path , por ejemplo ./fichero.pdf
    // Tipo: Es el tipo de carga. Recomendado FILES que ser�a enviar el fichero como si se hiciese desde un formulario, BASE64 es paracuando no se puede enviar de esa forma. En esta librer�a forzamos FILES
    // DEVUELVE
    // array con
    // Sobrescrito: 0 si no exist�a 1 si exist�a y el fichero se ha sobrescrito
    // Nomnbre: Nombre final del fichero cargado (elimina caracteres no alfanum�ricos)
    // Res:
    //   1: Todo correcto
    //  - Si <0
    //   -1 Errror de usuario
    //   -3: S�lo las cuentas con saldo activo pueden cargar ficheros
    //-10: Ha excedido su capacidad de almacenamiento de ficheros, contacte con soporte para solicitar m�s espacio
    //-11: Formato de fichero no admitido, se admiten PDF, excel y word, se recomienda PDF por m�xima compatibilidad en los tel�fonos
    //-12: Ha a�adido un fichero en el mensaje indicando que lo especificar�a en BASE64 pero no ha enviado el contenido  en BASE64
    //-13: Ha a�adido un fichero en el mensaje indicando que lo enviar�a en en formato FORM-MULTIPART y no ha llegado ning�n fichero
    //-14: Formato de imagen no admitida , puede incluir GIF, PNG y JPG
    //-15: Debe especificar Tipo FILES o BASE64
    ///////////////////////////////////////////////////////
    
    function cargaFichero($Valores)
    {
        if (!isset($Valores["Fichero"])||strlen($Valores["Fichero"])<3) return -13;
        $ext = strtolower(substr($Valores["Fichero"], strrpos($Valores["Fichero"], '.')+1));
        if ($ext!="pdf"&&$ext!="doc"&&$ext!="docx"&&$ext!="xls"&&$ext!="xlsx") return -11;

        if (!function_exists('curl_file_create'))   $Valores["Fichero"]='@'.realpath($Valores["Fichero"]).";filename:".basename($Valores["Fichero"]);
        else $Valores["Fichero"]=curl_file_create(realpath($Valores["Fichero"]),'',basename($Valores["Fichero"]));
        
        $Valores["Tipo"]="FILES";
        
        $res=$this->_conecta($Valores,"/v5/cargarfichero.php");
        
        return $res["Res"];
    }
    
    //////////////////////////////////////////////////////
    // LISTAR FICHEROS EN LA CUENTA
    // DEVUELVE
    // Array con los ficheros en caso de �xito
    // -1: Eerror de autenticaci�n
    // -11: Debe especificar un fichero correcto
    ///////////////////////////////////////////////////////
    
    function listaFicheros()
    {
        
        $res=$this->_conecta(array(),"/v5/listarficheros.php");
        
        if ($res["Res"]==1) return($res["Ficheros"]);
        else return $res["Res"];
    }
    
    //////////////////////////////////////////////////////
    // BORRA FICHEROS EN LA CUENTA
    // Valores: Array con las siguiente variables:
    // Fichero: Fichero a borrar
    // DEVUELVE
    // 1: Borrado con �xito
    // -1: Eerror de autenticaci�n
    // -2: No existe el fichhero
    ///////////////////////////////////////////////////////
    
    function borraFichero($Valores)
    {
        
        $ext = strtolower(substr($Valores["Fichero"], strrpos($Valores["Fichero"], '.')+1));
        if ($ext!="pdf"&&$ext!="doc"&&$ext!="docx"&&$ext!="xls"&&$ext!="xlsx") return -11;
        
        
        $res=$this->_conecta($Valores,"/v5/borrarfichero.php");
    
        return $res["Res"];
    }
    

    // Funciones internas
    function _conecta($args,$dir,$tipo="SMS")
    {
        
        $args["Correo"]=$this->_correo;
        $args["Passwd"]=$this->_pass;
        $args["Resp"]="JSON";
        
        // Aseguramos que se env�a en utf8
        foreach($args as $vr=>$vl) $args[$vr]=utf8_encode($vl);
        if (G_PUERTO==443||G_PUERTO==3378) $_gPRE="https://";
        else $_gPRE="http://";

        switch($tipo)
        {
            case "SMS":
            default:
                $_gDIR="api.mensatek.com";
                break;
            case "FIRMA":
                $_gDIR="www.lofirmo.com";
                break;

        }

    
        

        if (function_exists("curl_init"))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$_gPRE.$_gDIR.$dir);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            //PONER A true SI SE QUIERE VER LAS TRAZAS DE CONEXI�N S�LO DURANTE DESARROLLO
            curl_setopt($ch, CURLOPT_VERBOSE, false);
            curl_setopt($ch, CURLOPT_HEADER, 0);

            curl_setopt($ch, CURLOPT_STDERR, fopen('php://output', 'w+'));
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
            curl_setopt($ch,CURLOPT_POST, 1);
            //curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            curl_setopt($ch, CURLOPT_PORT, G_PUERTO);

            // Puede poner esta l�nea a continuaci�n o descargar el certificado de nuestra web y utilizar curl_setopt($ch, CURLOPT_CAINFO, getcwd() . "nuestrocertificadoAPI.pem"); si lo desea

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

            curl_setopt($ch, CURLOPT_TIMEOUT, 50);
            

            $sub=curl_exec ($ch);
            if ($sub === FALSE) {
                printf("cUrl error (#%d): %s<br>\n", curl_errno($ch),
                    htmlspecialchars(curl_error($ch)));
            }
            // Quitar el siguiente comentario para sacar por pantalla resultado directo devuelto.
            //echo "<pre>".$sub."</pre>";


            curl_close ($ch);

            $p=strpos($sub,"{");
            $sub=substr($sub,$p,strrpos($sub,"}")+1-$p);
            
            $return=json_decode($sub,true);
            
        }
        else
        {
            // Eliminar esta l�nea si se desea conectar por sockets aunque es recomendable utilizar curl.
            echo "\nATENCION: Intentando conectarse por sockets, debe considerar activar curl en su instalaci&oacute;n de PHP\n";
            if (G_PUERTO==443||G_PUERTO==3378)
                $fp = fsockopen ("ssl://".$_gDIR, G_PUERTO, $errno, $errstr, 30);
            else $fp = fsockopen ($_gDIR, G_PUERTO, $errno, $errstr, 30);
            if (!$fp) echo "Su sistema no permite trabajar con sockets, active la funcionalidad de sockets en PHP para utilizar la librer�a\n";
            else
            {

                $content = "PET=POST&".http_build_query($args)."&SEG=SSL2048";

                $string="POST ".$dir;
                fputs($fp, $string."  HTTP/1.1\r\n");
                fputs($fp, "Host: api.mensatek.com\r\n");

                fwrite($fp, "Content-Type: application/x-www-form-urlencoded\r\n");
                fwrite($fp, "Content-Length: ".strlen($content)."\r\n");
                fputs($fp, "Connection: close\r\n\r\n");
                fwrite($fp, "\r\n");
                fwrite($fp, $content);
                $sub="";
                while (!feof($fp)) $sub.=fgets($fp, 128);
                fclose($fp);
                // Quitar este comentario para imprimir en pantalla las traszas de la comunicaci�n
                //echo "<pre>".$sub."</pre>";
                $p=strpos($sub,"{");
                $val=substr($sub,$p,strrpos($sub,"}")+1-$p);

                $return=json_decode($val,true);

            }

        } 
        return $return;
    }
    

}
?>