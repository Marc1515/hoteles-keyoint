<?php

// ESTABLECER URL WEB SERVICES Y TOKEN
$client = new SoapClient("http://localhost/keysWS/informesWS.asmx?WSDL", array("trace" => 1, 'exceptions' => 0));
$token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";


?>