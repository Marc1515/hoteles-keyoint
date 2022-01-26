<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-disponiblidad.php') ?>


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

        <?php require('../ws/ws_users/ws_dameUsuarios.php') ?>
        <?php require('../ws/ws_operadores/ws_dameOperador.php') ?>

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

                                <div class="d-flex">
                                    
                                    <form class="row w-75" method="POST" id="formSearchDisponiblidad">
                                        <div class="col-12 col-sm-12 col-md-6">
                                            <h4 class="card-title">Disponiblidad de puertas</h4>
                                        </div>

                                        <div class="col-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <input class="form-control" type="date" value="<?php if (isset($_POST['desde_disponiblidad'])) { $_SESSION['desde_disponiblidad'] = $_POST['desde_disponiblidad']; echo $_POST['desde_disponiblidad']; } elseif(isset($_SESSION['desde_disponiblidad'])) { echo $_SESSION['desde_disponiblidad']; } else { echo date("Y-m-d"); } ?>" name="desde_disponiblidad" id="example-date-input" data-toggle="tooltip" data-placement="bottom" title="Fecha desde_disponiblidad">   
                                            </div>
                                        </div>
                                        
                                        <div class="col-12 col-sm-12 col-md-2">
                                            <div class="form-group">
                                                <input class="form-control" type="date" value="<?php if (isset($_POST['hasta_disponiblidad'])) { $_SESSION['hasta_disponiblidad'] = $_POST['hasta_disponiblidad']; echo $_POST['hasta_disponiblidad']; } elseif(isset($_SESSION['hasta_disponiblidad'])) { echo $_SESSION['hasta_disponiblidad']; } else { $hoy = time(); $quinceDiasEnSegundos = 24*60*60*15; $quinceDias=$hoy+$quinceDiasEnSegundos;  echo $quinceDias=date("Y-m-d", $quinceDias);} ?>" name="hasta_disponiblidad" id="example-date-input2" data-toggle="tooltip" data-placement="bottom" title="Fecha hasta_disponiblidad"> 
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-12 col-md-2 d-flex justify-content-end justify-content-sm-start">       
                                            <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="btn btn-info btn-circle mb-1"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                        </div>
                                    </form>

                                    <?php require('../ws/ws_reservas/ws_dameReservaPorOperador_disponibilidad.php') ?>
                                    <?php require './../ws/ws_reservas/ws_dameOcupacionEntreFechas.php' ?>
                                    

                                </div>

                                <div class="table-responsive">
                                    <table id="example23" class="table display table-bordered table-striped no-wrap tablaDisponiblidad" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>OcultarFecha</th>
                                                <th>Total</th>
                                                <th>Libres</th>
                                                <th>Reservadas</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php


                                                if (!is_array($array_dameOcupacionEntreFechas) && !is_null($array_dameOcupacionEntreFechas)) {

                                                    require './../../../../ws_include/ws_Keys_reserva.php';


                                                    // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$array_dameOcupacionEntreFechas->IdOperador);
                                                    $soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);


                                                    $objeto_dameContrato = $soap_result_DC->DameContratoResult;

                                                    $finalContratoString = $objeto_dameContrato->Hasta;
                                                    $finalContrato = intval($finalContratoString);

                                                    $fechaString = $array_dameOcupacionEntreFechas->Fecha;
                                                    $fecha = intval($fechaString);

                                                    $entradaFrom = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas->Fecha));

                                                    if ($fecha <= $finalContrato) {

                                                        echo '
                                                            <tr>
                                                            
                                                                <td>'.$entradaFrom.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas->Fecha.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas->Total.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas->Libres.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas->Reservadas.'</td>
                                                            
                                                            </tr> 
                                                        ';

                                                    }



                                                } elseif (is_array($array_dameOcupacionEntreFechas)) {
                                            
                                                    for ($step=0; $step<count((array)$array_dameOcupacionEntreFechas); $step++) {

                                                        require './../../../../ws_include/ws_Keys_reserva.php';


                                                        // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$array_dameOcupacionEntreFechas[$step]->IdOperador);
                                                        $soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);


                                                        $objeto_dameContrato = $soap_result_DC->DameContratoResult;

                                                        $finalContratoString = $objeto_dameContrato->Hasta;
                                                        $finalContrato = intval($finalContratoString);

                                                        $fechaString = $array_dameOcupacionEntreFechas[$step]->Fecha;
                                                        $fecha = intval($fechaString);

                                                        $entradaFrom = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas[$step]->Fecha));

                                                        if ($fecha <= $finalContrato) {

                                                            echo '
                                                                <tr>
                                                                
                                                                    <td>'.$entradaFrom.'</td>
                                                                    <td>'.$array_dameOcupacionEntreFechas[$step]->Fecha.'</td>
                                                                    <td>'.$array_dameOcupacionEntreFechas[$step]->Total.'</td>
                                                                    <td>'.$array_dameOcupacionEntreFechas[$step]->Libres.'</td>
                                                                    <td>'.$array_dameOcupacionEntreFechas[$step]->Reservadas.'</td>
                                                                
                                                                </tr> 
                                                            ';

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
    <script src="../../../assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="./../js/filtro_disponiblidad.js"></script>


    <!-- end - This is for export functionality only -->
    <script>
        $(document).ready(function () {
            tablalockers = $('#example23').DataTable({
                responsive: true,
                searching: true,
                dom: 'Blfrtip',
                buttons: [{
                    extend: 'pdfHtml5',
                    className: 'btn btn-primary mr-1',
                    text:'<span class=\"far fa-file-pdf \" title=\"Exportar a PDF\"></span>',
                    filename : 'disponiblidad',
                    title: 'Disponiblidad',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    download: 'open',
                    exportOptions: {columns: [0,2,3,4]},
                    customize : function(doc) {
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = [ '40%', '20%', '20%', '20%' ];
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary mr-3',
                    text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
                    filename : 'disponiblidad',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    exportOptions: {columns: [0,2,3,4]},
                    }],             
                "displayLength":25,
                "columns": [{"searchable": true},{"searchable": false},{"searchable": false},{"searchable": false},{"searchable": false}],
                language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                columnDefs: [
                    {orderable: false, targets: [1,2,3,4]}
                ],
                order: [1, 'asc']
            });
        });
    </script>
    <script src="./../js/lista-reservas.js"></script>
    
</body>

</html>