<?php

    setcookie("tiempoUsuario2", "Maximo tiempo de sesion para un Usuario", time() + 1200);


    if (isset($_COOKIE['tiempoUsuario2'])) {

        session_start();

    } else {

		unset($_COOKIE['tiempoUsuario2']);
        session_destroy();
        header("Location: ../index.php");

    }

?>

<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
	<!-- Sidebar - Brand -->
    <div class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
    	<div class="sidebar-brand-icon">
        	<img src="../imagenes/lockers/<?php echo $_SESSION['IdLocker'];?>.png" width="150" alt=""/>
        </div>
    </div>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <?php
    // PAGINA ACTIVA
    echo '<li class="nav-item'.($pagina_actual == 'dashboard' ? ' active' : '').'"><a class="nav-link" href="dashboard.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a></li>';
	
    switch ($_SESSION['id_operador']){
		// KEYPOINT
		case "0":
			echo '	<li class="nav-item'.($pagina_actual == 'lockers' || $pagina_actual == 'controladores' || $pagina_actual == 'puertas' || $pagina_actual == 'tipospuerta' || $pagina_actual == 'actualizar-locker' || $pagina_actual == 'crear-locker' || $pagina_actual == 'actualizar-controlador' || $pagina_actual == 'crear-controlador' || $pagina_actual == 'actualizar-puerta' || $pagina_actual == 'crear-puerta'? ' active' : '').'">
                		<a class="nav-link '.($pagina_actual != 'lockers' && $pagina_actual != 'controladores' && $pagina_actual != 'puertas' && $pagina_actual != 'tipospuerta' && $pagina_actual != 'actualizar-locker' && $pagina_actual != 'crear-locker' && $pagina_actual != 'actualizar-controlador' && $pagina_actual != 'crear-controlador' && $pagina_actual != 'actualizar-puerta' && $pagina_actual != 'crear-puerta' && $pagina_actual != 'actualizar-tipopuerta' && $pagina_actual != 'crear-tipopuerta' ? ' collapsed' : '').'" href="#" data-toggle="collapse" href="#" data-toggle="collapse" data-target="#lockers" aria-expanded="true" aria-controls="lockers">
                    		<i class="fas fa-fw fa-border-all"></i> 
                      		<span>Conf. Lockers</span>
        		        </a>
        		        <div id="lockers" class="collapse'.($pagina_actual == 'lockers' || $pagina_actual == 'controladores' ||  $pagina_actual == 'puertas' || $pagina_actual == 'tipospuerta' || $pagina_actual == 'actualizar-locker' || $pagina_actual == 'crear-locker' || $pagina_actual == 'actualizar-controlador' || $pagina_actual == 'crear-controlador' || $pagina_actual == 'actualizar-puerta' || $pagina_actual == 'crear-tipopuerta' || $pagina_actual == 'actualizar-tipopuerta' || $pagina_actual == 'crear-puerta' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		                    <div class="bg-white py-2 collapse-inner rounded">
		                    	<a class="collapse-item'.($pagina_actual == 'lockers' || $pagina_actual == 'crear-locker' || $pagina_actual == 'actualizar-locker' ? ' active' : '').'" href="lockers.php"><i class="fas fa-border-all" style="margin-right: 10px;"></i> Lockers <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'controladores' || $pagina_actual == 'crear-controlador' || $pagina_actual == 'actualizar-controlador' ? ' active' : '').'" href="controladores.php"><i class="fas fa-list-ol" style="margin-right: 10px;"></i> Controladores <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'puertas' || $pagina_actual == 'crear-puerta' || $pagina_actual == 'actualizar-puerta' ? ' active' : '').'" href="puertas.php"><i class="fas fa-door-open" style="margin-right: 10px;"></i> Puertas <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'tipospuerta' || $pagina_actual == 'crear-tipopuerta' || $pagina_actual == 'actualizar-tipopuerta' ? ' active' : '').'" href="tipospuerta.php"><i class="fas fa-door-closed" style="margin-right: 10px;"></i> Tipos de Puertas <span class=""></span></a>
		                    </div>
		                </div>
        		    </li>
 					<li class="nav-item'.($pagina_actual == 'usuarios' || $pagina_actual == 'roles' || $pagina_actual == 'crear-usuario' || $pagina_actual == 'actualizar-usuario' || $pagina_actual == 'crear-rol' || $pagina_actual == 'actualizar-rol' ? ' active' : '').'">
                		<a class="nav-link '.($pagina_actual != 'usuarios' && $pagina_actual != 'roles' && $pagina_actual != 'crear-usuario' && $pagina_actual != 'actualizar-usuario' || $pagina_actual != 'crear-rol' || $pagina_actual != 'actualizar-rol' ? ' collapsed' : '').'" href="#" data-toggle="collapse" data-target="#usuarios" aria-expanded="true" aria-controls="usuarios">
                    		<i class="fas fa-fw fa-user-cog"></i> 
                      		<span>Usuarios</span>
        		        </a>
						<div id="usuarios" class="collapse'.($pagina_actual == 'usuarios' || $pagina_actual == 'roles' ||  $pagina_actual == 'crear-usuario' || $pagina_actual == 'actualizar-usuario' || $pagina_actual == 'crear-rol' || $pagina_actual == 'actualizar-rol' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		                    <div class="bg-white py-2 collapse-inner rounded">
		                    	<a class="collapse-item'.($pagina_actual == 'roles' || $pagina_actual == 'crear-rol' || $pagina_actual == 'actualizar-rol' ? ' active' : '').'" href="roles.php"><i class="fas fa-users" style="margin-right: 10px;"></i> Roles <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'usuarios' || $pagina_actual == 'crear-usuario' || $pagina_actual == 'actualizar-usuario' ? ' active' : '').'" href="usuarios.php"><i class="fas fa-user" style="margin-right: 10px;"></i> Usuarios <span class=""></span></a>
		                    </div>
		                </div>
        		    </li>
					<li class="nav-item'.($pagina_actual == 'operadores' || $pagina_actual == 'crear-operador' || $pagina_actual == 'actualizar-operador' || $pagina_actual == 'administrar-puertas'? ' active' : '').'">
                		<a class="nav-link'.($pagina_actual != 'operadores' && $pagina_actual != 'crear-operador' && $pagina_actual != 'actualizar-operador' && $pagina_actual != 'administrar-puertas' ? ' collapsed' : '').'" href="#" data-toggle="collapse" data-target="#operadores" aria-expanded="true" aria-controls="operadores">
                    		<i class="fas fa-fw fa-user-cog"></i> 
                      		<span>Operadores</span>
        		        </a>
						<div id="operadores" class="collapse'.($pagina_actual == 'operadores' || $pagina_actual == 'crear-operador' || $pagina_actual == 'actualizar-operador' || $pagina_actual == 'contratos' || $pagina_actual == 'crear-contrato' || $pagina_actual == 'actualizar-contrato' || $pagina_actual == 'administrar-puertas' || $pagina_actual == 'estadoActual' || $pagina_actual == 'trazabilidadPorFechas' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		                    <div class="bg-white py-2 collapse-inner rounded">
		                    	<a class="collapse-item'.($pagina_actual == 'operadores' || $pagina_actual == 'crear-operador' || $pagina_actual == 'actualizar-operador' ? ' active' : '').'" href="operadores.php"><i class="fas fa-fw fa-user-cog" style="margin-right: 10px;"></i> Operadores <span class=""></span></a>
		                    	<a class="collapse-item'.($pagina_actual == 'contratos' || $pagina_actual == 'crear-contrato' || $pagina_actual == 'actualizar-contrato' ? ' active' : '').'" href="contratos.php"><i class="fas fa-file-signature" style="margin-right: 10px;"></i> Contratos <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'administrar-puertas' ? ' active' : '').'" href="administrar-puertas.php"><i class="fas fa-th" style="margin-right: 10px;"></i> Administrar Puertas <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'estadoActual' ? ' active' : '').'" href="estadoActual.php"><i class="fas fa-door-closed" style="margin-right: 10px;"></i> Estado Actual <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'trazabilidadPorFechas' ? ' active' : '').'" href="trazabilidadPorFechas.php"><i class="fas fa-search" style="margin-right: 10px;"></i> Trazabilidad<span class=""></span></a>
		                    </div>
		                </div>
        		    </li>
					<li class="nav-item'.($pagina_actual == 'disponiblidad' ? ' active' : '').'">
						<a class="nav-link'.($pagina_actual != 'disponiblidad' ? ' collapsed' : '').'" href="#" data-toggle="collapse" data-target="#disponiblidad" aria-expanded="true" aria-controls="operadores">
							<i class="fas fa-border-all"></i> 
							<span>Disponiblidad</span>
						</a>
						<div id="disponiblidad" class="collapse'.($pagina_actual == 'disponiblidad' || $pagina_actual == 'disponiblidadLocker' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
							<div class="bg-white py-2 collapse-inner rounded">
							<a class="collapse-item'.($pagina_actual == 'disponiblidadLocker' ? ' active' : '').'" href="disponiblidadLocker.php"><i class="fas fa-border-all" style="margin-right: 10px;"></i> Locker <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'disponiblidad' ? ' active' : '').'" href="disponiblidad.php"><i class="fas fa-user-cog" style="margin-right: 10px;"></i> Por Operador <span class=""></span></a>
							</div>
						</div>
					</li>
			';
		break;
		// ADMIN
		case "111":	
		case "1":
			echo '	<li class="nav-item'.($pagina_actual == 'usuarios' || $pagina_actual == 'roles' || $pagina_actual == 'crear-usuario' || $pagina_actual == 'actualizar-usuario' || $pagina_actual == 'crear-rol' || $pagina_actual == 'actualizar-rol' ? ' active' : '').'">
                		<a class="nav-link '.($pagina_actual != 'usuarios' && $pagina_actual != 'roles' && $pagina_actual != 'crear-usuario' && $pagina_actual != 'actualizar-usuario' || $pagina_actual != 'crear-rol' || $pagina_actual != 'actualizar-rol' ? ' collapsed' : '').'" href="#" data-toggle="collapse" data-target="#usuarios" aria-expanded="true" aria-controls="usuarios">
                    		<i class="fas fa-fw fa-user-cog"></i> 
                      		<span>Usuarios</span>
        		        </a>
						<div id="usuarios" class="collapse'.($pagina_actual == 'usuarios' || $pagina_actual == 'roles' ||  $pagina_actual == 'crear-usuario' || $pagina_actual == 'actualizar-usuario' || $pagina_actual == 'crear-rol' || $pagina_actual == 'actualizar-rol' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		                    <div class="bg-white py-2 collapse-inner rounded">
		                    	<a class="collapse-item'.($pagina_actual == 'roles' || $pagina_actual == 'crear-rol' || $pagina_actual == 'actualizar-rol' ? ' active' : '').'" href="roles.php"><i class="fas fa-users" style="margin-right: 10px;"></i> Roles <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'usuarios' || $pagina_actual == 'crear-usuario' || $pagina_actual == 'actualizar-usuario' ? ' active' : '').'" href="usuarios.php"><i class="fas fa-user" style="margin-right: 10px;"></i> Usuarios <span class=""></span></a>
		                    </div>
		                </div>
        		    </li>
					<li class="nav-item'.($pagina_actual == 'operadores' || $pagina_actual == 'crear-operador' || $pagina_actual == 'actualizar-operador' || $pagina_actual == 'administrar-puertas'? ' active' : '').'">
                		<a class="nav-link'.($pagina_actual != 'operadores' && $pagina_actual != 'crear-operador' && $pagina_actual != 'actualizar-operador' && $pagina_actual != 'administrar-puertas' ? ' collapsed' : '').'" href="#" data-toggle="collapse" data-target="#operadores" aria-expanded="true" aria-controls="operadores">
                    		<i class="fas fa-fw fa-user-cog"></i> 
                      		<span>Operadores</span>
        		        </a>
						<div id="operadores" class="collapse'.($pagina_actual == 'operadores' || $pagina_actual == 'crear-operador' || $pagina_actual == 'actualizar-operador' || $pagina_actual == 'contratos' || $pagina_actual == 'crear-contrato' || $pagina_actual == 'actualizar-contrato' || $pagina_actual == 'administrar-puertas' || $pagina_actual == 'estadoActual' || $pagina_actual == 'trazabilidadPorFechas' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
		                    <div class="bg-white py-2 collapse-inner rounded">
		                    	<a class="collapse-item'.($pagina_actual == 'operadores' || $pagina_actual == 'crear-operador' || $pagina_actual == 'actualizar-operador' ? ' active' : '').'" href="operadores.php"><i class="fas fa-user-cog" style="margin-right: 10px;"></i> Operadores <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'contratos' || $pagina_actual == 'crear-contrato' || $pagina_actual == 'actualizar-contrato' ? ' active' : '').'" href="contratos.php"><i class="fas fa-file-signature" style="margin-right: 10px;"></i> Contratos <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'administrar-puertas' ? ' active' : '').'" href="administrar-puertas.php"><i class="fas fa-th" style="margin-right: 10px;"></i> Administrar Puertas <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'estadoActual' ? ' active' : '').'" href="estadoActual.php"><i class="fas fa-door-closed" style="margin-right: 10px;"></i> Estado Actual <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'trazabilidadPorFechas' ? ' active' : '').'" href="trazabilidadPorFechas.php"><i class="fas fa-search" style="margin-right: 10px;"></i> Trazabilidad<span class=""></span></a>
		                    </div>
		                </div>
        		    </li>
					<li class="nav-item'.($pagina_actual == 'disponiblidad' ? ' active' : '').'">
						<a class="nav-link'.($pagina_actual != 'disponiblidad' ? ' collapsed' : '').'" href="#" data-toggle="collapse" data-target="#disponiblidad" aria-expanded="true" aria-controls="operadores">
							<i class="fas fa-border-all"></i> 
							<span>Disponiblidad</span>
						</a>
						<div id="disponiblidad" class="collapse'.($pagina_actual == 'disponiblidad' || $pagina_actual == 'disponiblidadLocker' ? ' show' : '').'" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
							<div class="bg-white py-2 collapse-inner rounded">
							<a class="collapse-item'.($pagina_actual == 'disponiblidadLocker' ? ' active' : '').'" href="disponiblidadLocker.php"><i class="fas fa-border-all" style="margin-right: 10px;"></i> Locker <span class=""></span></a>
								<a class="collapse-item'.($pagina_actual == 'disponiblidad' ? ' active' : '').'" href="disponiblidad.php"><i class="fas fa-user-cog" style="margin-right: 10px;"></i> Por Operador <span class=""></span></a>
							</div>
						</div>
					</li>
			';
		break;

		default:
			// NO ES EL OPERADOR KEYPOINT Y, POR LO TANTO, REVISAMOS LOS USUARIOS
			switch ($_SESSION['rol_user']){
				// ADMINISTRADOR
				case 0:


				break;

			}
		break;
	}


	//echo '<li class="nav-item'.($pagina_actual == 'dashboard' ? ' active' : '').'"><a class="nav-link" href="dashboard.php"><i class="fas fa-fw fa-tachometer-alt"></i><span>Informes</span></a></li>';
	?>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>