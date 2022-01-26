<?php

// ESTABLECER URL WEB SERVICES Y TOKEN
$client_reservas = new SoapClient("http://localhost/keysWS/reservasWS.asmx?WSDL", array("trace" => 1, 'exceptions' => 0));
$token_ws = "qorvM13IwZTuGZPlvrU4nnNiRfPFe";


?>