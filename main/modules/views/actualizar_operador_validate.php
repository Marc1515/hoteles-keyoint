<?php

    $idOperador = $_POST['idOperador'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $movil = $_POST['phone'];


    session_start();


    require('../ws/ws_operadores/ws2.php');

    
    if(isset($_POST)) {
    
        require('./../ws/ws_operadores/ws_actualizarOperador.php');

}


?>