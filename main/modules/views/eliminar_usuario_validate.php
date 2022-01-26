<?php

    session_start();

    
    $idUser = $_POST['del_id_usr'];
    
    
    if(isset($_POST)) {
        
        // --- LLAMAR WS : BorrarUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('./../ws/ws_users/ws_borrarUsuario.php');        
        header("location:users.php?error=3");
        die();

    }

?>