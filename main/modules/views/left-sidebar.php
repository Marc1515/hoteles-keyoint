<aside class="left-sidebar">

    <div class="d-flex no-block nav-text-box align-items-center">
        <img src="./../img/smart_key_logo_1.png"  height="40%" width="40%"/>
        <a class="nav-lock waves-effect waves-dark ml-auto hidden-md-down" href="javascript:void(0)"><i class="mdi mdi-toggle-switch"></i></a>
        <a class="nav-toggler waves-effect waves-dark ml-auto hidden-sm-up" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
    </div>
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">

                <li><a href="dashboard.php">Dashboard<i class="mdi mdi-keyboard m-0"></i></a></li>

                <li><a href="estadoActual.php">Estado Actual<i class="mdi mdi-grid m-0"></i></a></li>

                <!-- <li><a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-key-variant m-0"></i><span class="hide-menu">Reservas</span></a>
                    <ul aria-expanded="false" class="collapse"> -->
                        <li><a href="reservas.php">Reservas<i class="mdi mdi-key-variant m-0"></i></a></li>
                        <!-- <li><a href="reservas_no-shows.php">NO-Shows<i class="mdi mdi-key-variant m-0"></i></a></li>                 
                    </ul>
                </li> -->
                

                <li><a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="fas fa-search"></i><span class="hide-menu">Trazabilidad</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="trazabilidad.php">Trazabilidad por Reserva<i class="far fa-circle text-info"></i></a></li>
                        <li><a href="trazabilidadPorFecha.php">Trazabilidad por Fecha<i class="far fa-circle text-info"></i></a></li>
                    </ul>
                </li>
                
                <li <?php /* echo $ocultarALosUsers */ ?>><a href="disponiblidad.php">Disponiblidad<i class="fas fa-book"></i></a></li>
                
                <li <?php echo $ocultarALosUsers ?>><a href="users.php">Usuarios<i class="fas fa-users"></i></a></li>
                
                <li <?php echo $ocultarALosAdmin ?> <?php echo $ocultarALosUsers ?>><a href="operadores.php">Operadores<i class="far fa-circle text-danger"></i></a></li>
                
                <li <?php echo $ocultarALosAdmin ?> <?php echo $ocultarALosUsers ?>><a href="cuposDePuertas.php">Administrar Puertas<i class="far fa-circle text-warning"></i></a></li>

                
                <li <?php echo $ocultarALosAdmin ?> <?php echo $ocultarALosUsers ?>> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Cupos de Puertas</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="cuposDisponibles.php">Cupos por Fecha<i class="far fa-circle text-success"></i></a></li>
                    </ul>
                </li>
            
                <li <?php echo $ocultarALosAdmin ?> <?php echo $ocultarALosUsers ?>> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)" aria-expanded="false"><i class="ti-layout-grid2"></i><span class="hide-menu">Entradas y Salidas</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="entradas.php">Entradas<i class="far fa-circle text-success"></i></a></li>
                        <li><a href="salidas.php">Salidas<i class="far fa-circle text-success"></i></a></li>
                    </ul>
                </li>
            
            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>