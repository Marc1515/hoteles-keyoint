<!DOCTYPE html>
<html lang="en">

<?php require('../heads/head-actualizar-reserva.php') ?>

<body class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php /* require('preloader.php') */?>
    <?php /* require('email_actualizacion.php'); */ ?>
    <!-- ============================================================== -->

    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php require('header.php')?>
        <?php require('../ws/ws_reservas/ws_dameReserva.php')?>
        <?php

            session_start();

            require './../ws/ws_operadores/ws2.php';

            $idLocker = $_SESSION['idLocker'];

            // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
            $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
            $soap_result_DO = $client->DameOperador($parametros_dameOperador);

            $objeto_dameOperador = $soap_result_DO->DameOperadorResult;

        ?>
        <?php
        $nomuestra='';
        $nomuestra_est2='';
        if($objeto_dameReserva->Estado != 0){
            $nomuestra = 'readonly';
            if($objeto_dameReserva->Estado == 2){
                $nomuestra_est2 = '';
            }else{
                $nomuestra_est2 = 'readonly';
            }
        }


        $noti = $objeto_dameReserva->TipoNotificación;


        $movil = '';
        $email = '';

        /* if($objeto_dameReserva->Estado !== 0) { */

            if($noti==1) {
                
                $movil = 'selected';
                $email = '';
    
            } else {
    
                $movil = '';
                $email = 'selected';

            }

        /* } */

        if ($objeto_dameReserva->Estado == 0) {

            $estado = "Confirmada";
            $colorEstado = "class = 'label label-info'";

        } elseif ($objeto_dameReserva->Estado == 1) {

            $estado = "Anulada";
            $colorEstado = "class = 'label label-warning'";

        } elseif ($objeto_dameReserva->Estado == 2) {

            $estado = "Entrada";
            $colorEstado = "class = 'label label-success'";

        } elseif ($objeto_dameReserva->Estado == 3) {

            $estado = "Salida";
            $colorEstado = "class = 'label label-danger'";

        }



    ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php require('left-sidebar.php') ?>
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
                        <h4 class="text-themecolor">Basic Form</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Basic Form</li>
                            </ol>
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i class="fa fa-plus-circle"></i> Create New</button>
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
                        <div class="card">
                            <div class="card-body">

                                <!-- <h6 class="card-subtitle">Just add <code>form-material</code> class to the form that's it.</h6> -->
                                <form action="actualizar_reserva_validate.php" method="POST" class="form-material m-t-20">


                                    <div class="row">
                                        <div class="col-2 col-sm-1">
                                            <a href="./reservas.php"><i style="font-size: 1.5rem" class="fas fa-arrow-circle-left"></i></a>
                                        </div>
                                        
                                        <div class="col-10 col-sm-5">
                                            <h4 class="card-title">Actualizar Reserva</h4>
                                        </div>
                                        <div class="col-12 col-sm-6 mb-2">
                                            <div class="d-flex justify-content-end">
                                                <button id="enviarCorr" type="submit" class="btn btn-lg btn-info">Actualizar Reserva</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-12 col-sm-6">

                                            <div hidden class="form-group">
                                                <label>Estado</label>
                                                <input type="text" class="form-control form-control-line" id="estado" name="estado" value="<?php echo $objeto_dameReserva->Estado ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Dirección Operador</label>
                                                <input type="text" class="form-control form-control-line" id="direccionOperador" name="direccionOperador" value="<?php echo $objeto_dameOperador->Direccion ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Población</label>
                                                <input type="text" class="form-control form-control-line" id="poblacionOperador" name="poblacionOperador" value="<?php echo $objeto_dameOperador->Poblacion ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Teléfono</label>
                                                <input type="text" class="form-control form-control-line" id="telefonoOperador" name="telefonoOperador" value="<?php echo $objeto_dameOperador->Telefono ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Email Operador</label>
                                                <input type="text" class="form-control form-control-line" id="emailOperador" name="emailOperador" value="<?php echo $objeto_dameOperador->Email ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>URL ubiLocker</label>
                                                <input type="text" class="form-control form-control-line" id="ubiLocker" name="ubiLocker" value="<?php echo $ubiLocker ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Nombre Operador</label>
                                                <input type="text" class="form-control form-control-line" id="operador" name="operador" value="<?php echo $objeto_dameOperador->Nombre ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Movil Operador</label>
                                                <input type="text" class="form-control form-control-line" id="movilOperador" name="movilOperador" value="<?php echo $objeto_dameOperador->Movil ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>ID Operador</label>
                                                <input type="number" class="form-control form-control-line" id="idOperador" name="idOperador" value="<?php echo $idOperador ?>" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Nº Reserva</label>
                                                <input type="text" class="form-control form-control-line" value="<?php echo $objeto_dameReserva->IdReserva ?>" name="idReserva" id="idReserva" readonly>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-12 col-sm-2">
                                                    <label for="example-date-input" class="col-form-label">Entrada</label>
                                                </div>

                                                <div class="col-12 col-sm-10">
                                                    <input onchange="cambiarPuertaEntrada(), comprobarContrato()" class="form-control" type="date" value="<?php echo $newInPutDate ?>" name="entrada" id="example-date-input">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-12 col-sm-2">
                                                    <label for="example-date-input" class="col-form-label">Salida</label>
                                                </div>

                                                <div class="col-12 col-sm-10">
                                                    <input onchange="comprobarContrato()" class="form-control" type="date" value="<?php echo $newOutPutDate ?>" name="salida" id="example-date-input2">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Referencia</label>
                                                <input type="text" class="form-control form-control-line" name="referencia" value="<?php echo $objeto_dameReserva->Referencia ?>" required data-validation-required-message="This field is required" readonly>
                                            </div>

                                            <div class="form-group">
                                                <label>Nombre y Apellidos</label>
                                                <input type="text" class="form-control form-control-line" name="nombre" id="nombre" value="<?php echo $objeto_dameReserva->Nombre ?>" required data-validation-required-message="This field is required" readonly>
                                            </div>

                                            <div class="form-group" style="overflow: visible !important;">
                                                <label>Movil</label>
                                                <input type="tel" class="form-control form-control-line" name="full_phone" id="phone" value="<?php echo $objeto_dameReserva->Movil ?>" required data-validation-required-message="This field is required" <?php echo $nomuestra_est2; ?>>  
                                            </div>
                                            
                                            <div class="form-group col-md-12 m-t-20">
                                                <label>Observaciones</label>
                                                <textarea class="form-control" rows="5" name="observaciones" value=""><?php echo $objeto_dameReserva->Observaciones ?></textarea>
                                            </div>

                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group">
                                                <label>Localizador</label>
                                                <input type="text" class="form-control form-control-line" name="localizador" id="localizador" value="<?php echo $objeto_dameReserva->Localizador ?>" required data-validation-required-message="This field is required">
                                            </div>

                                            <div class="form-group">
                                                <label for="example-email">Email</label>
                                                <input type="email" id="example-email" name="example-email" class="form-control" value="<?php echo $objeto_dameReserva->Email ?>" required data-validation-required-message="This field is required" <?php echo $nomuestra_est2; ?>>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>Pin Entrada</label>
                                                        <input type="text" class="form-control form-control-line" name="pinEntrada" id="pinEntrada" value="<?php echo $objeto_dameReserva->PinEntrada ?>" readonly required data-validation-required-message="This field is required">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>Puerta Entrada</label>
                                                        <input type="text" class="form-control form-control-line" name="idPuertaEntrada" id="idPuertaEntrada" value="<?php echo $objeto_dameReserva->IdPuertaEntrada ?>" readonly required data-validation-required-message="This field is required">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <h5>Notificar al cliente</h5>
                                                        <fieldset class="controls">
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" value="1" name="styled_radio" id="styled_radio1" class="custom-control-input" checked>
                                                                <label class="custom-control-label" for="styled_radio1">Si</label>
                                                            </div>
                                                        </fieldset>
                                                        <fieldset>
                                                            <div class="custom-control custom-radio">
                                                                <input type="radio" value="2" name="styled_radio" id="styled_radio2" class="custom-control-input">
                                                                <label class="custom-control-label" for="styled_radio2">No</label>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>

                                                <div class="col-12 col-sm-6">
                                                    <div class="form-group">
                                                        <label>Elige Notificación</label>
                                                        <select class="form-control" name="notificacion">
                                                            <option <?php echo $movil ?> value="1">SMS Movil</option>
                                                            <option <?php echo $email ?> value="2">Email</option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Idioma</label>
                                                <select class="form-control" name="idioma" required data-validation-required-message="This field is required">
                                                    <option value="1">Castellano</option>
                                                    <option value="2">Inglés</option>
                                                    <option value="3">Alemán</option>
                                                </select>
                                            </div>
                                            

                                        </div>
                                    </div>
                                </form>
                                <div class="row d-flex justify-content-end">
                                    <div class="col-12 col-sm-2">
                                        <div class="form-group row">
                                            <label for="inputEmail3" class="col-sm-3 text-sm-right control-label col-form-label">Estado:</label>
                                            <div class="col-sm-9">
                                                <label class="control-label col-form-label"><span <?php echo $colorEstado ?>><?php echo $estado ?></span></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- .row -->
               
                <!-- ============================================================== -->
                <!-- End Page Content -->
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
    <!-- Sweet-Alert  -->
	<script src="./../../../assets/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="./../../../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../../../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../../../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../../dist/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script src="../../dist/js/pages/jasny-bootstrap.js"></script>
    <script src="../js/crear_reserva.js"></script>
    <script src="./../js/actualizar_reserva.js"></script>
    
    <script src="../../../src/js/intlTelInput.js"></script>
    <script src="../../../src/js/prism.js"></script>    
    <script src="../../../node_modules/intl-tel-input/intlTelInput.js?71"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            hiddenInput: "full_phone",
            utilsScript: "../../../node_modules/intl-tel-input/utils.js?21",
            initialCountry: "es",
            preferredCountries: ["es"],

        });
    </script>


</body>

</html>