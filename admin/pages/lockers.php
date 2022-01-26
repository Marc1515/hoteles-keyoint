<?php
session_start();

if (!isset($_SESSION['infApplogin_user'])) {
	header("location:../index.php");
	exit();
}
if((empty($_SESSION['rol_user']) && $_SESSION['rol_user'] != 0)|| empty($_SESSION['name_user']) || (empty($_SESSION['id_user']) && $_SESSION['id_user'] != 0)){
  header("location:http://".$_SERVER['SERVER_NAME']);
}

include_once('../includes/roles.php');
include_once('../../../ws_include/ws_Keys_consigna.php');
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Intranet - <?php echo $_SESSION['NombreLocker'];?></title>
    <?php include_once('../includes/scripts.php');?> 
</head>
<body id="page-top">
  	<!-- Page Wrapper -->
    <div id="wrapper">
	    <!-- Sidebar -->
	    <?php include_once("../includes/menu.php"); ?>
	    <!-- End of Sidebar -->

	    <!-- Content Wrapper -->
	    <div id="content-wrapper" class="d-flex flex-column">
	      
	        <!-- Main Content -->
	        <div id="content">
	          
				<!-- Topbar -->
				<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
					<!-- Sidebar Toggle (Topbar) -->
					<button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
					  <i class="fa fa-bars"></i>
					</button>

					<!-- Topbar Navbar -->
					<ul class="navbar-nav ml-auto">
					  <div class="topbar-divider d-none d-sm-block"></div>
					  <?php include_once("../includes/datosuser.php"); ?>
					</ul>
				</nav>
				<!-- End of Topbar -->
      	<!-- Begin Page Content -->
      	<div class="container-fluid">
      		<!-- Page Heading -->
        	<div class="d-sm-flex align-items-center justify-content-between mb-4">
          		<h1 class="h3 mb-0 text-gray-800">Lockers</h1>
          			<?php
          				if($_SESSION['rol_user'] == 0){
          					echo '<a href="crear-locker.php" class="btn btn-primary btn-icon-split">
          									<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Locker</span>
                  				</a>';
          				}
        				?>
        	</div>
        	<!-- Content Table
          <?php // --- LLAMAR WS : DameLockers 
		    		$parametros_DameLockers = array('token'=>$token_ws, 'OrdenAoN'=>'N');
		    		$soap_lockers_result = $SoapClient_KeysConsigna->DameLockers($parametros_DameLockers);
					?> -->
          <?php // ----- LLAMAR WS: DameLocker -------------------------------------
            $parametros_WsDameLocker = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
            $soap_lockers_result = $SoapClient_KeysConsigna->DameLocker($parametros_WsDameLocker);
           // var_dump($soap_lockers_result);

          ?>
					<div class="card shadow mb-4">
						<div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                	<thead>
                   	<tr>
                      <th>Id.</th>
                  		<th>Nombre</th>
                  		<th>Nº Serie</th>
                  		<th>Estado</th>
                  		<th>VPN</th>
                  		<th>Base de datos</th>
                  		<th>Acciones</th>
                    </tr>
                  </thead>
									<tbody>
										<?php
                  		if((array)$soap_lockers_result->DameLockerResult->IdLocker){ // SÓLO 1
                    	// ROLES
                       
                    		if($_SESSION['rol_user'] == 0){
                          /*
                      	$botones = "<a data-toggle='modal' data-target='#editarLoc' data-id_loc='".$soap_lockers_result->DameLockerResult->IdLocker."' class='btn btn-warning btn-xs'>
                            <span class='fa fa-edit'></span> Editar</a>";
                        */
                        $botones = '<a href="actualizar-locker.php?upd='.$soap_lockers_result->DameLockerResult->IdLocker.'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>';

                    		}else{
                      		$botones = "";
                    		}
                    		// Estado de Locker
                    		if($soap_lockers_result->DameLockerResult->Estado == 1){
                      		$estado = "Activo";
                    		}else{
                      		$estado = "Prueba";
                    		}
                    		echo "
                          <tr>
                            <th scope=\"row\" style=\"vertical-align:middle;\">".$soap_lockers_result->DameLockerResult->IdLocker."</th>
                            <td style=\"vertical-align:middle;\">".$soap_lockers_result->DameLockerResult->Nombre."</td>
                            <td style=\"vertical-align:middle;\">".$soap_lockers_result->DameLockerResult->NumeroSerie."</td>
                            <td style=\"vertical-align:middle;\">".$estado."</td>
                            <td style=\"vertical-align:middle;\">".$soap_lockers_result->DameLockerResult->VPN."</td>
                            <td style=\"vertical-align:middle;\">".$soap_lockers_result->DameLockerResult->BD."</td>
                            <td class=\"d-flex justify-content-center\">".$botones."</td>
                          </tr>";
                  		}else{
                       
                    		for ($i = 0; $i < count((array)$soap_lockers_result->DameLockerResult->Locker); $i++){
                    			$lista_loc = (array)$soap_lockers_result->DameLockerResult->Locker;
                          $datos_loc = $lista_loc[$i];
                      		// ROLES
                      		if($_SESSION['rol_user'] == 0){
                        		$botones = '<a href="actualizar-locker.php?upd='.$datos_loc->IdLocker.'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>';
                          }else{
                            $botones = "";
                          }
                      		// Estado de Locker
                      		if($datos_loc->Estado == 1){
                        		$estado = "Activo";
                      		}else{
                        		$estado = "Prueba";
                      		}
                      		echo "
                          <tr>
                            <th scope=\"row\" style=\"vertical-align:middle;\">".$datos_loc->IdLocker."</th>
                            <td style=\"vertical-align:middle;\">".$datos_loc->Nombre."</td>
                            <td style=\"vertical-align:middle;\">".$datos_loc->NumeroSerie."</td>
                            <td style=\"vertical-align:middle;\">".$estado."</td>
                            <td style=\"vertical-align:middle;\">".$datos_loc->VPN."</td>
                            <td style=\"vertical-align:middle;\">".$datos_loc->BD."</td>
                            <td style=\"vertical-align:middle;\">".$botones."</td>
                          </tr>";
                        }
                      }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
					</div>
        </div>
      </div>
    </div>
  </div>
  <!-- /page content -->
  <?php include_once('../includes/scripts_footer.php');?>
  <script>
  	$(function () {
  		$('#dataTable').DataTable({
        responsive: true,
        columnDefs: [{ orderable: false, targets: 2 }, { orderable: false, targets: 3 }, { orderable: false, targets: 4 }, { orderable: false, targets: 5 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
          });
  	});
  </script>
</body>
</html>