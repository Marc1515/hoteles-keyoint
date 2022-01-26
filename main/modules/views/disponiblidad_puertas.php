<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-lista-reserva.php') ?>


<body class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php require('preloader.php') ?>
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
        <?php require('../ws/ws_reservas/ws_dameReservaPorOperador.php') ?>
        <?php require('../ws/ws_users/ws_dameUsuarios.php') ?>

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
                                <div class="row">
                                    <div class="col-4">
                                        <form action="disponiblidad_puertas_validate.php" method="POST" id="formSearchPuertas">
                                            <div class="form-group mr-3 d-flex">
                                                <input class="form-control" type="date" value="<?php echo date("Y-m-d") ?>" name="fecha" id="example-date-input">   
                                                
                                                <button type="submit" data-toggle="tooltip" data-placement="right" title="Buscar Fechas" class="btn btn-info btn-circle ml-3"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>



                                <div class="table-responsive">
                                    <table id="config-table" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Nº Puerta</th>
                                                <th>Activa</th>
                                                <th>Tipo Puerta</th>
                                                <th>Posición</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php

                                        $fechaForm = '';
                                        
                                        require ('./../ws/ws_reservas/ws_dameDisponiblesCupoFecha.php');
                                        
                                        if (isset($disponiblesCuposFecha_array)) {
                                        
                                            for($step = 0; $step<count($disponiblesCuposFecha_array); $step++) {

                                                echo    
                                                '   <tr>
                                                        <td><p>'.$disponiblesCuposFecha_array[$step]->IdPuerta.'</p></td>
                                                        <td><p>'.$disponiblesCuposFecha_array[$step]->Activa.'</p></td>
                                                        <td><p>'.$disponiblesCuposFecha_array[$step]->IdTipoPuerta.'</p></td>
                                                        <td><p>'.$disponiblesCuposFecha_array[$step]->Posicion.'</p></td>

                                                        <td class="d-flex">

                                                            <!------------ BOTON EDITAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <a href="actualizar-reserva.php?upd='.$disponiblesCuposFecha_array[$step]->IdPuerta.'"><button class="btn btn-xs btn-info mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light"><i data-toggle="tooltip" title="Editar" style="font-size: 1rem" class="mdi mdi-pencil"></i></button></a>
                                                            
                                                            <!------------ BOTON ANULAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-xs btn-warning mr-2 p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#borrarReserva'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" data-id_res="'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" data-nombre="'.$disponiblesCuposFecha_array[$step]->Nombre.'"><i data-toggle="tooltip" title="Anular"  style="font-size: 1rem" class="mdi mdi-close"></i></button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="borrarReserva'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Anular</strong> Reserva</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Anular la reserva de <strong>'.$disponiblesCuposFecha_array[$step]->Nombre.'</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="eliminar_reserva_validate.php" method="POST">
                                                                                <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$disponiblesCuposFecha_array[$step]->IdPuerta.'">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" data-nombre="'.$disponiblesCuposFecha_array[$step]->Nombre.'">Confirmar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                    
                                                            <!------------ BOTON CHECK-OUT ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-xs btn-danger p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#confirmarReserva'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" data-id_res="'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" data-nombre="'.$disponiblesCuposFecha_array[$step]->Nombre.'"><i data-toggle="tooltip" title="Confirmar"  style="font-size: 1rem" class="mdi mdi-check iconos"></i></button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="confirmarReserva'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Confirmar</strong> Reserva</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Confirmar la reserva de <strong>'.$disponiblesCuposFecha_array[$step]->Nombre.'</strong> como <strong>"Salida"</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="checkOut_validate.php?upd='.$disponiblesCuposFecha_array[$step]->IdPuerta.'" method="POST">
                                                                                <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$disponiblesCuposFecha_array[$step]->IdPuerta.'">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$disponiblesCuposFecha_array[$step]->IdPuerta.'" data-nombre="'.$disponiblesCuposFecha_array[$step]->Nombre.'">Confirmar</button>
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
    <!-- <script src="./../js/disponiblidad_puertas.js"></script> -->
    
</body>

</html>