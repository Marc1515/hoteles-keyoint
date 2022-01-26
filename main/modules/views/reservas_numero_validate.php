<?php

require ('../ws/ws_reservas/ws2.php');

$txt_resultado = '';

$numero = $_POST['num'];

if(isset($numero)) {

    // --- LLAMAR WS : DameReservaPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameReserva = array('token'=>$token_ws, 'idlocker'=>11051, 'idoperador'=>1,  'desde'=>'20210101', 'hasta'=>'20211231', 'estado'=>9);
    $soap_result_DR = $client->DameReservasPorOperador($parametros_dameReserva);

    $reservasArray = (array)$soap_result_DR->DameReservasPorOperadorResult->Reserva;

    
    for($step=0; $step<count($reservasArray); $step++){
        
        if($reservasArray[$step]->IdReserva==$numero) {
            
            // --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>1,  'IdReserva'=>$numero);
            $soap_result_DR = $client->DameReserva($parametros_dameReserva);
            

            $objeto_dameReserva = $soap_result_DR->DameReservaResult;

            // Data de entrada con formato
            $newInPutDate = $objeto_dameReserva->Entrada;

            $newInPutDate = date("d-m-Y", strtotime($newInPutDate));

            // Data de salida con formato
            $newOutPutDate = $objeto_dameReserva->Salida;

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
                                                <td>'.$objeto_dameReserva->IdReserva.'</td>
                                                <td>'.$newInPutDate.'</td>
                                                <td>'.$newOutPutDate.'</td>
                                                <td>'.$objeto_dameReserva->Localizador.'</td>
                                                <td>'.$objeto_dameReserva->Referencia.'</td>
                                                <td>'.$objeto_dameReserva->Nombre.'</td>
                                                <td>'.$objeto_dameReserva->Movil.'</td>
                                                <td>'.$objeto_dameReserva->Email.'</td>
                                                <td class="d-flex justify-content-center">
                                            
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-xs btn-info mr-2" data-toggle="modal" data-target="#borrarReserva'.$objeto_dameReserva->IdReserva.'" data-id_res="'.$objeto_dameReserva->IdReserva.'" data-nombre="'.$objeto_dameReserva->Nombre.'"><i class="mdi mdi-close"></i></button>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="borrarReserva'.$objeto_dameReserva->IdReserva.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Borrar Reserva</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Borrar la reserva de '.$objeto_dameReserva->Nombre.'?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="eliminar_reserva_validate.php" method="POST">
                                                                        <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$objeto_dameReserva->IdReserva.'">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameReserva->IdReserva.'" data-nombre="'.$objeto_dameReserva->Nombre.'">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="actualizar-reserva.php?upd='.$objeto_dameReserva->IdReserva.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>';

                                break;

                } else {

                    $txt_resultado = "No existe el numero de reserva: $numero";

                }

            }


        } 

/* echo $txt_resultado; */

die (json_encode(array('status' => $txt_resultado)));

?>