<!DOCTYPE html>
<html lang="en">

<?php require('../heads/head-actualizar-operador.php') ?>

<body class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php require('preloader.php') ?>
    <!-- ============================================================== -->
    <?php require('../ws/ws_operadores/ws_dameOperador.php') ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php require('header.php')?>
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
                                <h4 class="card-title">Actualizar Operador</h4>
                                <form action="actualizar_operador_validate.php" method="POST" class="form-material m-t-40" id="formularioOperator">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group" hidden>
                                                <label>ID</label>
                                                <input type="text" class="form-control form-control-line" name="idOperador" value="<?php echo $objeto_dameOperador->IdOperador ?>" required data-validation-required-message="This field is required">
                                            </div>
                                            <div class="form-group" id="grupo__nombre">
                                                <label class="m-0 pb-2" for="nombre">Nombre</label>
                                                <input type="text" class="form-control form-control-line" name="nombre" id="nombre" value="<?php echo $objeto_dameOperador->Nombre ?>" required data-validation-required-message="This field is required">
                                                <p id="error__p__nombre" class="error__p">El nombre no puede contener números ni carácteres especiales</p>
                                            </div>
                                            <div class="form-group" id="grupo__email">
                                                <label class="m-0 pb-2" for="email">Email</label>
                                                <input type="text" class="form-control form-control-line" name="email" id="email" value="<?php echo $objeto_dameOperador->Email ?>" required data-validation-required-message="This field is required">
                                                <p id="error__p__email" class="error__p">El correo electrònico no es correcto</p>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group" id="grupo__phone" style="overflow: visible !important;">
                                                <label class="m-0 pb-2" for="phone">Movil</label>
                                                <input type="text" class="form-control form-control-line" name="phone" id="phone" value="<?php echo $objeto_dameOperador->Movil ?>" required data-validation-required-message="This field is required">
                                                <p id="error__p__phone" class="error__p">Solo entre 7 y 14 dígitos</p>
                                            </div>
                                            <div class="row d-flex justify-content-end">
                                                <button type="submit" class="btn btn-lg btn-info">Actualizar Operador</button>
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
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <script src="../../dist/js/pages/jasny-bootstrap.js"></script>
    <script src="../js/crear_reserva.js"></script>
    <script src="./../js/form_operador.js"></script>
    
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