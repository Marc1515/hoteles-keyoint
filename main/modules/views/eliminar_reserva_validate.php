<?php

    session_start();

    require('../ws/ws_reservas/ws2.php');


    $idReserva = $_POST['del_id_usr'];

    
    if(isset($_POST)) {
        
        // --- LLAMAR WS : anularReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
        require('./../ws/ws_reservas/ws_anularReserva.php');
        header("location:reservas.php?error=3");
        die();

    }


?>