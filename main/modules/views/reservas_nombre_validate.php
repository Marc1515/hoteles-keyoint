<?php

require ('../ws/ws_reservas/ws2.php');

$txt_resultado = '';

$nombre = $_POST['nom'];

if(isset($nombre)) {

    // --- LLAMAR WS : DameReservaPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>11051, 'idoperador'=>1,  'desde'=>'20210101', 'hasta'=>'20211231', 'estado'=>9);
    $soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);

    $reservasArray = (array)$soap_result_DR->DameReservasPorOperadorResult->Reserva;

    for($step=0; $step<count($soap_result_DR->DameReservasPorOperadorResult->Reserva); $step++) {

        if($reservasArray[$step]->Nombre==$nombre) {

            // --- LLAMAR WS : DameReservasPorNombre --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_dameReservaPorNombre = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>1, 'filtroNombre'=>$nombre, 'estado'=>9);
            $soap_result_DRPN = $client->DameReservasPorNombre($parametros_dameReservaPorNombre);

            $object_dameReservaPorNombre = $soap_result_DRPN->DameReservasPorNombreResult->Reserva;

            // Data de entrada con formato
            $newInPutDate = $object_dameReservaPorNombre->Entrada;

            $newInPutDate = date("d-m-Y", strtotime($newInPutDate));

            // Data de salida con formato
            $newOutPutDate = $object_dameReservaPorNombre->Salida;

            $newOutPutDate = date("d-m-Y", strtotime($newOutPutDate));


        
                $txt_resultado =   '<div class="table-responsive m-t-40">
                                        <table id="config-table" class="table display table-bordered table-striped no-wrap mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Nº Reserva</th>
                                                    <th>Entrada</th>
                                                    <th>Salida</th>
                                                    <th>Localizador</th>
                                                    <th>Referencia</th>
                                                    <th>Nombre</th>
                                                    <th>Movil</th>
                                                    <th>Email</th>
                                                    <th>Accion</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>'.$object_dameReservaPorNombre->IdReserva.'</td>
                                                    <td>'.$newInPutDate.'</td>
                                                    <td>'.$newOutPutDate.'</td>
                                                    <td>'.$object_dameReservaPorNombre->Localizador.'</td>
                                                    <td>'.$object_dameReservaPorNombre->Referencia.'</td>
                                                    <td>'.$object_dameReservaPorNombre->Nombre.'</td>
                                                    <td>'.$object_dameReservaPorNombre->Movil.'</td>
                                                    <td>'.$object_dameReservaPorNombre->Email.'</td>
                                                    <td class="d-flex justify-content-center">
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-xs btn-info mr-2" data-toggle="modal" data-target="#borrarReserva'.$object_dameReservaPorNombre->IdReserva.'" data-id_res="'.$object_dameReservaPorNombre->IdReserva.'" data-nombre="'.$object_dameReservaPorNombre->Nombre.'"><i class="far fa-trash-alt"></i></button>
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="borrarReserva'.$object_dameReservaPorNombre->IdReserva.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Borrar Reserva</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Borrar la reserva de '.$object_dameReservaPorNombre->Nombre.'?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="eliminar_reserva_validate.php" method="POST">
                                                                            <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$object_dameReservaPorNombre->IdReserva.'">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-danger text-white" data-id_res="'.$object_dameReservaPorNombre->IdReserva.'" data-nombre="'.$object_dameReservaPorNombre->Nombre.'">Confirmar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <a href="actualizar-reserva.php?upd='.$object_dameReservaPorNombre->IdReserva.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>';

                                    break;

        } else {

            $txt_resultado = "El nombre no existe";

        }

    }


}


die (json_encode(array('status' => $txt_resultado)));

?>