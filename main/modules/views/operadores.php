<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-lista-operadores.php') ?>


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
        <?php require('./../ws/ws_operadores/ws_dameOperadores.php') ?>
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

                            <div class="row d-flex justify-content-between mx-2">
                                <div>
                                    <h4 class="card-title">Lista de Operadores</h4>
                                    <h6 class="card-subtitle">Todos</h6>
                                </div>
                                
                                <a href="crear-operador.php"><button type="button" class="btn btn-info waves-effect waves-light mr-1">Nuevo Operador</button></a>
                            </div>

                                <div class="table-responsive m-t-40">
                                    <table id="config-table" class="table display table-bordered table-striped no-wrap">
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
                                        <?php for($step = 0; $step < count($operadoresArray); $step++) {


                                            echo    
                                            '   <tr>
                                                    <td>'.$operadoresArray[$step]->IdOperador.'</td>
                                                    <td>'.$operadoresArray[$step]->Nombre.'</td>
                                                    <td>'.$operadoresArray[$step]->Email.'</td>
                                                    <td>'.$operadoresArray[$step]->Movil.'</td>
                                                    <td class="d-flex justify-content-center">

                                                    <!------------ BOTON VER ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Button trigger modal -->
                                                    <button title="Ver" type="button" class="btn btn-xs btn-success mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#verReserva'.$operadoresArray[$step]->IdOperador.'">
                                                    <i style="font-size: 1rem" class="mdi mdi-eye-outline"></i>
                                                    </button>

                                                    <!-- Modal -->
                                                    <div class="modal fade" id="verReserva'.$operadoresArray[$step]->IdOperador.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <i style="font-size: 1.25rem;" class="fas fa-house-user mr-3"></i><h5 class="modal-title" id="exampleModalLabel"><strong>'.$operadoresArray[$step]->Nombre.'</strong></h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                <h4 class="mb-3">Características del Operador:</h4>
                                                                    <ul>
                                                                        <li><p><strong>ID del Locker: </strong>'.$operadoresArray[$step]->IdLocker.'</p></li>
                                                                        <li><p><strong>ID del Operador: </strong>'.$operadoresArray[$step]->IdOperador.'</p></li>
                                                                        <li><p><strong>Nombre: </strong>'.$operadoresArray[$step]->Nombre.'</p></li>
                                                                        <li><p><strong>Email: </strong>'.$operadoresArray[$step]->Email.'</p></li>
                                                                        <li><p><strong>Movil: </strong>'.$operadoresArray[$step]->Movil.'</p></li>

                                                                        
                                                                    </ul>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!------------ BOTON EDITAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <a href="actualizar-operador.php?upd='.$operadoresArray[$step]->IdOperador.'"><button title="Editar" class="btn btn-xs btn-info mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light"><i style="font-size: 1rem" class="mdi mdi-pencil"></i></button></a>
              
                                                    <!------------ BOTON ANULAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    <!-- Button trigger modal -->
                                                    <button title="Anular" type="button" class="btn btn-xs btn-warning mr-2 p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#borrarReserva'.$operadoresArray[$step]->IdOperador.'" data-id_res="'.$operadoresArray[$step]->IdOperador.'" data-nombre="'.$operadoresArray[$step]->Nombre.'"><i style="font-size: 1rem" class="mdi mdi-close"></i></button>
                                                    
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="borrarReserva'.$operadoresArray[$step]->IdOperador.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="exampleModalLabel">Borrar Usuario</h5>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    Borrar al usuario '.$operadoresArray[$step]->Nombre.'?
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <form action="eliminar_operador_validate.php" method="POST">
                                                                        <input type="hidden" id="del_id_oper" name="del_id_oper" value="'.$operadoresArray[$step]->IdOperador.'">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                        <button type="submit" class="btn btn-danger text-white" data-id_res="'.$operadoresArray[$step]->IdOperador.'" data-nombre="'.$operadoresArray[$step]->Nombre.'">Confirmar</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </td>
                                                </tr>';
                                            
                                        } ?>
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
    <script src="../js/mostrarOperadorPorNum.js"></script>
    <!-- end - This is for export functionality only -->
    <script>
        $(function () {
            $('#myTable').DataTable();
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
            });
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