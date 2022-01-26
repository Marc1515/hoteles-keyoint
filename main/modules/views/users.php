<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-users.php') ?>


<body class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php /* require('preloader.php') */ ?>
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php require('header.php') ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php require('left-sidebar.php')?>
        <?php require('./../ws/ws_users/ws_dameUsuarios.php') ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Datatable</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Datatable</li>
                            </ol>
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Create New</button>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->
                <div class="row pt-3">
                    <div class="col-12">
                        <!-- table responsive -->
                        <div class="card">
                            <div class="card-body">

                                <?php
                                
                                if(isset($_GET['error'])){

                                    if($_GET['error'] == 0) {
                                        echo 
                                        '   <div class="row d-flex justify-content-end">
                                                <div class="col-3 d-flex justify-content-end">
                                                    <div class="alert alert-success animated bounceInRight"> <i class="ti-user"></i> El Usuario se ha creado correctamente.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>
                                                </div>
                                            </div> ';
                                    } elseif ($_GET['error'] == 2) {
                                        echo 
                                        '   <div class="row d-flex justify-content-end">
                                                <div class="col-3 d-flex justify-content-end">
                                                    <div class="alert alert-warning animated bounceInRight"> <i class="ti-user"></i> El Usuario se ha editado correctamente.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>
                                                </div>
                                            </div> ';
                                    } elseif ($_GET['error'] == 3) {
                                        echo 
                                        '   <div class="row d-flex justify-content-end">
                                                <div class="col-3 d-flex justify-content-end">
                                                    <div class="alert alert-danger animated bounceInRight"> <i class="ti-user"></i> El Usuario se ha borrado correctamente.
                                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                    </div>
                                                </div>
                                            </div> ';
                                    }

                                }
                                
                                        
                                ?>
                                    

                                <div id="respuesta"></div>


                                <div class="row">
                                    <form id="searchUsersPorOperador" class="col-12 col-sm-12 col-md-12 col-lg-11" method="POST">
                                        <div class="row">
                                            <div class="col-12 col-sm-12 col-md-12 col-lg-2">
                                                <h4 class="card-title">Lista de Usuarios</h4>
                                            </div>

                                            <div <?php echo $ocultarBuscarOperador ?> class="col-12 col-sm-12 col-md-12 col-lg-2">
                                                <div class="form-group">
                                                    <select class="custom-select" id="inlineFormCustomSelect" name="idOperador" data-toggle="tooltip" data-placement="bottom" title="Operador">

                                                        <?php 
                                                        
                                                            require './../ws/ws_operadores/ws_dameOperadores.php';

                                                            for ($step=0; $step<count($operadoresArray); $step++) {


                                                                $operadorSeleccionado = '';

                                                                if ($operadoresArray[$step]) {

                                                                    $operadorSeleccionado = '';

                                                                }

                                                                echo '

                                                                    <option '.$operadorSeleccionado.' value="'.$operadoresArray[$step]->IdOperador.'">'.$operadoresArray[$step]->Nombre.'</option>
                                                                
                                                                ';
                                                            }

                                                        ?>

                                                    </select>
                                                </div>
                                            </div>

                                            <div <?php echo $ocultarBuscarOperador ?> class="col-12 col-sm-12 col-md-12 col-lg-8">
                                                <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                            </div>

                                        </div>
                                        
                                    </form>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-1">
                                        <a href="crear-user.php"><button type="button" class="btn btn-info waves-effect waves-light mr-1">Nuevo Usuario</button></a>
                                    </div>
                                </div>

                                <div class="table-responsive m-t-40">
                                    <table id="config-table" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Nº</th>
                                                <th>Nombre</th>
                                                <th>NombreUsuario</th>
                                                <th>Rol</th>
                                                <th>Email</th>
                                                <th>Movil</th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 
                                        
                                        
                                        if(!is_array($usersArray) && !is_null($usersArray)) {
                                        

                                            if ($usersArray->IdOperador !== 0) {


                                                if($usersArray->IdRol === 1) {

                                                    $rol = "Administrador";

                                                } else if ($usersArray->IdRol === 2) {

                                                    $rol = "Usuario";

                                                }


                                                echo    
                                                '   <tr>
                                                        <td>'.$usersArray->IdUsuario.'</td>
                                                        <td>'.$usersArray->Nombre.'</td>
                                                        <td>'.$usersArray->NombreUsuario.'</td>
                                                        <td>'.$rol.'</td>
                                                        <td>'.$usersArray->Email.'</td>
                                                        <td>'.$usersArray->Movil.'</td>
                                                        <td class="d-flex justify-content-center">

                                                        <!------------ BOTON VER ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <!-- Button trigger modal -->
                                                        <button title="Ver" type="button" class="btn btn-xs btn-success mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#verReserva'.$usersArray->IdUsuario.'">
                                                        <i style="font-size: 1rem" class="mdi mdi-eye-outline"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="verReserva'.$usersArray->IdUsuario.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <i style="font-size: 1.25rem;" class="fas fa-user mr-3"></i><h5 class="modal-title" id="exampleModalLabel"><strong>'.$usersArray->NombreUsuario.'</strong></h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <h4 class="mb-3">Características del Usuario:</h4>
                                                                        <ul>
                                                                            <li><p><strong>Número de Usuario: </strong>'.$usersArray->IdUsuario.'</p></li>
                                                                            <li><p><strong>Nombre y Apellidos: </strong>'.$usersArray->Nombre.'</p></li>
                                                                            <li><p><strong>Nombre de Usuario: </strong>'.$usersArray->NombreUsuario.'</p></li>
                                                                            <li><p><strong>Contraseña: </strong>'.$usersArray->Pwd.'</p></li>
                                                                            <li><p><strong>Rol: </strong>'.$rol.'</p></li>
                                                                            <li><p><strong>Email: </strong>'.$usersArray->Email.'</p></li>
                                                                            <li><p><strong>Movil: </strong>'.$usersArray->Movil.'</p></li>
                                                                            <li><p><strong>Pin: </strong>'.$usersArray->PinSeguridad.'</p></li>

                                                                            
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!------------ BOTON EDITAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <a href="actualizar-user.php?upd='.$usersArray->IdUsuario.'"><button title="Editar" class="btn btn-xs btn-info mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light"><i style="font-size: 1rem" class="mdi mdi-pencil"></i></button></a>

                                                        <!------------ BOTON ANULAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <!-- Button trigger modal -->
                                                        <button title="Anular" type="button" class="btn btn-xs btn-warning mr-2 p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#borrarReserva'.$usersArray->IdUsuario.'" data-id_res="'.$usersArray->IdUsuario.'" data-nombre="'.$usersArray->Nombre.'"><i style="font-size: 1rem" class="mdi mdi-close"></i></button>
                                                        
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="borrarReserva'.$usersArray->IdUsuario.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel">Borrar Usuario</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Borrar al usuario '.$usersArray->Nombre.'?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="eliminar_usuario_validate.php" method="POST">
                                                                            <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$usersArray->IdUsuario.'">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-danger text-white" data-id_res="'.$usersArray->IdUsuario.'" data-nombre="'.$usersArray->Nombre.'">Confirmar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                
                                                        </td>
                                                    </tr>';
                                                
                                                }
                                        
                                        
                                        
                                        
                                        } elseif (is_array($usersArray)) {

                                            for ($step=0; $step<count($usersArray); $step++) { 
                                                
                                                if ($usersArray[$step]->IdOperador != 0) {
                                            

                                                    if($usersArray[$step]->IdRol === 1) {

                                                        $rol = "Administrador";

                                                    } else if ($usersArray[$step]->IdRol === 2) {

                                                        $rol = "Usuario";

                                                    }

                                                    echo    
                                                    '   <tr>
                                                            <td>'.$usersArray[$step]->IdUsuario.'</td>
                                                            <td>'.$usersArray[$step]->Nombre.'</td>
                                                            <td>'.$usersArray[$step]->NombreUsuario.'</td>
                                                            <td>'.$rol.'</td>
                                                            <td>'.$usersArray[$step]->Email.'</td>
                                                            <td>'.$usersArray[$step]->Movil.'</td>
                                                            <td class="d-flex justify-content-center">

                                                            <!------------ BOTON VER ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button title="Ver" type="button" class="btn btn-xs btn-success mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#verReserva'.$usersArray[$step]->IdUsuario.'">
                                                            <i style="font-size: 1rem" class="mdi mdi-eye-outline"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="verReserva'.$usersArray[$step]->IdUsuario.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <i style="font-size: 1.25rem;" class="fas fa-user mr-3"></i><h5 class="modal-title" id="exampleModalLabel"><strong>'.$usersArray[$step]->NombreUsuario.'</strong></h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <h4 class="mb-3">Características del Usuario:</h4>
                                                                            <ul>
                                                                                <li><p><strong>Número de Usuario: </strong>'.$usersArray[$step]->IdUsuario.'</p></li>
                                                                                <li><p><strong>Nombre y Apellidos: </strong>'.$usersArray[$step]->Nombre.'</p></li>
                                                                                <li><p><strong>Nombre de Usuario: </strong>'.$usersArray[$step]->NombreUsuario.'</p></li>
                                                                                <li><p><strong>Contraseña: </strong>'.$usersArray[$step]->Pwd.'</p></li>
                                                                                <li><p><strong>Rol: </strong>'.$rol.'</p></li>
                                                                                <li><p><strong>Email: </strong>'.$usersArray[$step]->Email.'</p></li>
                                                                                <li><p><strong>Movil: </strong>'.$usersArray[$step]->Movil.'</p></li>
                                                                                <li><p><strong>Pin: </strong>'.$usersArray[$step]->PinSeguridad.'</p></li>

                                                                                
                                                                            </ul>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!------------ BOTON EDITAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <a href="actualizar-user.php?upd='.$usersArray[$step]->IdUsuario.'"><button title="Editar" class="btn btn-xs btn-info mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light"><i style="font-size: 1rem" class="mdi mdi-pencil"></i></button></a>

                                                            <!------------ BOTON ANULAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button title="Anular" type="button" class="btn btn-xs btn-warning mr-2 p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#borrarReserva'.$usersArray[$step]->IdUsuario.'" data-id_res="'.$usersArray[$step]->IdUsuario.'" data-nombre="'.$usersArray[$step]->Nombre.'"><i style="font-size: 1rem" class="mdi mdi-close"></i></button>
                                                            
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="borrarReserva'.$usersArray[$step]->IdUsuario.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel">Borrar Usuario</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Borrar al usuario '.$usersArray[$step]->Nombre.'?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="eliminar_usuario_validate.php" method="POST">
                                                                                <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$usersArray[$step]->IdUsuario.'">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$usersArray[$step]->IdUsuario.'" data-nombre="'.$usersArray[$step]->Nombre.'">Confirmar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                    
                                                            </td>
                                                        </tr>';

                                                    }

                                                }

                                        } else {



                                        }
                                        
                                        
                                        
                                        ?>
                                        </tbody>
                                    </table>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>                                                  
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php require('right-sidebar.php') ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php require('footer.php') ?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../../assets/node_modules/popper/popper.min.js"></script>
    <script src="../../../assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../../../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../../../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../../dist/js/custom.min.js"></script>
    <!-- This is data table -->
    <script src="../../../assets/node_modules/datatables.net/js/jquery.dataTables.js"></script> <!-- este -->
    <script src="../../../assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <!-- <script src="../js/mostrarNumPorUser.js"></script> -->
    <!-- end - This is for export functionality only -->
    <script>
        $(function () {
            /*$('#myTable').DataTable();
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            });*/
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });

            $('#config-table').DataTable({
                responsive: true,
				"columns": [{ "searchable": false },{ "searchable": true },{ "searchable": true },{ "searchable": false },{ "searchable": false },{ "searchable": false },{ "searchable": false }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    </script>
    <script src="./../js/user_alerts.js"></script>
    <script src="./../js/lista-reservas.js"></script>
    <script src="./../js/filtrarUsuariosPorOperador.js"></script>
</body>

</html>