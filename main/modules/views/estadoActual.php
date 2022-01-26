<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-estadoActual.php') ?>


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
        <?php require './../ws/ws_informes/ws_dameEstadoLockerPorOperadorFecha.php' ?>

        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php require('left-sidebar.php')?>
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
                    <div class="col-12 d-flex">
                        <!-- table responsive -->
                        <div class="card row w-100">
                            <div class="card-body col-12">
                                <h4 class="card-title">Estado Actual</h4>     
                                <form <?php echo $ocultarBuscarOperador ?> method="POST" id="formSearchEstadosActuales" class="row">

                                    <div class="col-10 col-sm-2">
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

                                    <div class="col-2 col-sm-10">
                                        <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table color-table info-table">
                                        <thead>
                                            <tr>
                                                <th>Nº Puerta</th>
                                                <th>Tipo de Puerta</th>
                                                <th>Estado</th>
                                                <th>Nº Reserva</th>
                                                <th>NombreReserva</th>
                                                <th>Localizador</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>


                                        <?php

                                        if ($array_dameEstadoLockerPorOperadorFecha->IdPuerta) {

                                                if ($array_dameEstadoLockerPorOperadorFecha->Estado == 0) {

                                                    $estado = 'Libre';
                                                    $colorEstado = 'class="label label-success"';

                                                } elseif ($array_dameEstadoLockerPorOperadorFecha->Estado == 1) {

                                                    $estado = 'Reservada';
                                                    $colorEstado = 'class="label label-warning"';

                                                }

                                                
                                                if ($array_dameEstadoLockerPorOperadorFecha->IdPuerta == 0) {

                                                    $nReserva = '';

                                                } else {

                                                    $nReserva = $array_dameEstadoLockerPorOperadorFecha->IdReserva;

                                                }


                                                echo '
                                                
                                                <tr>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha->NombrePuerta.'</td>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha->TipoPuerta.'</td>
                                                    <td><span '.$colorEstado.'>'.$estado.'</span></td>
                                                    <td>'.$nReserva.'</td>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha->NombreReserva.'</td>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha->Localizador.'</td>
                                                    <td> 
                                                    <!------------ BOTON ABRIR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-xs btn-info mr-2 px-1 waves-effect waves-light" data-toggle="modal" data-target="#abrirPuerta'.$array_dameEstadoLockerPorOperadorFecha->IdPuerta.'" data-id_res="'.$array_dameEstadoLockerPorOperadorFecha->IdPuerta.'" data-nombre="'.$array_dameEstadoLockerPorOperadorFecha->NombrePuerta.'"><i class="fas fa-door-open" style="font-size: 1rem" data-toggle="tooltip" title="Abrir Puerta"></i></button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="abrirPuerta'.$array_dameEstadoLockerPorOperadorFecha->IdPuerta.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><strong>Abrir</strong> Puerta</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    ¿Està seguro que quiere abrir la puerta '.$array_dameEstadoLockerPorOperadorFecha->NombrePuerta.' ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="abrirPuerta_validate.php" method="POST">
                                                                        <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$array_dameEstadoLockerPorOperadorFecha->IdPuerta.'">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger text-white" data-id_res="'.$array_dameEstadoLockerPorOperadorFecha->IdPuerta.'" data-nombre="'.$array_dameEstadoLockerPorOperadorFecha->NombrePuerta.'">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </td>
                                                    
                                                </tr>';

                                            

                                        } elseif (is_array($array_dameEstadoLockerPorOperadorFecha)) {

                                            for ($step=0; $step<count($array_dameEstadoLockerPorOperadorFecha); $step ++) {

                                                if ($array_dameEstadoLockerPorOperadorFecha[$step]->Estado == 0) {

                                                    $estado = 'Libre';
                                                    $colorEstado = 'class="label label-success"';

                                                } elseif ($array_dameEstadoLockerPorOperadorFecha[$step]->Estado == 1) {

                                                    $estado = 'Reservada';
                                                    $colorEstado = 'class="label label-warning"';

                                                }

                                                
                                                if ($array_dameEstadoLockerPorOperadorFecha[$step]->IdReserva == 0) {

                                                    $nReserva = '';

                                                } else {

                                                    $nReserva = $array_dameEstadoLockerPorOperadorFecha[$step]->IdReserva;

                                                }


                                                echo '
                                                
                                                <tr>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha[$step]->NombrePuerta.'</td>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha[$step]->TipoPuerta.'</td>
                                                    <td><span '.$colorEstado.'>'.$estado.'</span></td>
                                                    <td>'.$nReserva.'</td>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha[$step]->NombreReserva.'</td>
                                                    <td>'.$array_dameEstadoLockerPorOperadorFecha[$step]->Localizador.'</td>
                                                    <td> 
                                                    <!------------ BOTON ABRIR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Button trigger modal -->
                                                    <button type="button" class="btn btn-xs btn-info mr-2 px-1 waves-effect waves-light" data-toggle="modal" data-target="#abrirPuerta'.$array_dameEstadoLockerPorOperadorFecha[$step]->IdPuerta.'" data-id_res="'.$array_dameEstadoLockerPorOperadorFecha[$step]->IdPuerta.'" data-nombre="'.$array_dameEstadoLockerPorOperadorFecha[$step]->NombrePuerta.'"><i style="font-size: 1rem" data-toggle="tooltip" title="Abrir Puerta" class="fas fa-door-open"></i></button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="abrirPuerta'.$array_dameEstadoLockerPorOperadorFecha[$step]->IdPuerta.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel"><strong>Abrir</strong> Puerta</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    ¿Està seguro que quiere abrir la puerta '.$array_dameEstadoLockerPorOperadorFecha[$step]->NombrePuerta.' ?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="abrirPuerta_validate.php" method="POST">
                                                                        <input type="hidden" id="del_id_usr" name="idPuerta" value="'.$array_dameEstadoLockerPorOperadorFecha[$step]->IdPuerta.'">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger text-white" data-id_res="'.$array_dameEstadoLockerPorOperadorFecha[$step]->IdPuerta.'" data-nombre="'.$array_dameEstadoLockerPorOperadorFecha[$step]->NombrePuerta.'">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </td>
                                                    
                                                </tr>';

                                            }

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
    <script src="../../../assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script src="../js//filtrarEstadosActuales.js"></script>

    <!-- end - This is for export functionality only -->
    <script>
        $(function () {
           /*  $('#myTable').DataTable();
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
            }); */
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
				"columns": [{ "searchable": false },{ "searchable": true },{ "searchable": true },{ "searchable": false },{ "searchable": false },{ "searchable": false },{ "searchable": true },{ "searchable": false }],
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
    
</body>

</html>