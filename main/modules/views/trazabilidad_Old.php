<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-trazabilidad.php') ?>

<?php if ($_GET) {

    $idReserva = $_GET['upd'];

} ?>


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
        <?php require './../ws/ws_reservas/ws_dameAperturasPorReserva.php' ?>

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
                                <form method="POST" id="formSearchTrazabilidad" class="row">

                                    <div class="col-12 col-sm-2">
                                        <h4 class="card-title">Trazabilidad</h4>                                   
                                    </div>

                                    <div class="col-12 col-sm-2">
                                        <div <?php echo $ocultarBuscarOperador ?> class="form-group">
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

                                    <div class="form-group col-12 col-sm-2" id="grupo__referencia">
                                        <input type="text" class="form-control form-control-line" value="<?php echo $_GET['upd'] ?>" name="idReserva" id="referencia" placeholder="Ingresa el Nº de reserva" required data-validation-required-message="This field is required">
                                    </div>

                                    <div class="col-12 col-sm-6 mb-4">
                                        <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="float-right float-sm-left btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table color-table info-table">
                                        <thead>
                                            <tr>
                                                <th>Fecha y Hora</th>
                                                <th>Nº Reserva</th>
                                                <th>Acción</th>
                                                <th>Nombre</th>
                                                <th>Puerta</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php

                                        require './../ws/ws_users/ws_dameUsuarios.php';
                                        require './../ws/ws_reservas/ws_dameReservaPorOperador_trazabilidad.php';


                                        if(!is_array($array_dameAperturasPorReserva) && !is_null($array_dameAperturasPorReserva)) {

                                            
                                            if($array_dameAperturasPorReserva->Tipo === 1) {

                                                $accion = "Entregado";

                                                for ($step=0; $step<count($usersArray); $step++) {

                                                    if ($array_dameAperturasPorReserva->IdUsuario === $usersArray[$step]->IdUsuario) {

                                                        $nombre = $usersArray[$step]->Nombre;

                                                    }

                                                }

                                            } elseif ($array_dameAperturasPorReserva->Tipo === 2) {

                                                $accion = "Recogido";

                                                if (!is_array($reservasArray) && !is_null($reservasArray)) {

                                                    if ($array_dameAperturasPorReserva->IdReserva === $reservasArray->IdReserva) {

                                                        $nombre = $reservasArray->Nombre;

                                                    }

                                                } elseif (is_array($reservasArray)) {

                                                    for ($step2=0; $step2<count($reservasArray) ; $step2++) { 

                                                        if ($array_dameAperturasPorReserva->IdReserva === $reservasArray[$step2]->IdReserva) {
                                                            
                                                            $nombre = $reservasArray[$step2]->Nombre;

                                                        }

                                                    }

                                                } else {
                                                    // Objeto Vacio!
                                                }

                                            } elseif ($array_dameAperturasPorReserva->Tipo === 9) {

                                                $accion = "Apertura Manual";

                                                if (!is_array($usersArray) && !is_null($usersArray)) {

                                                    if ($array_dameAperturasPorReserva->IdUsuario === $usersArray->IdUsuario) {
                                                            
                                                        $nombre = $usersArray->NombreUsuario;

                                                    }

                                                } elseif (is_array($usersArray)) {

                                                    for ($step3=0; $step3<count($usersArray) ; $step3++) { 
                                                        
                                                        if ($array_dameAperturasPorReserva->IdUsuario === $usersArray[$step3]->IdUsuario) {
                                                            
                                                            $nombre = $usersArray[$step3]->NombreUsuario;

                                                        }

                                                    }

                                                } else {

                                                    // Objeto Vacio!

                                                }

                                            }

                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_dameAperturasPorReserva->Fecha));



                                            echo '
                                                
                                            <tr>
                                                <td>'.$fecha.'</td>
                                                <td>'.$array_dameAperturasPorReserva->IdReserva.'</td>
                                                <td>'.$accion.'</td>
                                                <td>'.$nombre.'</td>
                                                <td>'.$array_dameAperturasPorReserva->IdPuerta.'</td>
                                            </tr>';



                                            

                                        } elseif (is_array($array_dameAperturasPorReserva)) {

                                            for ($step=0; $step<count($array_dameAperturasPorReserva); $step++) {

                                                if ($array_dameAperturasPorReserva[$step]->Tipo === 2) {

                                                    if(!is_array($reservasArray) && !is_null($reservasArray)) {
                                                        

                                                        if ($array_dameAperturasPorReserva[$step]->IdReserva == $reservasArray[$step2]->IdReserva) {

                                                            $nombre = $reservasArray[$step2]->Nombre;

                                                        

                                                            if($array_dameAperturasPorReserva[$step]->Tipo === 1) {
                
                                                                $accion = "Entregado";
                
                                                            } elseif ($array_dameAperturasPorReserva[$step]->Tipo === 2) {
                
                                                                $accion = "Recogido";
                
                                                            } elseif ($array_dameAperturasPorReserva[$step]->Tipo === 9) {

                                                                $accion = "Apertura Manual";

                                                            }

                                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_dameAperturasPorReserva[$step]->Fecha));

                                                            echo '
                                                            
                                                            <tr>
                                                                <td>'.$fecha.'</td>
                                                                <td>'.$array_dameAperturasPorReserva[$step]->IdReserva.'</td>
                                                                <td>'.$accion.'</td>
                                                                <td>'.$nombre.'</td>
                                                                <td>'.$array_dameAperturasPorReserva[$step]->IdPuerta.'</td> 
                                                            </tr>';

                                                        }

                                                        
                                                    } elseif (is_array($reservasArray)) {

                                                        for ($step2=0; $step2<count($reservasArray); $step2++) {           


                                                            if ($array_dameAperturasPorReserva[$step]->IdReserva == $reservasArray[$step2]->IdReserva) {

                                                                $nombre = $reservasArray[$step2]->Nombre;

                                                            

                                                                if($array_dameAperturasPorReserva[$step]->Tipo === 1) {
                    
                                                                    $accion = "Entregado";
                    
                                                                } elseif ($array_dameAperturasPorReserva[$step]->Tipo === 2) {
                    
                                                                    $accion = "Recogido";
                    
                                                                }

                                                                $fecha = date("d-m-Y - H:i:s:A", strtotime($array_dameAperturasPorReserva[$step]->Fecha));

                                                                echo '
                                                                
                                                                <tr>
                                                                    <td>'.$fecha.'</td>
                                                                    <td>'.$array_dameAperturasPorReserva[$step]->IdReserva.'</td>
                                                                    <td>'.$accion.'</td>
                                                                    <td>'.$nombre.'</td>
                                                                    <td>'.$array_dameAperturasPorReserva[$step]->IdPuerta.'</td> 
                                                                </tr>';

                                                            }
                                                    
                                                        }
                                                    }

                                                } elseif ( $array_dameAperturasPorReserva[$step]->Tipo == 1) {

                                                    
                                                    /* var_dump($usersArray); */
                                                    for ($step3=0; $step3<count($usersArray); $step3++) {

                                                        if ($array_dameAperturasPorReserva[$step]->IdUsuario == $usersArray[$step3]->IdUsuario) {

                                                            $nombre = $usersArray[$step3]->Nombre;

                                                            
                                                            if($array_dameAperturasPorReserva[$step]->Tipo === 1) {
                
                                                                $accion = "Entregado";
                
                                                            } elseif ($array_dameAperturasPorReserva[$step]->Tipo === 2) {
                
                                                                $accion = "Recogido";
                
                                                            }

                                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_dameAperturasPorReserva[$step]->Fecha));

                                                            echo '
                                                            
                                                            <tr>
                                                                <td>'.$fecha.'</td>
                                                                <td>'.$array_dameAperturasPorReserva[$step]->IdReserva.'</td>
                                                                <td>'.$accion.'</td>
                                                                <td>'.$nombre.'</td>
                                                                <td>'.$array_dameAperturasPorReserva[$step]->IdPuerta.'</td> 
                                                            </tr>';

                                                        }

                                                    }
                                    
                                                }

                                            }

                                        } else {

                                            // Objeto Vacio!

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

    <script src="../js//filtrarTrazabilidad.js"></script>

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