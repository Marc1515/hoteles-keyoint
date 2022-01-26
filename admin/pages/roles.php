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
	              		<h1 class="h3 mb-0 text-gray-800">Roles</h1>
	            	</div>

	            	<!-- Content Table -->
		            <?php 
		            $key_rol = 0;
		            $parametros_dameRoles = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
					$soap_result_DR = $SoapClient_KeysConsigna->DameRoles($parametros_dameRoles);
					
					if((array)$soap_result_DR->DameRolesResult->Rol->IdLocker){ // SÓLO 1
						$lista_roles[$key_rol] = (array)$soap_result_DR->DameRolesResult->Rol;
						$key_rol++;
					}else{
						for ($i = 0; $i < count((array)$soap_result_DR->DameRolesResult->Rol); $i++){
	                       	$lista_roles[$key_rol] = (array)$soap_result_DR->DameRolesResult->Rol[$i];
	                       	$key_rol++;
	      				}
					}
					
		            ?>
		            <div class="card shadow mb-4">
						<div class="card-body">
		                    <div class="table-responsive" style="width: 60%">
		                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
		                        	<thead>
                                        <tr>
                                        	<th>Núm.</th>
                                            <th>Rol</th>
                                            <th>URL</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    	for ($x = 0; $x < count((array)$lista_roles); $x++){
                                    		echo    
                                            '   <tr>
                                                    <td>'.$lista_roles[$x]['IdRol'].'</td>
                                                    <td>'.$lista_roles[$x]['Nombre'].'</td>
                                                    <td>'.$lista_roles[$x]['Url'].'</td>
                                                    <td class="d-flex justify-content-center">';
	                                            if(($lista_roles[$x]['IdRol'] != 1 && $lista_roles[$x]['IdRol'] != 2) || ($_SESSION['id_operador'] == 0 && $_SESSION['id_user'] == 0)){
	                                            	echo '
	                                            		<a href="actualizar-rol.php?upd='.$lista_roles[$x]['IdRol'].'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>
			                                            </td>
			                                        </tr>';
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
	<?php include_once('../includes/scripts_footer.php');?>
 	<script>
    	$(function () {
    		$('#dataTable').DataTable({
                responsive: true,
                searching: false,
                paging: false,
                columnDefs: [{ orderable: true, targets: 0 }, { orderable: true, targets: 1 }, { orderable: false, targets: 2 }, { orderable: false, targets: 3 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
    	});
    </script>
</body>
</html>