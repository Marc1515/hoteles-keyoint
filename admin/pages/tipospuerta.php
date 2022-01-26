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

$parametros_DameTiposPuerta = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'N');
$soap_tipospuertas_result = $SoapClient_KeysConsigna->DameTiposPuerta($parametros_DameTiposPuerta);

$y = 0;
if((array)$soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->IdLocker){ // SÓLO 1
  $tabla_puerta[$y]['IdTipoPuerta'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->IdTipoPuerta;
  $tabla_puerta[$y]['Nombre'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->Nombre;
  $tabla_puerta[$y]['Siglas'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->Siglas;
  $tabla_puerta[$y]['EsControl'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->EsControl;
  $tabla_puerta[$y]['EsCargador'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->EsCargador;
  $tabla_puerta[$y]['Ancho'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->Ancho;
  $tabla_puerta[$y]['Alto'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->Alto;
  $tabla_puerta[$y]['Profundo'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta->Profundo;
  $y++;
}else{
  for ($x = 0; $x < count((array)$soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta); $x++){

    $tabla_puerta[$y]['IdTipoPuerta'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->IdTipoPuerta;
    $tabla_puerta[$y]['Nombre'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->Nombre;
    $tabla_puerta[$y]['Siglas'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->Siglas;
    $tabla_puerta[$y]['EsControl'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->EsControl;
    $tabla_puerta[$y]['EsCargador'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->EsCargador;
    $tabla_puerta[$y]['Ancho'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->Ancho;
    $tabla_puerta[$y]['Alto'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->Alto;
    $tabla_puerta[$y]['Profundo'] = $soap_tipospuertas_result->DameTiposPuertaResult->TipoPuerta[$x]->Profundo;
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
          		<h1 class="h3 mb-0 text-gray-800">Tipos de Puertas</h1>
          			<?php
          				if($_SESSION['rol_user'] == 0){
          					echo '<a href="crear-tipopuerta.php" class="btn btn-primary btn-icon-split">
          									<span class="icon text-white-50"><i class="fas fa-plus-square"></i></span><span class="text">Crear Tipo de Puerta</span>
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
                  		<th>Id.</th>
                  		<th>Nombre</th>
                  		<th>Siglas</th>
                  		<th>Control</th>
                  		<th>Cargador</th>
                      <th>Tamaño (anch.-alt.-prof) (mm)</th>
                      <th>Acciones</th>
                    </tr>
                  </thead>
									<tbody>
										<?php
                    for ($i = 0; $i< count($tabla_puerta); $i++){
                      // ROLES
                      if($_SESSION['rol_user'] == 0){
                        $botones = '<a href="actualizar-tipopuerta.php?upd='.$tabla_puerta[$i]['IdTipoPuerta'].'"><button class="btn btn-info btn-circle btn-sm" title="Editar" style="margin-right: 5px;"><i class="fas fa-pen-square"></i></button></a>
                          <!-- Button trigger modal -->
                          <button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="modal" data-target="#borrarTipoPuerta'.$tabla_puerta[$i]['IdTipoPuerta'].'" data-id_res="'.$tabla_puerta[$i]['IdTipoPuerta'].'" data-nombre="'.$tabla_puerta[$i]['Nombre'].'" title="Eliminar"><i class="fas fa-times"></i></button>

                          <!-- Modal -->
                          <div class="modal fade" id="borrarTipoPuerta'.$tabla_puerta[$i]['IdTipoPuerta'].'" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Borrar el Tipo de Puerta</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                          </button>
                                      </div>
                                      <div class="modal-body">
                                          Borrar el Tipo de puerta '.$tabla_puerta[$i]['Nombre'].'?
                                      </div>
                                      <div class="modal-footer">
                                          <form action="eliminar_tipopuerta_validate.php" method="POST">
                                              <input type="hidden" id="del_idtipopuerta" name="del_idtipopuerta" value="'.$tabla_puerta[$i]['IdTipoPuerta'].'">
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
                      // CONTROL
                      if($tabla_puerta[$i]['EsControl'] == TRUE){
                        $escontrol = "Sí";
                      }else{
                        $escontrol = "No";
                      }
                      // CARGADOR
                      if($tabla_puerta[$i]['EsCargador'] == TRUE){
                        $escargador = "Sí";
                      }else{
                        $escargador = "No";
                      }
                      echo "
                        <tr>
                          <th scope=\"row\" style=\"vertical-align:middle;\">".$tabla_puerta[$i]['IdTipoPuerta']."</th>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Nombre']."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Siglas']."</td>
                          <td style=\"vertical-align:middle;\">".$escontrol."</td>
                          <td style=\"vertical-align:middle;\">".$escargador."</td>
                          <td style=\"vertical-align:middle;\">".$tabla_puerta[$i]['Ancho']." x ".$tabla_puerta[$i]['Alto']." x ".$tabla_puerta[$i]['Profundo']."</td>
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
        columnDefs: [{ orderable: false, targets: 1 },{ orderable: false, targets: 2 },{ orderable: false, targets: 3 },{ orderable: false, targets: 4 },{ orderable: false, targets: 5 },{ orderable: false, targets: 6 }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
          });
  	});
  </script>
</body>
</html>