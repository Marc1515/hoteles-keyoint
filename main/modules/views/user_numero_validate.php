<?php

require ('../ws/ws_users/ws2.php');

$txt_resultado = '';

$numero = $_POST['num'];


if(isset($numero)) {

    // --- LLAMAR WS : DameUsuarios --------------------------------------------------------------------------------------------------------------------------------------------------->
    $parametros_dameUsuarios = array('token'=>$token_ws, 'idlocker'=>11051, 'idOperador'=>1,  'OrdenAoN'=>'A', 'idrol'=>0);
    $soap_result_DU = $client->DameUsuarios($parametros_dameUsuarios);

    $usersArray = $soap_result_DU->DameUsuariosResult->Usuario;

    
    
    for($step=0; $step<count($usersArray); $step++){
        
        if($usersArray[$step]->IdUsuario==$numero) {
            
            // --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>11051, 'IdOperador'=>1,  'IdUsuario'=>$numero);
            $soap_result_DU = $client->DameUsuario($parametros_dameUsuario);
            
            
            $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;


            if($objeto_dameUsuario->IdRol === 1) {

                $rol = "Administrador";

            } else if ($objeto_dameUsuario->IdRol === 2) {

                $rol = "Usuario";

            }

    
            $txt_resultado =   '<div class="table-responsive m-t-40">
                                    <table id="config-table" class="table display table-bordered table-striped no-wrap mt-3">
                                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Nombre</th>
                                                <th>NombreUsuario</th>
                                                <th>Pwd</th>
                                                <th>Rol</th>
                                                <th>Email</th>
                                                <th>Movil</th>
                                                <th>PinSeguridad</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>'.$objeto_dameUsuario->IdUsuario.'</td>
                                                <td>'.$objeto_dameUsuario->Nombre.'</td>
                                                <td>'.$objeto_dameUsuario->NombreUsuario.'</td>
                                                <td>'.$objeto_dameUsuario->Pwd.'</td>
                                                <td>'.$rol.'</td>
                                                <td>'.$objeto_dameUsuario->Email.'</td>
                                                <td>'.$objeto_dameUsuario->Movil.'</td>
                                                <td>'.$objeto_dameUsuario->PinSeguridad.'</td>
                                                <td class="d-flex justify-content-center">
                                            
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-xs btn-info mr-2" data-toggle="modal" data-target="#borrarReserva'.$objeto_dameUsuario->IdUsuario.'" data-id_res="'.$objeto_dameUsuario->IdUsuario.'" data-nombre="'.$objeto_dameUsuario->Nombre.'"><i class="mdi mdi-close"></i></button>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="borrarReserva'.$objeto_dameUsuario->IdUsuario.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Borrar Reserva</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Borrar la reserva de '.$objeto_dameUsuario->Nombre.'?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="eliminar_reserva_validate.php" method="POST">
                                                                        <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$objeto_dameUsuario->IdUsuario.'">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger text-white" data-id_res="'.$objeto_dameUsuario->IdUsuario.'" data-nombre="'.$objeto_dameUsuario->Nombre.'">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="actualizar-user.php?upd='.$objeto_dameUsuario->IdUsuario.'"><button class="btn btn-xs btn-info"><i class="fas fa-pen-square"></i></button></a>
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


die (json_encode(array('status' => $txt_resultado)));

?>