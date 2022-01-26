<?php


require './../ws/ws_cupos/ws_damePuertasSinCupo.php';

/* $array_damePuertasSinCupo = array($object_damePuertasSinCupo); */

/* for ($step=0; $step<count($array_damePuertasSinCupo); $step++) {

    var_dump($array_damePuertasSinCupo[$step]->IdPuerta);
  
} */





$arrayPuertas = $_POST['public-methods'];

/* var_dump($arrayPuertas); */

$arrayEnteros = [];


for ($step=0; $step<count($array_damePuertasSinCupo); $step++) {

    var_dump($array_damePuertasSinCupo[$step]->IdPuerta);

    echo '<br>';
    echo '<br>';
    echo '<br>';

    for($step2=0; $step2<count($arrayPuertas); $step2++) {

    
        $elementoPuertaString = $arrayPuertas[$step2];

        $numPuertaString = substr($elementoPuertaString, -1);

        $numPuertaEntero = intval($numPuertaString);

        array_push($arrayEnteros, $numPuertaEntero);

        /* require './../ws/ws_cupos/ws_insertarPuertaCupo.php'; */
        
        echo '<br>';
        var_dump($numPuertaEntero);

    
        if (in_array($numPuertaEntero, $arrayEnteros)) {

            echo 'Si esta!';

            

            /* require './../ws/ws_cupos/ws_insertarPuertaCupo.php'; */
            
        } else {

            echo 'No esta!';
            

        }

    }
    echo '<br>';
    var_dump($arrayEnteros);

    

}







/*     $arrayPuertas = [];



    for ($step=0; $step<count($arrayPuertas); $step++) {

        $numString = substr($arrayPuertas[$step], -1);

        break;

    }


    session_start();

    $numEntero = intval($numString);


    require('./../ws/ws_cupos/ws_cuposDePuertas.php');
    require('./../ws/ws_cupos/ws_damePuertasSinCupo.php');



    $array_damePuertasSinCupo = (array)$soap_result_DPSC->DamePuertasSinCupoResult;
    

    if(isset($numEntero)) {
        
        
        if(count($array_damePuertasSinCupo)<count($array_damePuertasCupo)){

            var_dump('array_damePuertasSinCupo menos puertas que array_damePuertasCupo');
            die(); 
            require ('./../ws/ws_cupos/ws_insertarPuertaCupo.php');
            header("location:crear-cupo.php");
            die();

        } else {

            var_dump('array_damePuertasSinCupo mas puertas que array_damePuertasCupo');
            die();
            require ('./../ws/ws_cupos/ws_borrarPuertaCupo.php');
            header("location:crear-cupo.php");
            die();

        }
        
    } */

    

?>