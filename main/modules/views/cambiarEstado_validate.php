<?php

session_start();

require './../ws/ws_reservas/ws2.php';



$idReservaString = $_GET['idReserva'];
$idReserva = intval($idReservaString);

$idOperador = $_SESSION['idOperador'];
$idLocker = $_SESSION['idLocker'];

$cambiarEstadoString = $_POST['estadoCambiar'];
$cambiarEstado = intval($cambiarEstadoString);



// --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
$parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva);
$soap_result_DR = $client->DameReserva($parametros_dameReserva);

$objeto_dameReserva = $soap_result_DR->DameReservaResult;


    $idReserva = $objeto_dameReserva->IdReserva;
    $entrada = $objeto_dameReserva->Entrada;
    $salida = $objeto_dameReserva->Salida;
    $referencia = $objeto_dameReserva->Referencia;
    $nombre = $objeto_dameReserva->Nombre;
    $movil = $objeto_dameReserva->Movil;
    $localizador = $objeto_dameReserva->Localizador;
    $email = $objeto_dameReserva->Email;
    $observaciones = $objeto_dameReserva->IdReserva;
    $pinEntrada = $objeto_dameReserva->PinEntrada;
    $idPuertaEntrada = $objeto_dameReserva->IdPuertaEntrada;
    $notificacion = $objeto_dameReserva->TipoNotificación;
    $estado = $objeto_dameReserva->Estado;



    /* if ($_POST['estado']) {

        
        $estadoString = $_POST['estado'];
        
        $estado = intval($estadoString);

        if ($_POST['estado'] === "9") {

            $estado = 0;

        }

    } */

    if ($estado === 0 || $estado === 2) {



        // --- LLAMAR WS : ActualizarReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_actualizarReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador,  'IdReserva'=>$idReserva, 'Entrada'=>$entrada, 'Salida'=>$salida,
        'Localizador'=>$localizador, 'Referencia'=>$referencia, 'Nombre'=>$nombre, 'Movil'=>$movil, 'Email'=>$email, 'PinEntrada'=>$pinEntrada, 'PinSalida'=>0,
        'IdPuertaEntrada'=>0, 'IdPuertaSalida'=>0, 'TipoNotificacion'=>$notificacion, 'Observaciones'=>$observaciones, 'Estado'=>0);



        if (isset($parametros_dameReserva)) {


            $soap_result_AR = $client->ActualizarReserva($parametros_actualizarReserva);

            $objeto_dameReserva = $soap_result_AR;

            header('location:reservas.php?error=2');

        } else {

            header('location:reservas.php');

        }

    } elseif ($estado === 1) {

        echo "
        
            <script>




            </script>
        
        ";



    } 

?>


<!-- <script>



var entrada = ".$cambiarEstado.";

console.log(entrada);

var dataString = 'entrada=' + entrada;
jQuery.ajax({
data: dataString,
type: 'POST',
dataType: 'json',
url: '../ws/ws_reservas/ws_reserva2.php',
success: function( payload ){
    
    /* if (payload.status == 'No hay puertas disponibles') {

        document.getElementById('enviarCorr').disabled = true;

    } else {

        document.getElementById('enviarCorr').disabled = false;

    }

    document.getElementById('idPuertaEntrada').value = payload.status; */


},
error: function(){
    console.log('error');
    }
});





</script> -->

