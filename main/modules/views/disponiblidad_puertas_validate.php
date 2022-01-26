<?php

    session_start();

    
    $fecha = $_POST['fecha'];

    $fechaForm = date("Ymd", strtotime($fecha));

    /* var_dump($fechaForm);
    die(); */

    
    if(isset($fechaForm)) {
        
        // --- LLAMAR WS : DameDisponiblesCupoFecha --------------------------------------------------------------------------------------------------------------------------------------------------->
        require ('./../ws/ws_reservas/ws_dameDisponiblesCupoFecha.php');
        header("location:disponiblidad_puertas.php");
        die();

    }

?>