<?php

    $idUsuario = $_POST['idUsuario'];
    $nombre = $_POST['nombre'];
    $nombreUser = $_POST['nombreUsuario'];
    $pwd = $_POST['pwd'];
    $idRol = $_POST['idRol'];
    $movil = $_POST['movil'];
    $email = $_POST['example-email'];
    $pin = $_POST['pin'];


    session_start();

    
    if(isset($_POST)) {
    
        // --- LLAMAR WS : ActualizarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('./../ws/ws_users/ws_actualizarUsuario.php');
        header("location:users.php?error=2");
        die();

}

?>