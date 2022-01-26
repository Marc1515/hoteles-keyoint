<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-lista-reserva.php') ?>


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
        <?php require('header.php'); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php require('left-sidebar.php')?>
        
        <?php require('../ws/ws_users/ws_dameUsuarios.php'); ?>

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

                                    $estado = 9;

                                    $estadoSeleccionado = "";

                                    if(isset($_GET['error'])){

                                        if($_GET['error'] == 0) {
                                            echo 
                                            '   <div class="row d-flex justify-content-end">
                                                    <div class="col-3 d-flex justify-content-end">
                                                        <div class="alert alert-success animated bounceInRight"> <i class="ti-user"></i> La reserva se ha creado correctamente.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                        </div>
                                                    </div>
                                                </div> ';
                                        } elseif ($_GET['error'] == 2) {
                                            echo 
                                            '   <div class="row d-flex justify-content-end">
                                                    <div class="col-3 d-flex justify-content-end">
                                                        <div class="alert alert-warning animated bounceInRight"> <i class="ti-user"></i> La reserva se ha editado correctamente.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                        </div>
                                                    </div>
                                                </div> ';
                                        } elseif ($_GET['error'] == 3) {
                                            echo 
                                            '   <div class="row d-flex justify-content-end">
                                                    <div class="col-3 d-flex justify-content-end">
                                                        <div class="alert alert-danger animated bounceInRight"> <i class="ti-user"></i> La reserva se ha anulado correctamente.
                                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                                                        </div>
                                                    </div>
                                                </div> ';
                                        }

                                    }

                                    require './../ws/ws_users/ws_dameUsuarioPorNombre.php';

                                    
                                    $ocultarBotonesUsers = "";

                                    if($usersArrayN === 2) {

                                        $ocultarBotonesUsers = "hidden";

                                    } elseif ($usersArrayN === 1) {

                                        $ocultarBotonesUsers = "";

                                    } elseif ($usersArrayN === 0) {

                                        $ocultarBotonesUsers = "";

                                    }

                                            
                                        ?>

                                    <?php require './../ws/ws_operadores/ws_dameOperadores.php'; ?> 
                                        
                                    
                                    <form method="POST" id="formSearchReserves">
                                        <div class="row">
                                            <div class="col-12 col-sm-4">
                                                <h4 class="card-title">No-Shows</h4>
                                            </div>
                                                    
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="date" value="<?php if (isset($_POST['desde'])) { $_SESSION['desde'] = $_POST['desde']; echo $_POST['desde']; } elseif(isset($_SESSION['desde'])) { echo $_SESSION['desde']; } else { echo date("Y-m-d"); } ?>" name="desde" id="example-date-input" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada desde">   
                                                </div>
                                            </div>

                                        
                                            <div class="col-12 col-sm-2">
                                                <div class="form-group">
                                                    <input class="form-control" type="date" value="<?php if (isset($_POST['hasta'])) { $_SESSION['hasta'] = $_POST['hasta']; echo $_POST['hasta']; } elseif(isset($_SESSION['hasta'])) { echo $_SESSION['hasta']; } else { $hoy = time(); $quinceDiasEnSegundos = 24*60*60*15; $quinceDias=$hoy+$quinceDiasEnSegundos;  echo $quinceDias=date("Y-m-d", $quinceDias);} ?>" name="hasta" id="example-date-input2" data-toggle="tooltip" data-placement="bottom" title="Fecha entrada hasta"> 
                                                </div>
                                            </div>

                                            <div class="col-12 col-sm-1">
                                                <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="Estado">
                                                    <select class="custom-select" id="inlineFormCustomSelect" name="estado">
                                                        <option <?php if ($_POST['estado']==="9") { $_SESSION['estado'] = $_POST['estado']; echo $estadoSeleccionado = "selected"; } elseif ($_SESSION['estado']==="9") { echo $estadoSeleccionado = "selected"; } else { echo $estadoSeleccionado = ""; } ?> value="9">Todas</option>
                                                        <option <?php if ($_POST['estado']==="0") { $_SESSION['estado'] = $_POST['estado']; echo $estadoSeleccionado = "selected"; } elseif ($_SESSION['estado']==="0") { echo $estadoSeleccionado = "selected"; } else { echo $estadoSeleccionado = ""; } ?> value="0">Confirmada</option>
                                                        <option <?php if ($_POST['estado']==="1") { $_SESSION['estado'] = $_POST['estado']; echo $estadoSeleccionado = "selected"; } elseif ($_SESSION['estado']==="1") { echo $estadoSeleccionado = "selected"; } else { echo $estadoSeleccionado = ""; } ?> value="1">Anulada</option>
                                                        <option <?php if ($_POST['estado']==="2") { $_SESSION['estado'] = $_POST['estado']; echo $estadoSeleccionado = "selected"; } elseif ($_SESSION['estado']==="2") { echo $estadoSeleccionado = "selected"; } else { echo $estadoSeleccionado = ""; } ?> value="2">Entrada</option>
                                                        <option <?php if ($_POST['estado']==="3") { $_SESSION['estado'] = $_POST['estado']; echo $estadoSeleccionado = "selected"; } elseif ($_SESSION['estado']==="3") { echo $estadoSeleccionado = "selected"; } else { echo $estadoSeleccionado = ""; } ?> value="3">Salida</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="col-12 col-sm-2">

                                                <button type="submit" data-toggle="tooltip" data-placement="bottom" title="Buscar" class="float-right float-sm-left btn btn-info btn-circle" id="enviar"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>

                                            </div>
                                        


                                            <div class="col-12 col-sm-1">
                                                <div class="d-flex justify-content-end mb-1">
                                                    <a href="crear-reserva.php">
                                                        <button <?php echo $ocultarBotonesUsers ?> type="button" class="btn btn-info waves-effect waves-light">Nueva Reserva</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="d-flex justify-content-end">
                                        <a <?php echo $ocultarBotonesUsers ?> href="listticket_reservas.php<?php if ($_POST) { echo '?desde='.$_POST['desde'].'&hasta='.$_POST['hasta'].'&estado='.$_POST['estado']; } else { echo '?desde='.$hoy=date('Y-m-d').'&hasta='.$quinceDias.'&estado='.$estado; } ?>" target="_blank"><button id="enviarPDF" class="btn btn-danger mb-1" data-toggle="tooltip" data-placement="bottom" title="PDF"><i class="fas fa-file-pdf" style="font-size: 1.25rem"></i></button></a>
                                        <a <?php echo $ocultarBotonesUsers ?> href="reservas_excel.php<?php if ($_POST) { echo '?desde='.$_POST['desde'].'&hasta='.$_POST['hasta'].'&estado='.$_POST['estado']; } else { echo '?desde='.$hoy=date('Y-m-d').'&hasta='.$quinceDias.'&estado='.$estado; } ?>" target="_blank"><button class="btn btn-success ml-1" data-toggle="tooltip" data-placement="bottom" title="EXCEL"><i class="fas fa-file-excel" style="font-size: 1.25rem"></i></button></a>
                                    </div>
                                    <?php require '../ws/ws_reservas/ws_dameReservasPorOperador_no-shows.php'; ?>

                                <div class="table-responsive">
                                    <table id="example23" class="table display table-bordered table-striped no-wrap">
                                        <thead>
                                            <tr>
                                                <th>Nº Reserva</th>
                                                <th>Nombre</th>
                                                <th>Localizador</th>
                                                <th class="ocultarColumna">EntradaOculta</th>
                                                <th>Entrada</th>
                                                <th>Salida</th>
                                                <th>Móvil</th>
                                                <th>Puerta</th>
                                                <th>Estado</th>
                                                <th>Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php 



                                        if(!is_array($reservasArray) && !is_null($reservasArray)) {

                                                $ocultarConfirmacion='';
                                                $ocultarAnular='';
                                                $estiloSalida='';
                                                $estiloAnulada = '';

                                                if($reservasArray->Estado===0){
                                                    $estado="Confirmada";
                                                    $ocultarConfirmacion='hidden';
                                                } elseif ($reservasArray->Estado===1) {
                                                    $estado="Anulada";
                                                    $ocultarConfirmacion='hidden';
                                                    $ocultarAnular='hidden';
                                                    $estiloAnulada='style="color: grey"';
                                                } elseif ($reservasArray->Estado===2) {
                                                    $estado="Entrada";
                                                    $ocultarAnular='hidden';
                                                } elseif ($reservasArray->Estado===3) {
                                                    $estado="Salida";
                                                    $ocultarConfirmacion='hidden';
                                                    $ocultarAnular='hidden';
                                                    $estiloSalida = 'style="color: red"';
                                                }

                                                // Fecha de entrada con formato
                                                $newInPutDate = $reservasArray->Entrada;

                                                $newInPutDate = date("d-m-Y", strtotime($newInPutDate));

                                                // Fecha de salida con formato
                                                $newOutPutDate = $reservasArray->Salida;

                                                $newOutPutDate = date("d-m-Y", strtotime($newOutPutDate));

                                                echo    
                                                '   <tr>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray->IdReserva.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray->Nombre.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray->Localizador.'</p></td>
                                                        <td class="ocultarColumna"><p '.$estiloAnulada.'>'.$reservasArray->Entrada.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$newInPutDate.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$newOutPutDate.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray->Movil.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray->IdPuertaEntrada.'</p></td>
                                                        <td><p '.$estiloAnulada.' '.$estiloSalida.'>'.$estado.'</p></p></td>
                                                        <td>
                                                        <div class="d-flex">
                                                            <!------------ BOTON VER ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-xs btn-success mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#verReserva'.$reservasArray->IdReserva.'">
                                                            <i data-toggle="tooltip" title="Ver" style="font-size: 1rem" class="mdi mdi-eye-outline"></i>
                                                            </button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="verReserva'.$reservasArray->IdReserva.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header d-flex justify-content-between eyeModal">
                                                                            <div>
                                                                                <h5 class="modal-title" id="exampleModalLabel"></h5><h5 '.$estiloSalida.' '.$estiloAnulada.' class="modal-title">'.$estado.'</h5>
                                                                            </div>
                                                                            <div>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i style="font-size: 1.5rem" class="fas fa-eye">
                                                                                        <span aria-hidden="true"></span>
                                                                                    </i>
                                                                                </button>
                                                                            </div>
                                                                            
                                                                            <div>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        <h4 class="mb-3">Características de la Reserva:</h4>
                                                                            <ul>
                                                                                <li><p><strong>Número de reserva: </strong>'.$reservasArray->IdReserva.'</p></li>
                                                                                <li><p><strong>Nombre y Apellidos: </strong>'.$reservasArray->Nombre.'</p></li>
                                                                                <li><p><strong>Fecha de Entrada: </strong>'.$newInPutDate.'</p></li>
                                                                                <li><p><strong>Fecha de Salida: </strong>'.$newOutPutDate.'</p></li>
                                                                                <li><p><strong>Referencia: </strong>'.$reservasArray->Referencia.'</p></li>
                                                                                <li><p><strong>Localizador: </strong>'.$reservasArray->Localizador.'</p></li>
                                                                                <li><p><strong>Movil: </strong>'.$reservasArray->Movil.'</p></li>
                                                                                <li><p><strong>Email: </strong>'.$reservasArray->Email.'</p></li>
                                                                                <li><p><strong>Pin: </strong>'.$reservasArray->PinEntrada.'</p></li>
                                                                                <li><p><strong>Puerta: </strong>'.$reservasArray->IdPuertaEntrada.'</p></li>  
                                                                            </ul>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!------------ BOTON TRAZABILIDAD ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <a href="trazabilidad.php?upd='.$reservasArray->IdReserva.'"><button class="btn btn-xs btn-success mr-2 p-1 py-2 d-flex justify-content-center align-items-center waves-effect waves-light"><i data-toggle="tooltip" title="trazabilidad" style="font-size: 1rem" class="fas fa-search"></i></button></a>

                                                            <!------------ BOTON CAMBIAR ESTADO ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button type="button" class="btn btn-xs btn-warning mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#cambiarEstado'.$reservasArray->IdReserva.'">
                                                            <i data-toggle="tooltip" title="Cambiar Estado" style="font-size: 1rem" class="fas fa-sync-alt"></i>
                                                            </button>
    
                                                            <!-- Modal -->
                                                            <div class="modal fade" id="cambiarEstado'.$reservasArray->IdReserva.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header d-flex justify-content-between eyeModal">
                                                                            <div>
                                                                                <h5 class="modal-title" id="exampleModalLabel"></h5><h5 '.$estiloSalida.' '.$estiloAnulada.' class="modal-title">'.$estado.'</h5>
                                                                            </div>
                                                                            <div>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <i style="font-size: 1.5rem" class="fas fa-eye">
                                                                                        <span aria-hidden="true"></span>
                                                                                    </i>
                                                                                </button>
                                                                            </div>
                                                                            
                                                                            <div>
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                        <form class="d-flex" method="POST" action="cambiarEstado_validate.php">
                                                                            <div class="modal-body">
                                                                                <h4 class="mb-3">Cambiar estado de la Reserva:</h4>
    
                                                                                <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="Estado">
                                                                                    <select class="custom-select" id="inlineFormCustomSelect" name="estado">
                                                                                        <option value="9">Confirmada</option>
                                                                                        <option value="1">Anulada</option>
                                                                                        <option value="2">Entrada</option>
                                                                                        <option value="3">Salida</option>
                                                                                    </select>
                                                                                </div>
    
                                                                                <input hidden type="text" class="form-control form-control-line" name="idReserva" id="idReserva" value="'.$reservasArray->IdReserva.'">
                                                                            
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$reservasArray->IdReserva.'" data-nombre="'.$reservasArray->Nombre.'">Confirmar</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!------------ BOTON EDITAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <a '.$ocultarBotonesUsers.' href="actualizar-reserva.php?upd='.$reservasArray->IdReserva.'"><button class="btn btn-xs btn-info mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light"><i data-toggle="tooltip" title="Editar" style="font-size: 1rem" class="mdi mdi-pencil"></i></button></a>
                                                            
                                                            <!------------ BOTON ANULAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button '.$ocultarBotonesUsers.' '.$ocultarAnular.' type="button" class="btn btn-xs btn-secondary mr-2 p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#borrarReserva'.$reservasArray->IdReserva.'" data-id_res="'.$reservasArray->IdReserva.'" data-nombre="'.$reservasArray->Nombre.'"><i data-toggle="tooltip" title="Anular"  style="font-size: 1rem" class="mdi mdi-close"></i></button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="borrarReserva'.$reservasArray->IdReserva.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Anular</strong> Reserva</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Anular la reserva de <strong>'.$reservasArray->Nombre.'</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="eliminar_reserva_validate.php" method="POST">
                                                                                <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$reservasArray->IdReserva.'">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$reservasArray->IdReserva.'" data-nombre="'.$reservasArray->Nombre.'">Confirmar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                    
                                                            <!------------ BOTON CHECK-OUT ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                            <!-- Button trigger modal -->
                                                            <button '.$ocultarBotonesUsers.' '.$ocultarConfirmacion.' type="button" class="btn btn-xs btn-danger p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#confirmarReserva'.$reservasArray->IdReserva.'" data-id_res="'.$reservasArray->IdReserva.'" data-nombre="'.$reservasArray->Nombre.'"><i data-toggle="tooltip" title="Salida"  style="font-size: 1rem" class="mdi mdi-check iconos"></i></button>

                                                            <!-- Modal -->
                                                            <div class="modal fade" id="confirmarReserva'.$reservasArray->IdReserva.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Confirmar</strong> Reserva</h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            Confirmar la reserva de <strong>'.$reservasArray->Nombre.'</strong> como <strong>"Salida"</strong>?
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <form action="checkOut_validate.php?upd='.$reservasArray->IdReserva.'" method="POST">
                                                                                <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$reservasArray->IdReserva.'">
                                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                                <button type="submit" class="btn btn-danger text-white" data-id_res="'.$reservasArray->IdReserva.'" data-nombre="'.$reservasArray->Nombre.'">Confirmar</button>
                                                                            </form>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                            </td>
                                                        </tr>';
                                                        
                                                
                                                
                                        
                                        
                                        } elseif (is_array($reservasArray)) {

                                            for($step=0; $step<count($reservasArray); $step++) {

                                                $ocultarConfirmacion='';
                                                $ocultarAnular='';
                                                $estiloSalida='';
                                                $estiloAnulada = '';

                                                if($reservasArray[$step]->Estado===0){
                                                    $estado="Confirmada";
                                                    $ocultarConfirmacion='hidden';
                                                } elseif ($reservasArray[$step]->Estado===1) {
                                                    $estado="Anulada";
                                                    $ocultarConfirmacion='hidden';
                                                    $ocultarAnular='hidden';
                                                    $estiloAnulada='style="color: grey"';
                                                } elseif ($reservasArray[$step]->Estado===2) {
                                                    $estado="Entrada";
                                                    $ocultarAnular='hidden';
                                                } elseif ($reservasArray[$step]->Estado===3) {
                                                    $estado="Salida";
                                                    $ocultarConfirmacion='hidden';
                                                    $ocultarAnular='hidden';
                                                    $estiloSalida = 'style="color: red"';
                                                }

                                                // Fecha de entrada con formato
                                                $newInPutDate = $reservasArray[$step]->Entrada;

                                                $newInPutDate = date("d-m-Y", strtotime($newInPutDate));

                                                // Fecha de salida con formato
                                                $newOutPutDate = $reservasArray[$step]->Salida;

                                                $newOutPutDate = date("d-m-Y", strtotime($newOutPutDate));

                                                echo    
                                                '   <tr>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray[$step]->IdReserva.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray[$step]->Nombre.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray[$step]->Localizador.'</p></td>
                                                        <td class="ocultarColumna"><p '.$estiloAnulada.'>'.$reservasArray[$step]->Entrada.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$newInPutDate.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$newOutPutDate.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray[$step]->Movil.'</p></td>
                                                        <td><p '.$estiloAnulada.'>'.$reservasArray[$step]->IdPuertaEntrada.'</p></td>
                                                        <td><p '.$estiloAnulada.' '.$estiloSalida.'>'.$estado.'</p></p></td>
                                                        <td class="d-flex">

                                                        <!------------ BOTON VER ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-xs btn-success mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#verReserva'.$reservasArray[$step]->IdReserva.'">
                                                        <i data-toggle="tooltip" title="Ver" style="font-size: 1rem" class="mdi mdi-eye-outline"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="verReserva'.$reservasArray[$step]->IdReserva.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header d-flex justify-content-between eyeModal">
                                                                        <div>
                                                                            <h5 class="modal-title" id="exampleModalLabel"></h5><h5 '.$estiloSalida.' '.$estiloAnulada.' class="modal-title">'.$estado.'</h5>
                                                                        </div>
                                                                        <div>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i style="font-size: 1.5rem" class="fas fa-eye">
                                                                                    <span aria-hidden="true"></span>
                                                                                </i>
                                                                            </button>
                                                                        </div>
                                                                        
                                                                        <div>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                    <h4 class="mb-3">Características de la Reserva:</h4>
                                                                        <ul>
                                                                            <li><p><strong>Número de reserva: </strong>'.$reservasArray[$step]->IdReserva.'</p></li>
                                                                            <li><p><strong>Nombre y Apellidos: </strong>'.$reservasArray[$step]->Nombre.'</p></li>
                                                                            <li><p><strong>Fecha de Entrada: </strong>'.$newInPutDate.'</p></li>
                                                                            <li><p><strong>Fecha de Salida: </strong>'.$newOutPutDate.'</p></li>
                                                                            <li><p><strong>Referencia: </strong>'.$reservasArray[$step]->Referencia.'</p></li>
                                                                            <li><p><strong>Localizador: </strong>'.$reservasArray[$step]->Localizador.'</p></li>
                                                                            <li><p><strong>Movil: </strong>'.$reservasArray[$step]->Movil.'</p></li>
                                                                            <li><p><strong>Email: </strong>'.$reservasArray[$step]->Email.'</p></li>
                                                                            <li><p><strong>Pin: </strong>'.$reservasArray[$step]->PinEntrada.'</p></li>
                                                                            <li><p><strong>Puerta: </strong>'.$reservasArray[$step]->IdPuertaEntrada.'</p></li>  
                                                                        </ul>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!------------ BOTON TRAZABILIDAD ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <a href="trazabilidad.php?upd='.$reservasArray[$step]->IdReserva.'"><button class="btn btn-xs btn-success mr-2 p-1 py-2 d-flex justify-content-center align-items-center waves-effect waves-light"><i data-toggle="tooltip" title="trazabilidad" style="font-size: 1rem" class="fas fa-search"></i></button></a>

                                                        <!------------ BOTON EDITAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <a '.$ocultarBotonesUsers.' href="actualizar-reserva.php?upd='.$reservasArray[$step]->IdReserva.'"><button class="btn btn-xs btn-info mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light"><i data-toggle="tooltip" title="Editar" style="font-size: 1rem" class="mdi mdi-pencil"></i></button></a>
                                                        
                                                        <!------------ BOTON CAMBIAR ESTADO ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <!-- Button trigger modal -->
                                                        <button type="button" class="btn btn-xs btn-warning mr-2 p-1 py-0 d-flex justify-content-center align-items-center waves-effect waves-light" data-toggle="modal" data-target="#cambiarEstado'.$reservasArray[$step]->IdReserva.'">
                                                        <i data-toggle="tooltip" title="Cambiar Estado" style="font-size: 1rem" class="fas fa-sync-alt"></i>
                                                        </button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="cambiarEstado'.$reservasArray[$step]->IdReserva.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header d-flex justify-content-between eyeModal">
                                                                        <div>
                                                                            <h5 class="modal-title" id="exampleModalLabel"></h5><h5 '.$estiloSalida.' '.$estiloAnulada.' class="modal-title">'.$estado.'</h5>
                                                                        </div>
                                                                        <div>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <i style="font-size: 1.5rem" class="fas fa-eye">
                                                                                    <span aria-hidden="true"></span>
                                                                                </i>
                                                                            </button>
                                                                        </div>
                                                                        
                                                                        <div>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <form class="d-flex" method="POST" action="cambiarEstado_validate.php">
                                                                        <div class="modal-body">
                                                                            <h4 class="mb-3">Cambiar estado de la Reserva:</h4>

                                                                            <div class="form-group" data-toggle="tooltip" data-placement="bottom" title="Estado">
                                                                                <select class="custom-select" id="inlineFormCustomSelect" name="estado">
                                                                                    <option value="9">Confirmada</option>
                                                                                    <option value="1">Anulada</option>
                                                                                    <option value="2">Entrada</option>
                                                                                    <option value="3">Salida</option>
                                                                                </select>
                                                                            </div>

                                                                            <input hidden type="text" class="form-control form-control-line" name="idReserva" id="idReserva" value="'.$reservasArray[$step]->IdReserva.'">
                                                                        
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                                                                            <button type="submit" class="btn btn-danger text-white" data-id_res="'.$reservasArray[$step]->IdReserva.'" data-nombre="'.$reservasArray[$step]->Nombre.'">Confirmar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!------------ BOTON ANULAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <!-- Button trigger modal -->
                                                        <button '.$ocultarBotonesUsers.' '.$ocultarAnular.' type="button" class="btn btn-xs btn-secondary mr-2 p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#borrarReserva'.$reservasArray[$step]->IdReserva.'" data-id_res="'.$reservasArray[$step]->IdReserva.'" data-nombre="'.$reservasArray[$step]->Nombre.'"><i data-toggle="tooltip" title="Anular"  style="font-size: 1rem" class="mdi mdi-close"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="borrarReserva'.$reservasArray[$step]->IdReserva.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Anular</strong> Reserva</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Anular la reserva de <strong>'.$reservasArray[$step]->Nombre.'</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="eliminar_reserva_validate.php" method="POST">
                                                                            <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$reservasArray[$step]->IdReserva.'">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-danger text-white" data-id_res="'.$reservasArray[$step]->IdReserva.'" data-nombre="'.$reservasArray[$step]->Nombre.'">Confirmar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                
                                                        <!------------ BOTON CHECK-OUT ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        <!-- Button trigger modal -->
                                                        <button '.$ocultarBotonesUsers.' '.$ocultarConfirmacion.' type="button" class="btn btn-xs btn-danger p-0 px-1 waves-effect waves-light" data-toggle="modal" data-target="#confirmarReserva'.$reservasArray[$step]->IdReserva.'" data-id_res="'.$reservasArray[$step]->IdReserva.'" data-nombre="'.$reservasArray[$step]->Nombre.'"><i data-toggle="tooltip" title="Salida" style="font-size: 1rem" class="mdi mdi-check iconos"></i></button>

                                                        <!-- Modal -->
                                                        <div class="modal fade" id="confirmarReserva'.$reservasArray[$step]->IdReserva.'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title" id="exampleModalLabel"><strong>Confirmar</strong> Reserva</h5>
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        Confirmar la reserva de <strong>'.$reservasArray[$step]->Nombre.'</strong> como <strong>"Salida"</strong>?
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <form action="checkOut_validate.php?upd='.$reservasArray[$step]->IdReserva.'" method="POST">
                                                                            <input type="hidden" id="del_id_usr" name="del_id_usr" value="'.$reservasArray[$step]->IdReserva.'">
                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                                            <button type="submit" class="btn btn-danger text-white" data-id_res="'.$reservasArray[$step]->IdReserva.'" data-nombre="'.$reservasArray[$step]->Nombre.'">Confirmar</button>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </td>
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
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="./../js/filtro_reservas.js"></script>


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
				"columns": [{ "searchable": false },{ "searchable": true },{ "searchable": true },{ "searchable": true },{ "searchable": false },{ "searchable": false },{ "searchable": true },{ "searchable": false }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},

        });

    });
        $('#example23').DataTable({
            responsive: true,
            dom: 'lfrtip',
            "displayLength": 25,
            "columns": [{ "searchable": false },{ "searchable": true },{ "searchable": true },{ "searchable": false },{ "searchable": true },{ "searchable": false },{ "searchable": true },{ "searchable": false },{ "searchable": true },{ "searchable": false }],
            language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
            columnDefs: [
                { orderable: false, targets: [2,6,7,8,9] }
            ],
            order: [3, 'desc']
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    </script>
    <script src="./../js/lista-reservas.js"></script>
    <script src="./../js/filtrarReserva_porFecha.js"></script>
    <script src="./../js/filtrarReservas_porLocalizador.js"></script>
    
</body>

</html>