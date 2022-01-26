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

$parametros_DameControladores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'N');
$soap_controladores_result = $SoapClient_KeysConsigna->DameControladores($parametros_DameControladores);
//var_dump($soap_controladores_result);

$y = 0;

if((array)$soap_controladores_result->DameControladoresResult->Controlador->IdLocker){ // SÓLO 1
  
    $tabla_contr[$y]['NombreLocker'] = $_SESSION['NombreLocker']; //$datos_loc->Nombre;
    $tabla_contr[$y]['IdLocker'] = $soap_controladores_result->DameControladoresResult->Controlador->IdLocker;
    $tabla_contr[$y]['IdControlador'] = $soap_controladores_result->DameControladoresResult->Controlador->IdControlador;
    $tabla_contr[$y]['Nombre'] = $soap_controladores_result->DameControladoresResult->Controlador->Nombre;
    $tabla_contr[$y]['IP'] = $soap_controladores_result->DameControladoresResult->Controlador->IP;
    $tabla_contr[$y]['Puerto'] = $soap_controladores_result->DameControladoresResult->Controlador->Puerto;
    $tabla_contr[$y]['esPuertoSerie'] = $soap_controladores_result->DameControladoresResult->Controlador->esPuertoSerie;
    $y++;
}else{
   for ($x = 0; $x < count((array)$soap_controladores_result->DameControladoresResult->Controlador); $x++){
        $tabla_contr[$y] = (array)$soap_controladores_result->DameControladoresResult->Controlador[$x];
        $tabla_contr[$y]['NombreLocker'] = $_SESSION['NombreLocker']; // $datos_loc->Nombre;
        $y++;
      }
}
/*
// LOCKERS
$parametros_DameLockers = array('token'=>$token_ws, 'OrdenAoN'=>'N');
$soap_lockers_result = $SoapClient_KeysConsigna->DameLockers($parametros_DameLockers);

if((array)$soap_lockers_result->DameLockersResult->Locker->IdLocker){ // SÓLO 1
  // --- LLAMAR WS : DameControladores 
  $parametros_DameControladores = array('token'=>$token_ws, 'IdLocker'=> $soap_lockers_result->DameLockersResult->Locker->IdLocker, 'OrdenAoN'=>'N');
  $soap_controladores_result = $SoapClient_KeysConsigna->DameControladores($parametros_DameControladores);

  $tabla_contr[0] = (array)$soap_controladores_result->DameControladoresResult->Controlador;
  $tabla_contr[0]['NombreLocker'] = $soap_lockers_result->DameLockersResult->Locker->Nombre;
}else{
  $y = 0;
  for ($i = 0; $i < count((array)$soap_lockers_result->DameLockersResult->Locker); $i++){
    $lista_loc = (array)$soap_lockers_result->DameLockersResult->Locker;
    $datos_loc = $lista_loc[$i];

    // --- LLAMAR WS : DameControladores 
    $parametros_DameControladores = array('token'=>$token_ws, 'IdLocker'=> $datos_loc->IdLocker, 'OrdenAoN'=>'N');
    $soap_controladores_result = $SoapClient_KeysConsigna->DameControladores($parametros_DameControladores);

    if((array)$soap_controladores_result->DameControladoresResult->Controlador->IdLocker){ // SÓLO 1
      $tabla_contr[$y] = (array)$soap_controladores_result->DameControladoresResult->Controlador;
      $tabla_contr[$y]['NombreLocker'] = $datos_loc->Nombre;
      $y++;
    }else{
      for ($x = 0; $x < count((array)$soap_controladores_result->DameControladoresResult->Controlador); $x++){
        $tabla_contr[$y] = (array)$soap_controladores_result->DameControladoresResult->Controlador;
        $tabla_contr[$y]['NombreLocker'] = $datos_loc->Nombre;
        $y++;
      }
    }
  }
}
*/
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
          		<h1 class="h3 mb-0 text-gray-800">Controladores</h1>
          			<?php
          				if($_SESSION['rol_user'] == 0){
          					echo '<a href="crear-controlador.php" class="btn btn-primary btn-icon-split">
          									<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Controlador</span>
                  				</a>';
          				}
        				?>
        	</div>
        	<!-- Content Table -->
          <?php 
					?>
					<div class="card shadow mb-4">
						<div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                	<thead>
                   	<tr>
                  		<th>Id Controlador</th>
                  		<th>Nombre</th>
                  		<th>IP</th>
                  		<th>Puerto</th>
                  		<th>Puerto Serie</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
									<tbody>
										<?php
                    for ($i = 0; $i< count($tabla_contr); $i++){
                      // ROLES
                      if($_SESSION['rol_user'] == 0){
                        $botones = '<a href="actualizar-controlador.php?upd='.$tabla_contr[$i]['IdControlador'].'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#borrarContr'.$tabla_contr[$i]['IdControlador'].'" data-id_res="'.$tabla_contr[$i]['IdControlador'].'" data-nombre="'.$tabla_contr[$i]['Nombre'].'" title="Eliminar"><i class="fas fa-times"></i></button>

                          <!-- Modal -->
                          <div class="modal fade" id="borrarContr'.$tabla_contr[$i]['IdControlador'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Borrar Controlador</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          Borrar el controlador '.$tabla_contr[$i]['Nombre'].'?
                                      </div>
                                      <div class="modal-footer">
                                          <form action="eliminar_controlador_validate.php" method="POST">
                                              <input type="hidden" id="del_id_contr" name="del_id_contr" value="'.$tabla_contr[$i]['IdControlador'].'">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                              <button type="submit" class="btn btn-danger text-white" data-id_res="'.$tabla_contr[$i]['Nombre'].'" data-nombre="'.$tabla_contr[$i]['Nombre'].'">Confirmar</button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                      }else{
                        $botones = "";
                      }
                      // Puerto serie
                      if($tabla_contr[$i]['esPuertoSerie'] == 1){
                        $esserie = "Sí";
                      }else{
                        $esserie = "No";
                      }
                      echo "
                        <tr>
                          <td style=\"vertical-align:middle;\">".$tabla_contr[$i]['IdControlador']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_contr[$i]['Nombre']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_contr[$i]['IP']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_contr[$i]['Puerto']."</td>
                          <td style=\"vertical-align:middle;\">".$esserie."</td>
                          <td class=\"d-flex justify-content-center\">".$botones."</td>
                        </tr>";
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
        columnDefs: [{ orderable: false, targets: 1 }, { orderable: false, targets: 2 },{ orderable: false, targets: 3 }, { orderable: false, targets: 4 }, { orderable: false, targets: 5 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
          });
  	});
  </script>
</body>
</html>