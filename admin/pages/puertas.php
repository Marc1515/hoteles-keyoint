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

$parametros_DamePuertas = array('token'=>$token_ws, 'idLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'N');
$soap_puertas_result = $SoapClient_KeysConsigna->DamePuertas($parametros_DamePuertas);

$y = 0;
if((array)$soap_puertas_result->DamePuertasResult->Puerta->IdLocker){ // SÓLO 1
  // Activa
  if($soap_puertas_result->DamePuertasResult->Puerta->Activa === TRUE){
    $activa = "Sí";
  }else{
    $activa = "No";
  }
  // Tipo Puerta
  $parametros_DameTipoPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdTipoPuerta'=>$soap_puertas_result->DamePuertasResult->Puerta->IdTipoPuerta);
  $soap_tipopuerta_result = $SoapClient_KeysConsigna->DameTipoPuerta($parametros_DameTipoPuerta);
  // Controlador
  $parametros_DameControlador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdControlador'=>$soap_puertas_result->DamePuertasResult->Puerta->IdControlador);
  $soap_controlador_result = $SoapClient_KeysConsigna->DameControlador($parametros_DameControlador);
  // Orientación
  switch ($soap_puertas_result->DamePuertasResult->Puerta->Posicion) {
    case 'L':
      $orientacion = '<span class="fa fa-arrow-left"></span> Izquierda';
      break;
    case 'U':
      $orientacion = '<span class="fa fa-arrow-up"></span> Arriba';
      break;
    case 'D':
      $orientacion = '<span class="fa fa-arrow-down"></span> Abajo';
      break;
    case 'R':
      $orientacion = '<span class="fa fa-arrow-right"></span> Derecha';
      break;
  }

  $tabla_puerta[$y]['NombreLocker'] = $_SESSION['NombreLocker'];
  $tabla_puerta[$y]['IdLocker'] = $soap_puertas_result->DamePuertasResult->Puerta->IdLocker;
  $tabla_puerta[$y]['IdPuerta'] = $soap_puertas_result->DamePuertasResult->Puerta->IdPuerta;
  $tabla_puerta[$y]['Nombre'] = $soap_puertas_result->DamePuertasResult->Puerta->Nombre;
  $tabla_puerta[$y]['PuertoCU'] = $soap_puertas_result->DamePuertasResult->Puerta->PuertoCU;
  $tabla_puerta[$y]['Activa'] = $activa;
  $tabla_puerta[$y]['TipoPuerta'] = $soap_tipopuerta_result->DameTipoPuertaResult->Nombre;
  $tabla_puerta[$y]['Controlador'] = $soap_controlador_result->DameControladorResult->Nombre;
  $tabla_puerta[$y]['Posicion'] = $orientacion;
  $y++;
}else{
   for ($x = 0; $x < count((array)$soap_puertas_result->DamePuertasResult->Puerta); $x++){
    // Activa
    if($soap_puertas_result->DamePuertasResult->Puerta[$x]->Activa === True){
      $activa = "Sí";
    }else{
      $activa = "No";
    }
    // Tipo Puerta
    $parametros_DameTipoPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdTipoPuerta'=>$soap_puertas_result->DamePuertasResult->Puerta[$x]->IdTipoPuerta);
    $soap_tipopuerta_result = $SoapClient_KeysConsigna->DameTipoPuerta($parametros_DameTipoPuerta);
    // Controlador
    $parametros_DameControlador = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdControlador'=>$soap_puertas_result->DamePuertasResult->Puerta[$x]->IdControlador);
    $soap_controlador_result = $SoapClient_KeysConsigna->DameControlador($parametros_DameControlador);
    // Orientación
    switch ($soap_puertas_result->DamePuertasResult->Puerta[$x]->Posicion) {
      case 'L':
        $orientacion = '<span class="fa fa-arrow-left"></span> Izquierda';
        break;
      case 'U':
        $orientacion = '<span class="fa fa-arrow-up"></span> Arriba';
        break;
      case 'D':
        $orientacion = '<span class="fa fa-arrow-down"></span> Abajo';
        break;
      case 'R':
        $orientacion = '<span class="fa fa-arrow-right"></span> Derecha';
        break;
    }

    $tabla_puerta[$y]['NombreLocker'] = $_SESSION['NombreLocker'];
    $tabla_puerta[$y]['IdLocker'] = $soap_puertas_result->DamePuertasResult->Puerta[$x]->IdLocker;
    $tabla_puerta[$y]['IdPuerta'] = $soap_puertas_result->DamePuertasResult->Puerta[$x]->IdPuerta;
    $tabla_puerta[$y]['Nombre'] = $soap_puertas_result->DamePuertasResult->Puerta[$x]->Nombre;
    $tabla_puerta[$y]['PuertoCU'] = $soap_puertas_result->DamePuertasResult->Puerta[$x]->PuertoCU;
    $tabla_puerta[$y]['Activa'] = $activa;
    $tabla_puerta[$y]['TipoPuerta'] = $soap_tipopuerta_result->DameTipoPuertaResult->Nombre;
    $tabla_puerta[$y]['Controlador'] = $soap_controlador_result->DameControladorResult->Nombre;
    $tabla_puerta[$y]['Posicion'] = $orientacion;
    $y++;
  }
}
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
          		<h1 class="h3 mb-0 text-gray-800">Puertas</h1>
          			<?php
          				if($_SESSION['rol_user'] == 0){
          					echo '<a href="crear-puerta.php" class="btn btn-primary btn-icon-split">
          									<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Puerta</span>
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
                  		<th>Id Puerta</th>
                  		<th>Nombre</th>
                  		<th>Puerto CU</th>
                  		<th>Activa</th>
                  		<th>Tipo Puerta</th>
                      <th>Controlador</th>
                      <th>Posición</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
									<tbody>
										<?php
                    for ($i = 0; $i< count($tabla_puerta); $i++){
                      // ROLES
                      if($_SESSION['rol_user'] == 0){
                        $botones = '<a href="actualizar-puerta.php?upd='.$tabla_puerta[$i]['IdPuerta'].'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#borrarPuerta'.$tabla_puerta[$i]['IdPuerta'].'" data-id_res="'.$tabla_puerta[$i]['IdPuerta'].'" data-nombre="'.$tabla_puerta[$i]['Nombre'].'" title="Eliminar"><i class="fas fa-times"></i></button>

                          <!-- Modal -->
                          <div class="modal fade" id="borrarPuerta'.$tabla_puerta[$i]['IdPuerta'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Borrar Puerta</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          Borrar la puerta '.$tabla_puerta[$i]['Nombre'].'?
                                      </div>
                                      <div class="modal-footer">
                                          <form action="eliminar_puerta_validate.php" method="POST">
                                              <input type="hidden" id="del_idpuerta" name="del_idpuerta" value="'.$tabla_puerta[$i]['IdPuerta'].'">
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                              <button type="submit" class="btn btn-danger text-white" data-id_res="'.$tabla_puerta[$i]['Nombre'].'" data-nombre="'.$tabla_puerta[$i]['Nombre'].'">Confirmar</button>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                          </div>';
                      }else{
                        $botones = "";
                      }
                      echo "
                        <tr>
                          <th scope=\"row\" style=\"vertical-align:middle;\">".$tabla_puerta[$i]['IdPuerta']."</th>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Nombre']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['PuertoCU']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Activa']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['TipoPuerta']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Controlador']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Posicion']."</td>
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
        columnDefs: [{ orderable: false, targets: 1 },{ orderable: false, targets: 2 },{ orderable: false, targets: 3 },{ orderable: false, targets: 4 },{ orderable: false, targets: 5 },{ orderable: false, targets: 6 },{ orderable: false, targets: 7 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
          });
  	});
  </script>
</body>
</html>