<?php

session_start();

require('ws2.php');


$idOperadorForm = $_SESSION['idOperador'];
$idOperador = intval($idOperadorForm);
/* var_dump($idOperator);
die(); */
$idLocker = $_SESSION['idLocker'];
$desde = '20210101';
$hasta = '20211231';
$estado = 9;

if(isset($_POST['filtro'])) {

    $ano = $_POST['filtro'];
    
    $desde = $ano.'0101';
    $hasta = $ano.'1231';
    
}


// --- LLAMAR WS : DameReservasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>$idLocker, 'idoperador'=>$idOperador,  'desde'=>$desde, 'hasta'=>$hasta, 'estado'=>$estado);
$soap_result_DRPO = $client->DameReservasPorOperador($parametros_dameReserva);


$array_dameReservasPorOperador = $soap_result_DRPO->DameReservasPorOperadorResult->Reserva;


$arrayEnteros = [];

$enero = 0;
$febrero = 0;
$marzo = 0;
$abril = 0;
$mayo = 0;
$junio = 0;
$julio = 0;
$agosto = 0;
$septiembre = 0;
$octubre = 0;
$noviembre = 0;
$diciembre = 0;


if ((array)$array_dameReservasPorOperador->IdReserva) {


    $entradaString = $array_dameReservasPorOperador->Entrada;

    $stringTruncado = substr($entradaString, -4);

    $entradaEntero = intval($stringTruncado);

    array_push($arrayEnteros, $entradaEntero);



    if($arrayEnteros >= 100 && $arrayEnteros < 200 ) {

        $enero++;

    }

    elseif($arrayEnteros >= 200 && $arrayEnteros < 300 ) {

        $febrero++;

    }

    elseif($arrayEnteros >= 300 && $arrayEnteros < 400 ) {

        $marzo++;

    }

    elseif($arrayEnteros >= 400 && $arrayEnteros < 500 ) {

        $abril++;

    }

    elseif($arrayEnteros >= 500 && $arrayEnteros < 600 ) {

        $mayo++;

    }

    elseif($arrayEnteros >= 600 && $arrayEnteros < 700 ) {

        $junio++;

    }

    elseif($arrayEnteros >= 700 && $arrayEnteros < 800 ) {

        $julio++;

    }

    elseif($arrayEnteros >= 800 && $arrayEnteros < 900 ) {

        $agosto++;

    }

    elseif($arrayEnteros >= 900 && $arrayEnteros < 1000 ) {

        $septiembre++;

    }

    elseif($arrayEnteros >= 1000 && $arrayEnteros < 1100 ) {

        $octubre++;

    }

    elseif($arrayEnteros >= 1100 && $arrayEnteros < 1200 ) {

        $noviembre++;

    }

    elseif($arrayEnteros >= 1200 && $arrayEnteros < 1300 ) {

        $diciembre++;

    }



} elseif (isset($array_dameReservasPorOperador)){


    for ($let=0; $let<count($array_dameReservasPorOperador); $let++) {


        $entradaString = $array_dameReservasPorOperador[$let]->Entrada;

        $stringTruncado = substr($entradaString, -4);

        $entradaEntero = intval($stringTruncado);

        array_push($arrayEnteros, $entradaEntero);



        if($arrayEnteros[$let] >= 100 && $arrayEnteros[$let] < 200 ) {

            $enero++;

        }

        elseif($arrayEnteros[$let] >= 200 && $arrayEnteros[$let] < 300 ) {

            $febrero++;

        }

        elseif($arrayEnteros[$let] >= 300 && $arrayEnteros[$let] < 400 ) {

            $marzo++;

        }

        elseif($arrayEnteros[$let] >= 400 && $arrayEnteros[$let] < 500 ) {

            $abril++;

        }

        elseif($arrayEnteros[$let] >= 500 && $arrayEnteros[$let] < 600 ) {

            $mayo++;

        }

        elseif($arrayEnteros[$let] >= 600 && $arrayEnteros[$let] < 700 ) {

            $junio++;

        }

        elseif($arrayEnteros[$let] >= 700 && $arrayEnteros[$let] < 800 ) {

            $julio++;

        }

        elseif($arrayEnteros[$let] >= 800 && $arrayEnteros[$let] < 900 ) {

            $agosto++;

        }

        elseif($arrayEnteros[$let] >= 900 && $arrayEnteros[$let] < 1000 ) {

            $septiembre++;

        }

        elseif($arrayEnteros[$let] >= 1000 && $arrayEnteros[$let] < 1100 ) {

            $octubre++;

        }

        elseif($arrayEnteros[$let] >= 1100 && $arrayEnteros[$let] < 1200 ) {

            $noviembre++;

        }

        elseif($arrayEnteros[$let] >= 1200 && $arrayEnteros[$let] < 1300 ) {

            $diciembre++;

        }

        
    }




}



?>