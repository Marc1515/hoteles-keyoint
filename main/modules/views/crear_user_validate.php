<?php

    $nombre = $_POST['nombre'];
    $nombreUser = $_POST['nombreUsuario'];
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];
    $idRol = $_POST['idRol'];
    $movil = $_POST['full_phone'];
    $email = $_POST['example-email'];
    $pinString = $_POST['pin'];

    $pin = str_pad($pinString, 6, 0, STR_PAD_LEFT);

    session_start();

    
    // --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
    require('./../ws/ws_users/ws_dameUsuarios.php');


    if(isset($_POST)) {

        if($pwd==$pwd2) {
    
            // --- LLAMAR WS : InsertarUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
            require('./../ws/ws_users/ws_insertarUsuario.php');
            header("location:users.php?error=0");
            die();
                                    
        } else {
                        
            header("location:crear-user.php?error=1");
                        
        }
                    
    }

?>