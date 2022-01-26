<?php

require ('../ws/ws_operadores/ws2.php');

$txt_resultado = '';

$numero = $_POST['num'];


if(isset($numero)) {

    // --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>11051, 'OrdenAoN'=>'A');
    $soap_result_DO = $client->DameOperadores($parametros_dameOperadores);

    $operadoresArray = $soap_result_DO->DameOperadoresResult->Operador;

    
    
    /* $usersArray = $soap_result_DU; */
    
    
    for($step=0; $step<count($operadoresArray); $step++){
        
        if($operadoresArray[$step]->IdOperador==$numero) {
            
            /* var_dump($operadoresArray);
            die(); */
            // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>1,  'IdOperador'=>$numero);
            $soap_result_DO = $client->DameOperador($parametros_dameOperador);
            
            
            $objeto_dameOperador = $soap_result_DO->DameOperadorResult;

    
            $txt_resultado =   '<div class="table-responsive m-t-40">
                                    <table id="config-table" class="table display table-bordered table-striped no-wrap mt-3">
                                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Nombre</th>
                                                <th>Email</th>
                                                <th>Movil</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>'.$objeto_dameOperador->IdOperador.'</td>
                                                <td>'.$objeto_dameOperador->Nombre.'</td>
                                                <td>'.$objeto_dameOperador->Email.'</td>
                                                <td>'.$objeto_dameOperador->Movil.'</td>
                                                <td class="d-flex justify-content-center">
                                            
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-xs btn-info mr-2" data-toggle="modal" data-target="#borrarReserva'.$objeto_dameOperador->IdOperador.'" data-id_res="'.$objeto_dameOperador->IdOperador.'" data-nombre="'.$objeto_dameOperador->Nombre.'"><i class="mdi mdi-close"></i></button>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="borrarReserva'.$objeto_dameOperador->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Borrar Reserva</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Borrar la reserva de '.$objeto_dameOperador->Nombre.'?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="eliminar_reserva_validate.php" method="POST">
                                                                        <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$objeto_dameOperador->IdOperador.'">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameOperador->IdOperador.'" data-nombre="'.$objeto_dameOperador->Nombre.'">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="actualizar-user.php?upd='.$objeto_dameOperador->IdOperador.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>';

                                break;

                } else {

                    $txt_resultado = "No existe el usuario Nº: $numero";

                }

            }


        } 

/* echo $txt_resultado; */

die (json_encode(array('status' => $txt_resultado)));

?>