<?php 
$txt_error = "";
if(isset($_GET['error'])){
	if($_GET['error'] == 1) { 
        
        $txt_error = '<h4 style="color: #bb2929";>No coinciden el Usuario o la Contraseña!</h4>';

    } elseif ($_GET['error'] == 2) {
        
        $txt_error = '<h4 style="color: #bb2929";>El Operador NO existe!</h4>';

    } elseif ($_GET['error'] == 3) {

        $txt_error = '<h4 style="color: #bb2929";>No existe ningún usuario con este correo!</h4>';
        
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<?php require('../heads/head-login.php') ?>
<?php /* require './../ws/ws_reservas/ws_existeContrato_index.php'; */ ?>

<body class="skin-default card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php require('preloader.php') ?>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="cabecera">
        Cabecera, 2.0!
    </div>
    <section id="wrapper">
        <div class="login-register imagen-login">
            <div class="login-box card">
                <div class="card-body sombras-login rounded">
                    <form class="form-horizontal form-material" id="loginform" action="login_validate.php" method="POST">
                        <div class="d-flex justify-content-center my-4">
                            <img src="./../img/smart_key_logo_1.png" width="40%">
                        </div>
                        <h3 class="box-title m-b-20 text-center mb-5">Inicio Sesión</h3>
                        <div class="form-group">
                            <div class="col-xs-12">
                                <input onkeyup="comprobarContrato()" class="form-control" type="text" required="" placeholder="Nº Operador" name="operator" id="idOperador">
                            </div>
                        </div>
                        <div class="form-group" id="grupo__usuario">
                            <div class="col-xs-12">
                                <input class="form-control" type="text" required="" placeholder="Usuario" name="user" id="user">
                                <p id="error__p__user" class="error__p">El nombre de Usuario debe contener entre 4 i 20 letras, "números opcionales"</p>
                            </div>
                        </div>
                        <div class="form-group"  id="grupo__pwd">
                            <div class="col-xs-12">
                                <input class="form-control" type="password" required="" placeholder="Contraseña" name="pass" id="pass">
                                <p id="error__p__pwd" class="error__p">Se permite un mínimo de 4 y un màximo de 12 dígitos</p>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <div class="col-xs-12 p-b-20">
                                <button id="accederPlataforma" class="btn btn-block btn-lg btn-info btn-rounded mb-2" type="submit">Entrar</button>
                                <?php echo $txt_error;?>
                            </div>
                        </div>

                    </form>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-secondary" data-toggle="collapse" data-target="#recuperarPass">Recuperar Contraseña</button>
                    </div>
                    <form class="form-horizontal" action="recuperarPass_validate.php" method="POST">
                        <div class="form-group">
                            <div id="recuperarPass" class="collapse mt-3">
                                <p class="text-muted">Introduzca el correo electrónico.</p>
                            </div>

                            <div id="recuperarPass" class="collapse mb-3">
                                <input class="form-control" type="text" name="email" placeholder="Correo Electrónico" required data-validation-required-message="This field is required">
                            </div>

                            <div id="recuperarPass" class="collapse">
                                <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">Recuperar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
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
    <!--Custom JavaScript -->
    <script type="text/javascript">
    $(function() {
        $(".preloader").fadeOut();
    });
    $(function() {
        $('[data-toggle="tooltip"]').tooltip()
    });
    // ============================================================== 
    // Login and Recover Password 
    // ============================================================== 
    $('#to-recover').on("click", function() {
        $("#loginform").slideUp();
        $("#recoverform").fadeIn();
    });
    </script>

    <!-- Sweet-Alert  -->
	<script src="./../../../assets/node_modules/sweetalert2/dist/sweetalert2.min.js"></script>
	<script src="./../../../assets/node_modules/sweetalert2/sweet-alert.init.js"></script>

    <script>

function comprobarContrato() {
    

var idOperador = document.getElementById('idOperador').value;

    if (idOperador > 100) {

        var dataString = 'idOperador=' + idOperador;


    jQuery.ajax({
        data: dataString,
        type: 'POST',
        dataType: 'json',
        url: '../ws/ws_reservas/ws_existeContrato_index.php',
        success: function( payload ){



            if (payload.existeContrato === false) {

                Swal.fire({
                    type: 'error',
                    title: 'Sin Contrato!',
                    text: 'Antes de acceder a la plataforma debe disponer de un Contrato',
                });

                document.getElementById('accederPlataforma').disabled = true;

            } else {

                document.getElementById('accederPlataforma').disabled = false;

            }

        },
    /*     error: function(){
        console.log('error');
        } */
    });
    }

};

    </script>
    <script src="./../js/form_login.js"></script>
    
</body>

</html>
