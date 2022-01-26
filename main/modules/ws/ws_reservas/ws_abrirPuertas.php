<?php

// ESTABLECER URL WEB SERVICES Y TOKEN
$client = new SoapClient("http://172.16.0.105/AbrirPuertaWS/puertasWS.asmx?WSDL", array("trace" => 1, 'exceptions' => 0));
$token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";


?>