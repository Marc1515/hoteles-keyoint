<?php 
$txt_error = "";
if(isset($_GET['error'])){
	if($_GET['error'] == 1){$txt_error = '<p style="color:red";>No coinciden las contraseñas</p>';}
}
?><!DOCTYPE html>
<html lang="en">

<?php require('../heads/head-crear-usuario.php') ?>

<body class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php require('preloader.php') ?>
    
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
                                <div class="row">
                                    <div class="col-2 col-sm-1">
                                        <a href="./users.php"><i style="font-size: 1.5rem" class="fas fa-arrow-circle-left"></i></a>
                                    </div>
                                    
                                    <div class="col-10 col-sm-11">
                                        <h4 class="card-title">Nuevo Usuario</h4>
                                    </div>
                                </div>
                                <!-- <h6 class="card-subtitle">Just add <code>form-material</code> class to the form that's it.</h6> -->
                                <form action="crear_user_validate.php" method="POST" id="formularioUser" class="form-material m-t-40">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">

                                            <div hidden class="form-group">
                                                <label>Nombre Operador</label>
                                                <input type="text" class="form-control form-control-line" id="operador" value="<?php echo $operador ?>" readonly>
                                            </div>

                                            <div hidden class="form-group">
                                                <label>Numero Operador</label>
                                                <input type="text" class="form-control form-control-line" id="numOperador" value="<?php echo $_SESSION['idOperador'] ?>" readonly>
                                            </div>

                                            <div class="form-group" id="grupo__nombre">
                                                <label class="m-0 pb-2" for="nameUser">Nombre</label>
                                                <input type="text" class="form-control form-control-line" id="nameUser" name="nombre" placeholder="John Doe" required data-validation-required-message="This field is required">
                                                <p id="error__p__nombre" class="error__p">El nombre no puede contener números ni carácteres especiales</p>
                                            </div>

                                            <div class="form-group" id="grupo__usuario">
                                                <label class="m-0 pb-2" for="nickName">Nombre de Usuario</label>
                                                <input type="text" class="form-control form-control-line" id="nickName" name="nombreUsuario" placeholder="JohnDoe7" maxlength="20" required data-validation-required-message="This field is required">
                                                <p id="error__p__user" class="error__p">El nombre de Usuario debe contener entre 4 i 20 letras, "números opcionales"</p>
                                            </div>

                                            <div class="form-group" id="grupo__pwd">
                                                <label class="m-0 pb-2" for="pwd">Contraseña</label>
                                                <input type="password" class="form-control form-control-line" name="pwd" id="pwd" placeholder="********" required data-validation-required-message="This field is required">  
                                                <p id="error__p__pwd" class="error__p">Se permite un mínimo de 4 y un màximo de 12 dígitos</p>
                                            </div>

                                            <div class="form-group" id="grupo__pwd2">
                                                <label class="m-0 pb-2" for="pwd2">Confirmacion de Contraseña</label>
                                                <input type="password" class="form-control form-control-line" name="pwd2" id="pwd2" placeholder="********" required data-validation-required-message="This field is required">  
                                                <p id="error__p__pwd2" class="error__p">Se permite un mínimo de 4 y un màximo de 12 dígitos</p>
                                                <p id="error__p__confirm" class="error__p">La confirmación no es correcta</p>
                                            </div>

                                            <?php echo $txt_error;?>

                                            <div class="form-group">
                                                <label>Rol de Usuario</label>
                                                <select class="custom-select col-12" id="inlineFormCustomSelect" name="idRol" required data-validation-required-message="This field is required">
                                                    <option value="">Elige un Rol</option>
                                                    <option value="1">Administrador</option>
                                                    <option value="2">Usuario</option>
                                                </select>
                                            </div>
                                            
                                        </div>
                                        <div class="col-12 col-sm-6">
                                            <div class="form-group" id="grupo__email">
                                                <label class="m-0 pb-2" for="example-email">Email</label>
                                                <input type="email" id="example-email" name="example-email" class="form-control" placeholder="ejemplo@email.com" required data-validation-required-message="This field is required">
                                                <p id="error__p__email" class="error__p">El correo electrònico no es correcto</p>
                                            </div>
                                            <div class="form-group" id="grupo__phone" style="overflow: visible !important;">
                                                <label class="m-0 pb-2" for="phone">Movil</label>
                                                <input type="tel" class="form-control form-control-line" name="full_phone" id="phone" placeholder="000 000 000" required data-validation-required-message="This field is required">  
                                                <p id="error__p__phone" class="error__p">Solo entre 7 y 14 dígitos</p>
                                            </div>

                                            <div class="form-group">
                                                <label class="m-0 pb-2" for="pin">Pin</label>
                                                <input type="text" class="form-control form-control-line" id="pin" name="pin" placeholder="******" required data-validation-required-message="This field is required" maxlength="6">
                                            </div>

                                            <div class="row d-flex justify-content-end">
                                                <button type="submit" class="btn btn-lg btn-info" id="crearUser">Crear Usuario</button>
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

<script src="./../js/form_user.js"></script>
<script src="./../js/enviarCorreoUser.js"></script>
</body>

</html>