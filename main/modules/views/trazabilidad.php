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
                                        <h4 class="card-title">Trazabilidad por Reserva</h4>                                   
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
                                        <input type="text" class="form-control form-control-line" value="<?php echo $_POST['idReserva'] ?>" name="idReserva" id="idReserva" placeholder="Ingresa el Nº de reserva" required data-validation-required-message="This field is required">
                                    </div>

                                    <div class="col-12 col-sm-6 mb-4">
                                        <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="float-right float-sm-left btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
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

                                        require './../ws/ws_users/ws_dameUsuarios.php';
                                        require './../ws/ws_reservas/ws_dameReservaPorOperador_trazabilidad.php';

                                        $idReservaString = $_POST['idReserva'];
                                        $idReserva = intval($idReservaString);

                                        // --- LLAMAR WS : DameAperturasPorReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                                        $parametros_dameAperturasPorReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador, 'IdReserva'=>$idReserva);
                                        $soap_result_DAEFPO = $client->DameAperturasPorReserva($parametros_dameAperturasPorReserva);
                                        
                                        $objeto_dameAperturasPorReserva = $soap_result_DAEFPO->DameAperturasPorReservaResult->Apertura;


                                        if (!is_array($objeto_dameAperturasPorReserva) && !is_null($objeto_dameAperturasPorReserva)) {

                                            if ($objeto_dameAperturasPorReserva->IdReserva !== 0) {

                                                $fecha = date("d-m-Y - H:i:s:A", strtotime($objeto_dameAperturasPorReserva->Fecha));


                                                require './../../../../ws_include/ws_Keys_consigna.php';

                                                // --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasPorReserva->IdOperador, 'IdUsuario'=>$objeto_dameAperturasPorReserva->IdUsuario);
                                                $soap_result_DU = $SoapClient_KeysConsigna->DameUsuario($parametros_dameUsuario);
                                                
                                                $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;
                                                

                                                require './../../../../ws_include/ws_Keys_reserva.php';

                                                // --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasPorReserva->IdOperador, 'IdReserva'=>$objeto_dameAperturasPorReserva->IdReserva);
                                                $soap_result_DR = $SoapClient_KeysReserva->DameReserva($parametros_dameReserva);

                                                $objeto_dameReserva = $soap_result_DR->DameReservaResult;


                                                if($objeto_dameAperturasPorReserva->Tipo === 1) {
                                                    
                                                    $accion = "Entregado";

                                                    if ($objeto_dameAperturasPorReserva->IdUsuario === $objeto_dameUsuario->IdUsuario) {

                                                        $nombre = $objeto_dameUsuario->Nombre;
    
                                                    }
            
    
                                                } elseif ($objeto_dameAperturasPorReserva->Tipo === 2) {
    
                                                    $accion = "Recogido";

                                                    if ($objeto_dameAperturasPorReserva->IdReserva === $objeto_dameReserva->IdReserva) {

                                                        $nombre = $objeto_dameReserva->Nombre;
    
                                                    }
    
                                                } elseif ($objeto_dameAperturasPorReserva->Tipo === 9) {

                                                    $accion = "Apertura Manual";

                                                    if ($objeto_dameAperturasPorReserva->IdUsuario === $objeto_dameUsuario->IdUsuario) {

                                                        $nombre = $objeto_dameUsuario->Nombre;
    
                                                    }

                                                }



                                                echo '
                                                            
                                                <tr>
                                                    <td>'.$fecha.'</td>
                                                    <td>'.$objeto_dameAperturasPorReserva->IdReserva.'</td>
                                                    <td>'.$accion.'</td>
                                                    <td>'.$nombre.'</td>
                                                    <td>'.$objeto_dameAperturasPorReserva->IdPuerta.'</td> 
                                                </tr>';

                                            }


                                        } elseif (is_array($objeto_dameAperturasPorReserva)) {

                                            for ($step=0; $step<count($objeto_dameAperturasPorReserva); $step++) {

                                                if ($objeto_dameAperturasPorReserva[$step]->IdReserva !== 0) {

                                                    $fecha = date("d-m-Y - H:i:s:A", strtotime($objeto_dameAperturasPorReserva[$step]->Fecha));


                                                    require './../../../../ws_include/ws_Keys_consigna.php';

                                                    // --- LLAMAR WS : DameUsuario --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    $parametros_dameUsuario = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasPorReserva[$step]->IdOperador, 'IdUsuario'=>$objeto_dameAperturasPorReserva[$step]->IdUsuario);
                                                    $soap_result_DU = $SoapClient_KeysConsigna->DameUsuario($parametros_dameUsuario);
                                                    
                                                    $objeto_dameUsuario = $soap_result_DU->DameUsuarioResult;
                                                    
    
                                                    require './../../../../ws_include/ws_Keys_reserva.php';
    
                                                    // --- LLAMAR WS : DameReserva --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                    $parametros_dameReserva = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameAperturasPorReserva[$step]->IdOperador, 'IdReserva'=>$objeto_dameAperturasPorReserva[$step]->IdReserva);
                                                    $soap_result_DR = $SoapClient_KeysReserva->DameReserva($parametros_dameReserva);
    
                                                    $objeto_dameReserva = $soap_result_DR->DameReservaResult;




                                                    if ($objeto_dameAperturasPorReserva[$step]->Tipo === 1) {
                
                                                        $accion = "Entregado";

                                                        if ($objeto_dameAperturasPorReserva[$step]->IdOperador === $objeto_dameUsuario->IdOperador) {

                                                            $nombre = $objeto_dameUsuario->Nombre;
    
                                                        }
        
                                                    } elseif ($objeto_dameAperturasPorReserva[$step]->Tipo === 2) {
        
                                                        $accion = "Recogido";

                                                        if ($objeto_dameAperturasPorReserva[$step]->IdReserva === $objeto_dameReserva->IdReserva) {

                                                            $nombre = $objeto_dameReserva->Nombre;
    
                                                        }
        
                                                    } elseif ($objeto_dameAperturasPorReserva[$step]->Tipo === 9) {
                                                        
                                                        $accion = "Apertura Manual";

                                                        if ($objeto_dameAperturasPorReserva[$step]->IdOperador === $objeto_dameUsuario->IdOperador) {

                                                            $nombre = $objeto_dameUsuario->Nombre;
    
                                                        }

                                                    }



                                                    echo '
                                                                
                                                    <tr>
                                                        <td>'.$fecha.'</td>
                                                        <td>'.$objeto_dameAperturasPorReserva[$step]->IdReserva.'</td>
                                                        <td>'.$accion.'</td>
                                                        <td>'.$nombre.'</td>
                                                        <td>'.$objeto_dameAperturasPorReserva[$step]->IdPuerta.'</td> 
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

    <script src="../js//filtrarTrazabilidad.js"></script>

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
                    filename : 'trazabilidadPorReserva',
                    title: 'Trazabilidad por Reserva',
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
                    filename : 'trazabilidadPorReserva',
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