<!DOCTYPE html>
<html lang="en">

<?php require('../heads/head-crear-reserva.php') ?>

<body onload="cambiarPinEntrada(), cambiarPuertaEntrada(), comprobarContrato()" class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php /* require('preloader.php'); */ ?>
    <?php require('email.php'); ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php require('header.php'); ?>
        <?php require('./../ws/ws_reservas/ws_dameReservaPorOperador.php'); ?>
        <?php require './../ws/ws_operadores/ws_dameOperadores.php'; ?>
        <?php

        session_start();

        require './../ws/ws_operadores/ws2.php';

        $idLocker = $_SESSION['idLocker'];
        
        // --- LLAMAR WS : DameOperador --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_dameOperador = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$idOperador);
        $soap_result_DO = $client->DameOperador($parametros_dameOperador);

        $objeto_dameOperador = $soap_result_DO->DameOperadorResult;
        
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
                                <form action="crear_reserva_validate.php" method="POST" class="form-material m-t-20" id="formReserva">
                                    <div class="row">

                                        <div class="col-2 col-sm-1">
                                            <a href="./reservas.php"><i style="font-size: 1.5rem" class="fas fa-arrow-circle-left"></i></a>
                                        </div>
                                        
                                        <div class="col-10 col-sm-5">
                                            <h4 class="card-title">Nueva Reserva</h4>
                                        </div>

                                        <div class="col-12 col-sm-6 mb-2">
                                            <div class="d-flex justify-content-end">
                                                <button onmousedown="generarLocalizador()" type="submit" id="enviarCorr" class="btn btn-lg btn-info waves-effect waves-light">Crear Reserva</button>
                                            </div>
                                        </div>


                                        <div class="col-12 col-sm-6">

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

                                            <div hidden class="form-group">
                                                <label>Nº Reserva</label>
                                                <input type="text" class="form-control form-control-line" id="lastReserva" value="0" readonly>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-12 col-sm-12 col-md-2">
                                                    <label for="example-date-input" class="col-form-label">Entrada</label>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-10">
                                                    <input type="date" onchange="cambiarPuertaEntrada(), comprobarContrato()" value="<?php echo date("Y-m-d") ?>" class="form-control" name="entrada" id="example-date-input">
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-12 col-sm-12 col-md-2">
                                                    <label for="example-date-input2" class="col-form-label">Salida</label>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-10">
                                                    <input class="form-control" type="date" value="<?php $hoy = time(); $unDiaEnSegundos = 24*60*60; $mañana=$hoy+$unDiaEnSegundos;  echo $mañana=date("Y-m-d", $mañana) ?>" name="salida" id="example-date-input2">
                                                </div>
                                            </div>

                                            <div class="form-group" id="grupo__referencia">
                                                <label>Referencia</label>
                                                <input type="text" class="form-control form-control-line" name="referencia" id="referencia" placeholder="ejemplo">
                                            </div>

                                            <div class="form-group" id="grupo__nombre">
                                                <label>Nombre y Apellidos</label>
                                                <input type="text" class="form-control form-control-line" name="nombre" id="nombre" placeholder="John Doe" required data-validation-required-message="This field is required">
                                                <p id="error__p__nombre" class="error__p">El nombre no puede contener números ni carácteres especiales</p>
                                            </div>

                                            <div class="form-group" id="grupo__phone" style="overflow: visible !important;">
                                                <label>Movil</label>
                                                <input type="tel" class="form-control form-control-line" name="movil" id="phone" placeholder="000 000 000" required data-validation-required-message="This field is required"> 
                                                <p id="error__p__phone" class="error__p">Solo entre 7 y 14 dígitos</p>
                                            </div>

                                            <div class="form-group col-md-12 m-t-20">
                                                <label>Observaciones</label>
                                                <textarea class="form-control" rows="5" name="observaciones" placeholder="Cualquier observación que pueda resultar de ayuda..."></textarea>
                                            </div>
                                            
                                            
                                        </div>
                                        <div class="col-12 col-sm-6">

                                            <div class="form-group">
                                                <label>Localizador</label>
                                                <input type="text" class="form-control form-control-line" name="localizador" id="localizador">
                                            </div>

                                            <div class="form-group" id="grupo__email">
                                                <label for="example-email">Email</label>
                                                <input type="email" id="example-email" name="example-email" class="form-control" placeholder="ejemplo@email.com" required data-validation-required-message="This field is required">
                                                <p id="error__p__email" class="error__p">El correo electrònico no es correcto</p>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>Pin Entrada</label>
                                                        <input type="text" class="form-control form-control-line" name="pinEntrada" id="pinEntrada" readonly required data-validation-required-message="This field is required">
                                                    </div>
                                                    <!-- <div class="col-4 d-flex align-items-center justify-content-start">
                                                        <button type="button" class="btn btn-info waves-effect waves-light" id="botonPinEntrada"><i class="fas fa-redo-alt"></i></button>
                                                    </div> -->
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label>Puerta Entrada</label>
                                                        <input type="text" class="form-control form-control-line" name="idPuertaEntrada" id="idPuertaEntrada" readonly required data-validation-required-message="This field is required">
                                                    </div>
                                                    <!-- <div class="col-4 d-flex align-items-center justify-content-start">
                                                        <button type="button" class="btn btn-info waves-effect waves-light"><i class="fas fa-redo-alt"></i></button>
                                                    </div> -->
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
                                                        <select class="form-control" name="notificacion" required data-validation-required-message="This field is required">
                                                            <option value="2">Email</option>
                                                            <option value="1">SMS Movil</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12">
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
                                        </div>
                                    </div>
                                </form>
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
        <?php /* require('../ws/ws_reservas/ws_dameDisponiblesCupoFecha.php') */ ?>
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
    <script src="./../js/form_reserva.js"></script>
    
    <script src="../../../src/js/intlTelInput.js"></script>
    <script src="../../../src/js/prism.js"></script>    
    <script src="../../../node_modules/intl-tel-input/intlTelInput.js?71"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <script>
        var input = document.querySelector("#phone");
        window.intlTelInput(input, {
            hiddenInput: "full_phone",
            utilsScript: "../../../node_modules/intl-tel-input/utils.js?21",
            initialCountry: "es",
            preferredCountries: ["es"],

        });
    </script>
    <!-- <script src="./../js/enviarCorreoReserva.js"></script> -->

</body>

</html>