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
                                        <h4 class="card-title">Trazabilidad por Fecha</h4>                                   
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

                                
                                <div class="table-responsive">
                                    <table id="example23" class="table display table-bordered table-striped no-wrap">
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

                                        require './../ws/ws_reservas/ws2.php';

                                        $desdeForm = $_POST['desde_trazabilidad'];
                                        $desde = date("Ymd", strtotime($desdeForm));

                                        $hastaForm = $_POST['hasta_trazabilidad'];
                                        $hasta = date("Ymd", strtotime($hastaForm));

                                        // --- LLAMAR WS : DameAperturasEntreFechasPorOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
                                        $parametros_dameAperturasEntreFechasPorOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'desde'=>$desde, 'hasta'=>$hasta);
                                        $soap_result_DAEFPO = $client->DameAperturasEntreFechasPorOperador($parametros_dameAperturasEntreFechasPorOperador);
                                        
                                        $objeto_dameAperturasEntreFechasPorOperador = $soap_result_DAEFPO->DameAperturasEntreFechasPorOperadorResult->Apertura;

                                        
                                        if (!is_array($objeto_dameAperturasEntreFechasPorOperador) && !is_null($objeto_dameAperturasEntreFechasPorOperador)) {


                                            $fecha = date("d-m-Y - H:i:s:A", strtotime($objeto_dameAperturasEntreFechasPorOperador->Fecha));

                                            if ($objeto_dameAperturasEntreFechasPorOperador->IdReserva == 0) {

                                                $numReserva = "";

                                            } else {

                                                $numReserva = $objeto_dameAperturasEntreFechasPorOperador->IdReserva;

                                            } 


                                            require './../../../../ws_include/ws_Keys_consigna.php';

                                            // --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
                                            $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasEntreFechasPorOperador->IdOperador, 'IdUsuario'=>$objeto_dameAperturasEntreFechasPorOperador->IdUsuario);
                                            $soap_result_DU = $SoapClient_KeysConsigna->DameUsuario($parametros_dameUsuario);
                                            
                                            $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;
                                            

                                            require './../../../../ws_include/ws_Keys_reserva.php';

                                            // --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                                            $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasEntreFechasPorOperador->IdOperador, 'IdReserva'=>$objeto_dameAperturasEntreFechasPorOperador->IdReserva);
                                            $soap_result_DR = $SoapClient_KeysReserva->DameReserva($parametros_dameReserva);

                                            $objeto_dameReserva = $soap_result_DR->DameReservaResult;


                                            if($objeto_dameAperturasEntreFechasPorOperador->Tipo === 1) {
        
                                                $accion = "Entregado";

                                                if ($objeto_dameAperturasEntreFechasPorOperador->IdOperador === $objeto_dameUsuario->IdOperador) {

                                                    $nombre = $objeto_dameUsuario->Nombre;

                                                }

                                            } elseif ($objeto_dameAperturasEntreFechasPorOperador->Tipo === 2) {

                                                $accion = "Recogido";

                                                if ($objeto_dameAperturasEntreFechasPorOperador->IdReserva === $objeto_dameReserva->IdReserva) {

                                                    $nombre = $objeto_dameReserva->Nombre;

                                                }

                                            } elseif ($objeto_dameAperturasEntreFechasPorOperador->Tipo === 9) {

                                                $accion = "Apertura Manual";

                                                if ($objeto_dameAperturasEntreFechasPorOperador->IdOperador === $objeto_dameUsuario->IdOperador) {

                                                    $nombre = $objeto_dameUsuario->Nombre;

                                                }

                                            }



                                                echo '
                                                            
                                                <tr>
                                                    <td>'.$fecha.'</td>
                                                    <td>'.$numReserva.'</td>
                                                    <td>'.$accion.'</td>
                                                    <td>'.$nombre.'</td>
                                                    <td>'.$objeto_dameAperturasEntreFechasPorOperador->IdPuerta.'</td> 
                                                </tr>';

                                            

                                        } elseif (is_array($objeto_dameAperturasEntreFechasPorOperador)) {

                                            for ($step=0; $step<count($objeto_dameAperturasEntreFechasPorOperador); $step++) {


                                                $fecha = date("d-m-Y - H:i:s:A", strtotime($objeto_dameAperturasEntreFechasPorOperador[$step]->Fecha));

                                                if ($objeto_dameAperturasEntreFechasPorOperador[$step]->IdReserva == 0) {

                                                    $numReserva = "";

                                                } else {

                                                    $numReserva = $objeto_dameAperturasEntreFechasPorOperador[$step]->IdReserva;

                                                } 


                                                require './../../../../ws_include/ws_Keys_consigna.php';

                                                // --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasEntreFechasPorOperador[$step]->IdOperador, 'IdUsuario'=>$objeto_dameAperturasEntreFechasPorOperador[$step]->IdUsuario);
                                                $soap_result_DU = $SoapClient_KeysConsigna->DameUsuario($parametros_dameUsuario);
                                                
                                                $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;
                                                

                                                require './../../../../ws_include/ws_Keys_reserva.php';

                                                // --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasEntreFechasPorOperador[$step]->IdOperador, 'IdReserva'=>$objeto_dameAperturasEntreFechasPorOperador[$step]->IdReserva);
                                                $soap_result_DR = $SoapClient_KeysReserva->DameReserva($parametros_dameReserva);

                                                $objeto_dameReserva = $soap_result_DR->DameReservaResult;


                                                if($objeto_dameAperturasEntreFechasPorOperador[$step]->Tipo === 1) {
            
                                                    $accion = "Entregado";

                                                    if ($objeto_dameAperturasEntreFechasPorOperador[$step]->IdOperador === $objeto_dameUsuario->IdOperador) {

                                                        $nombre = $objeto_dameUsuario->Nombre;
    
                                                    }
    
                                                } elseif ($objeto_dameAperturasEntreFechasPorOperador[$step]->Tipo === 2) {
    
                                                    $accion = "Recogido";

                                                    if ($objeto_dameAperturasEntreFechasPorOperador[$step]->IdReserva === $objeto_dameReserva->IdReserva) {

                                                        $nombre = $objeto_dameReserva->Nombre;
    
                                                    }
    
                                                } elseif ($objeto_dameAperturasEntreFechasPorOperador[$step]->Tipo === 9) {

                                                    $accion = "Apertura Manual";

                                                    if ($objeto_dameAperturasEntreFechasPorOperador[$step]->IdOperador === $objeto_dameUsuario->IdOperador) {

                                                        $nombre = $objeto_dameUsuario->Nombre;
    
                                                    }

                                                }



                                                echo '
                                                            
                                                <tr>
                                                    <td>'.$fecha.'</td>
                                                    <td>'.$numReserva.'</td>
                                                    <td>'.$accion.'</td>
                                                    <td>'.$nombre.'</td>
                                                    <td>'.$objeto_dameAperturasEntreFechasPorOperador[$step]->IdPuerta.'</td> 
                                                </tr>';


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

    <script src="../js/filtrarTrazabilidad_entreFechasPorOperador.js"></script>

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
                    filename : 'trazabilidadPorFecha',
                    title: 'Trazabilidad por Fecha',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    download: 'open',
                    exportOptions: {columns: [0,1,2,3,4]},
                    customize : function(doc) {
                        doc.styles.tableHeader.alignment = 'left';
                        doc.content[1].table.widths = [ '30%', '15%', '20%', '25%', '10%' ];
                    }
                },
                {
                    extend: 'excelHtml5',
                    className: 'btn btn-primary mr-3',
                    text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
                    filename : 'trazabilidadPorFecha',
                    pageSize: 'A4',
                    orientation: 'portrait',
                    exportOptions: {columns: [0,1,2,3,4]},
                    }],             
                "displayLength":25,
                "columns": [{"searchable": true},{"searchable": true},{"searchable": false},{"searchable": true},{"searchable": false}],
                language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                columnDefs: [
                    {orderable: false, targets: [2,4]}
                ],
                order: [0, 'asc']
            });
        });
    </script>
    
</body>

</html>