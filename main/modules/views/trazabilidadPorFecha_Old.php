<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-trazabilidad.php') ?>


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
                                <form method="POST" id="formSearchTrazabilidadPorFecha" class="row">

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                                        <h4 class="card-title">Trazabilidad</h4>                                   
                                    </div>


                                    <div class="col-12 col-sm-12 col-md-12 col-lg-2">
                                        <div class="form-group">
                                            <input class="form-control" type="date" value="<?php if (isset($_POST['desde_trazabilidad'])) { $_SESSION['desde_trazabilidad'] = $_POST['desde_trazabilidad']; echo $_POST['desde_trazabilidad']; } elseif(isset($_SESSION['desde_trazabilidad'])) { echo $_SESSION['desde_trazabilidad']; } else { echo date("Y-m-d"); } ?>" name="desde_trazabilidad" id="example-date-input" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada desde_trazabilidad">   
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-2">
                                        <div class="form-group">
                                            <input class="form-control" type="date" value="<?php if (isset($_POST['hasta_trazabilidad'])) { $_SESSION['hasta_trazabilidad'] = $_POST['hasta_trazabilidad']; echo $_POST['hasta_trazabilidad']; } elseif(isset($_SESSION['hasta_trazabilidad'])) { echo $_SESSION['hasta_trazabilidad']; } else { $hoy = time(); $quinceDiasEnSegundos = 24*60*60*15; $quinceDias=$hoy+$quinceDiasEnSegundos;  echo $quinceDias=date("Y-m-d", $quinceDias);} ?>" name="hasta_trazabilidad" id="example-date-input2" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada hasta_trazabilidad"> 
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-md-12 col-lg-4 mb-4">
                                        <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="float-right float-sm-none btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                    </div>
                                </form>

                                <?php require './../ws/ws_reservas/ws_dameAperturasEntreFechasPorOperador.php' ?>
                                
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

                                        

                                        if(!is_array($array_DameAperturasEntreFechasPorOperador) && !is_null($array_DameAperturasEntreFechasPorOperador)) {

                                            for ($step=0; $step<count($usersArray); $step++) {

                                                if ($array_DameAperturasEntreFechasPorOperador->IdUsuario === $usersArray[$step]->IdUsuario) {

                                                    $nombre = $usersArray[$step]->Nombre;


                                                }

                                            }

                                            if($array_DameAperturasEntreFechasPorOperador->Tipo === 1) {

                                                $accion = "Entregado";

                                            } elseif ($array_DameAperturasEntreFechasPorOperador->Tipo === 2) {

                                                $accion = "Recogido";

                                            } elseif ($array_DameAperturasEntreFechasPorOperador->Tipo === 9) {

                                                $accion = "Apertura Manual";

                                            }

                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador->Fecha));



                                            echo '
                                                
                                            <tr>
                                                <td>'.$fecha.'</td>
                                                <td>'.$array_DameAperturasEntreFechasPorOperador->IdReserva.'</td>
                                                <td>'.$accion.'</td>
                                                <td>'.$nombre.'</td>
                                                <td>'.$array_DameAperturasEntreFechasPorOperador->IdPuerta.'</td>
                                            </tr>';



                                            

                                        } elseif (is_array($array_DameAperturasEntreFechasPorOperador)) {
                                            
                                            for ($step=0; $step<count($array_DameAperturasEntreFechasPorOperador); $step++) {

                                                if ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {

                                                    if(!is_array($reservasArray) && !is_null($reservasArray)) {

                                                        if ($array_DameAperturasEntreFechasPorOperador[$step]->IdReserva == $reservasArray->IdReserva) {

                                                            $nombre = $reservasArray->Nombre;

                                                            if($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
                
                                                                $accion = "Entregado";
                
                                                            } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
                
                                                                $accion = "Recogido";
                
                                                            } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                                $accion = "Apertura Manual";

                                                            }

                                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                            echo '
                                                            
                                                            <tr>
                                                                <td>'.$fecha.'</td>
                                                                <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdReserva.'</td>
                                                                <td>'.$accion.'</td>
                                                                <td>'.$nombre.'</td>
                                                                <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                            </tr>';

                                                        }

                                                        
                                                    } elseif (is_array($reservasArray)) {

                                                        for ($step2=0; $step2<count($reservasArray); $step2++) {           

                                                            if ($array_DameAperturasEntreFechasPorOperador[$step]->IdReserva == $reservasArray[$step2]->IdReserva) {

                                                                $nombre = $reservasArray[$step2]->Nombre;

                                                                if($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
                    
                                                                    $accion = "Entregado";
                    
                                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
                    
                                                                    $accion = "Recogido";
                    
                                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                                    $accion = "Apertura Manual";

                                                                }

                                                                $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                                echo '
                                                                
                                                                <tr>
                                                                    <td>'.$fecha.'</td>
                                                                    <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdReserva.'</td>
                                                                    <td>'.$accion.'</td>
                                                                    <td>'.$nombre.'</td>
                                                                    <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                                </tr>';

                                                            }
                                                    
                                                        }
                                                    } else {

                                                        // Objeto Vacio!

                                                    }

                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo == 1) {

                                                    if (!is_array($usersArray) && !is_null($usersArray)) {

                                                        if($array_DameAperturasEntreFechasPorOperador[$step]->IdUsuario === $usersArray->IdUsuario) {

                                                            $nombre = $usersArray->Nombre;

                                                            if($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
                
                                                                $accion = "Entregado";
                
                                                            } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
                
                                                                $accion = "Recogido";
                
                                                            } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                                $accion = "Apertura Manual";

                                                            }

                                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                            echo '
                                                            
                                                            <tr>
                                                                <td>'.$fecha.'</td>
                                                                <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdReserva.'</td>
                                                                <td>'.$accion.'</td>
                                                                <td>'.$nombre.'</td>
                                                                <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                            </tr>';

                                                        }

                                                    } elseif (is_array($usersArray)) {

                                                        for ($step3=0; $step3<count($usersArray); $step3++) {

                                                            if ($array_DameAperturasEntreFechasPorOperador[$step]->IdUsuario === $usersArray[$step3]->IdUsuario) {

                                                                $nombre = $usersArray[$step3]->Nombre;

                                                                
                                                                if($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
                    
                                                                    $accion = "Entregado";
                    
                                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
                    
                                                                    $accion = "Recogido";
                    
                                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                                    $accion = "Apertura Manual";

                                                                }

                                                                $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                                echo '
                                                                
                                                                <tr>
                                                                    <td>'.$fecha.'</td>
                                                                    <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdReserva.'</td>
                                                                    <td>'.$accion.'</td>
                                                                    <td>'.$nombre.'</td>
                                                                    <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                                </tr>';

                                                            }

                                                        }

                                                    } else {

                                                        // Objeto Vacio!

                                                    }
                                    
                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                    if (!is_array($usersArray) && !is_null($usersArray)) {

                                                        if ($array_DameAperturasEntreFechasPorOperador[$step]->IdUsuario === $usersArray->IdUsuario) {

                                                            $nombre = $usersArray[$step4]->NombreUsuario;

                                                                
                                                            if($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
                
                                                                $accion = "Entregado";
                
                                                            } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
                
                                                                $accion = "Recogido";
                
                                                            } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                                $accion = "Apertura Manual";

                                                            }

                                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                            echo '
                                                            
                                                            <tr>
                                                                <td>'.$fecha.'</td>
                                                                <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdReserva.'</td>
                                                                <td>'.$accion.'</td>
                                                                <td>'.$nombre.'</td>
                                                                <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                            </tr>';

                                                        }

                                                    } elseif (is_array($usersArray)) {

                                                        for($step4=0; $step4<count($usersArray); $step4++) {

                                                            if ($array_DameAperturasEntreFechasPorOperador[$step]->IdUsuario === $usersArray[$step4]->IdUsuario) {

                                                                $nombre = $usersArray[$step4]->NombreUsuario;

                                                                
                                                                if($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
                    
                                                                    $accion = "Entregado";
                    
                                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
                    
                                                                    $accion = "Recogido";
                    
                                                                } elseif ($array_DameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                                    $accion = "Apertura Manual";

                                                                }

                                                                $fecha = date("d-m-Y - H:i:s:A", strtotime($array_DameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                                echo '
                                                                
                                                                <tr>
                                                                    <td>'.$fecha.'</td>
                                                                    <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdReserva.'</td>
                                                                    <td>'.$accion.'</td>
                                                                    <td>'.$nombre.'</td>
                                                                    <td>'.$array_DameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                                </tr>';

                                                            }

                                                        }
                                                        
                                                    } else {

                                                        // Objeto Vacio!

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

    <script src="../js/filtrarTrazabilidad_entreFechasPorOperador.js"></script>

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