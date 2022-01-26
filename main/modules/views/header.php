<?php

    setcookie("tiempoUsuario", "Maximo tiempo de sesion para un Usuario", time() + 1200);


    if (isset($_COOKIE['tiempoUsuario'])) {

        session_start();

    } else {

        unset($_COOKIE['tiempoUsuario']);
        session_destroy();
        header("Location: index.php");

    }
    


    if(empty($_SESSION)) {

        header('location:index.php');
        die();

    } 
        
        require('./../ws/ws_users/ws_dameUsuarios.php');

        require './../ws/ws_lockers/ws_dameLocker.php';

        $_SESSION['idLocker'];
        $ubiLocker = $objeto_dameLocker->URLMaps;
        $ocultarALosAdmin = '';
        $ocultarALosUsers = '';
        $ocultarFiltroOperador ='';
        $ocultarEnlaceApp='';
        $ocultarBuscarOperador='';
        $hoy = date("Ymd");

     if($_SESSION['rol'] === 0 || $_SESSION['rol'] === 1 || $_SESSION['rol'] === null && $_SESSION['idOperador'] !== "0") {

         $ocultarALosAdmin = 'hidden';
         $ocultarFiltroOperador ='hidden';
         $ocultarEnlaceApp='hidden';
         $ocultarBuscarOperador='hidden';


     } elseif ($_SESSION['rol'] === 0 || $_SESSION['rol'] === 2 || $_SESSION['rol'] === null && $_SESSION['idOperador'] !== "0") {

         $ocultarALosUsers = 'hidden';
         $ocultarFiltroOperador ='hidden';
         $ocultarEnlaceApp='hidden';
         $ocultarBuscarOperador='hidden';

     }


?>

<?php

if(isset($_SESSION['operator']) && isset($_SESSION['idOperador']) && isset($_SESSION['movilOper'])) {
    $operador = $_SESSION['operator'];
    $movilOper = $_SESSION['movilOper'];
}

$contratoDesde = date('d/m/Y', strtotime($_SESSION['contrato_desde']));
$contratoHasta = date('d/m/Y', strtotime($_SESSION['contrato_hasta']));

?>

<header class="topbar">
    <nav class="top-navbar">
        <!-- ============================================================== -->
        <!-- Logo -->
        <!-- ============================================================== -->
        <div class="navbar-header">
            <div class="row">
                <div class="col-1 d-lg-none">
                    <ul class="navbar-nav">
                        <li class="nav-item hidden-sm-up"> <a class="nav-link nav-toggler waves-effect waves-light" href="javascript:void(0)"><i class="ti-menu"></i></a></li>
                    </ul>
                </div>

                <div class="col-1 col-lg-2 d-flex">
                    <img class="d-none d-md-block" src="./../img/smart_key_logo_1.png" width="37%">

                    <a <?php echo $ocultarEnlaceApp ?> class="ml-5" href="http://localhost/elegant/horizontal/index.html">Elementos de la App</a>
                </div>

                <div class="col-6 col-lg-6 d-flex">

                    <div class="d-flex align-items-center prova" title="Contrato">
                        <i style="font-size: 1.25rem;" class="fas fa-file-signature mr-3"></i> 

                        <strong><p class="m-0"><?php echo $contratoDesde; echo " - "; echo $contratoHasta;?></p></strong>
                    </div>

                </div>

                <div class="col-2 col-lg-3 d-flex justify-content-around">
                    <div class="d-flex align-items-center prova">
                        <i style="font-size: 1.25rem;" class="fas fa-user mr-3"></i> 

                        <strong><p class="m-0"><?php echo $_SESSION['user'] ?></p></strong>
                    </div>

                    <div class="d-flex align-items-center prova">
                        <i style="font-size: 1.25rem;" class="fas fa-house-user mr-3"></i> 

                        <p class="m-0"><strong><?php echo $_SESSION['operator'] ?></strong></p>
                    </div>
                </div>

                <div class="col-2 col-lg-1 d-flex justify-content-end">
                    <div class="d-flex">
                        <a href="logOut_validate.php"><button type="button" class="btn btn-outline-primary">Salir</button></a>
                    </div>
                </div>    
            </div>
        </div>
    </nav>
</header>