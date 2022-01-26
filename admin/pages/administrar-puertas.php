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
include_once('../../../ws_include/ws_Keys_reserva.php');

// OPERADORES
$parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'A');
$soap_result_DO = $SoapClient_KeysConsigna->DameOperadores($parametros_dameOperadores);

$x = 0;
if((array)$soap_result_DO->DameOperadoresResult->Operador->IdLocker){ // SÓLO 1
	if($soap_result_DO->DameOperadoresResult->Operador->IdOperador != 0){ // ES KEYPOINT
		$listado_operadores[0] = $soap_result_DO->DameOperadoresResult->Operador;
	}
}else{

	for ($i = 0; $i < count((array)$soap_result_DO->DameOperadoresResult->Operador); $i++){

		// existeContrato
		$parametros_existeContrato = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'IdOperador'=>$soap_result_DO->DameOperadoresResult->Operador[$i]->IdOperador);
		$soap_result_EC = $SoapClient_KeysReserva->ExisteContrato($parametros_existeContrato);

		if ($soap_result_EC->ExisteContratoResult === true) {

			$lista_operadores = (array)$soap_result_DO->DameOperadoresResult->Operador;
			$datos_operadores = $lista_operadores[$i];

			if($datos_operadores->IdOperador != 0){ // ES KEYPOINT
				$listado_operadores[$x] = $datos_operadores;
				$x++;
			}
		}
	}
}
// PUERTAS
$soap_puertas = array('token'=>$token_ws, 'idLocker'=>$_SESSION['IdLocker'], 'OrdenAoN'=>'N');
$soap_puertas_result = $SoapClient_KeysConsigna->DamePuertas($soap_puertas);

if((array)$soap_puertas_result->DamePuertasResult->Puerta->IdLocker){ // SÓLO 1
	$cuantas_puertas = 1;
	$soap_puertas_result->DamePuertasResult->Puerta[0] = $soap_puertas_result->DamePuertasResult->Puerta;
}else{
	$cuantas_puertas = count((array)$soap_puertas_result->DamePuertasResult->Puerta);
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
    <link href="../includes/multiselect/css/multi-select.css" media="screen" rel="stylesheet" type="text/css">
    <style>
    	table tr td {cursor: pointer; flex-basis: 20%;  box-sizing: border-box;
  border: solid;}
    	table tr {display: flex; justify-content: space-between;}
			.libre {color: black;}
			.ocupada {color: white;}
			.vacia {cursor: default; border: none !important}
		</style>
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
	      		<h1 class="h3 mb-0 text-gray-800">Administrar Puertas</h1>
	    	</div>

	    	<!-- Content Table -->
	    	<div class="card shadow mb-4">
					<div class="card-body">
						<form id="form_puertas" name="form_puertas" action="administrar_puertas_validate.php" method="post">
							<div class="row">
								<select class="custom-select col-4" id="select_operadores" name="select_operadores" onchange="status_puertas()" onclick="confirma()">
									<option value="NONE" disabled="disabled" selected="selected">Escoger un Operador...</option>
									<?php
										for ($i = 0; $i < count((array)$listado_operadores); $i++){
											if ($listado_operadores[$i]->IdOperador !== 0) {
												if($_GET['op'] == $listado_operadores[$i]->IdOperador){
													$seleccionado = ' selected';
												}else{
													$seleccionado = '';
												}
												echo '<option value="'.$listado_operadores[$i]->IdOperador.'"'.$seleccionado.'>'.$listado_operadores[$i]->Nombre.'</option>';
											}
										}
									?>
								</select>
							</div>
							<div class="row" style="margin-top:15px;">
								<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
									<?php
										$z = 0;
										if($cuantas_puertas > 5){
											$cuantas_filas_total = ceil($cuantas_puertas / 5);
											$columnas = 5;
										}else{
											$columnas = $cuantas_puertas;
											$cuantas_filas_total = 1;
										}
										for ($fila = 0; $fila < $cuantas_filas_total; $fila++){
											echo '<tr>';
											for ($x = 0; $x < $columnas; $x++){
												if($z < $cuantas_puertas){
													// DATOS PUERTA
													$nombre_puerta = $soap_puertas_result->DamePuertasResult->Puerta[$z]->Nombre;
													echo '<td id="cell_'.$soap_puertas_result->DamePuertasResult->Puerta[$z]->IdPuerta.'" name="cell_'.$soap_puertas_result->DamePuertasResult->Puerta[$z]->IdPuerta.'" onclick="select('.$soap_puertas_result->DamePuertasResult->Puerta[$z]->IdPuerta.')">
																</td>';
													$z++;
												}else{
													if($z < $columnas*$cuantas_filas_total){
														for($x = $z; $x < ($columnas*$cuantas_filas_total); $x++){
															echo "<td class='vacia'></td>";
														}
													}
													break;
												}
											}
											echo '</tr>';
										}
									?>
								</table>
							</div>
							<div class="row">
								<div id="boton_guardar" class="col-12" style="text-align: right; margin-top: 5px; display: none;">
									<button type="button" class="btn btn-success btn-icon-split" onclick="enviar_form(true);">
	                    <span class="icon text-white-50">
	                        <i class="fas fa-check"></i>
	                    </span>
	                    <span class="text">Guardar</span>
	                </button>
	              </div>
	            	<div id="boton_loading" class="col-12" style="text-align: right; margin-top: 5px; display: none;">
	                <button class="btn btn-primary" type="button" disabled>
										<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
											Guardando...
										</button>
	              </div>
							</div>
						</form>
					</div>
				</div>
				<!-- Modal -->
	      <div class="modal fade" id="cambios_op" name="cambios_op" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Guardar cambios?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  Desea guardar los cambios realizados?
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="enviar_form(true)">Sí</button>
                <button type="button" class="btn btn-danger text-white" onclick="enviar_form(false)">No</button>
              </div>
            </div>
          </div>
	      </div>
	      <!-- Modal -->
	      <div class="modal fade" id="err_opera" name="err_opera" tabindex="-1" aria-labelledby="errorOperadoresLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Error!</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						No ha seleccionado ningún operador!<br>Seleccione uno para poder administrar sus puertas
					</div>
					<div class="modal-footer">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<button type="button" class="btn btn-danger text-white" data-dismiss="modal" aria-label="Close">Cerrar</button>
					</div>
				</div>
			</div>
	      </div>
	      <!-- Modal -->
	      <div class="modal fade" id="err_puertaConReserva" name="err_puertaConReserva" tabindex="-1" aria-labelledby="errorOperadoresLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Error!</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						Esta Puerta contiene Reservas Vigentes!
					</div>
					<div class="modal-footer">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<button type="button" class="btn btn-danger text-white" data-dismiss="modal" aria-label="Close">Cerrar</button>
					</div>
				</div>
			</div>
	      </div>
	      <!-- Modal -->
	      <div class="modal fade" id="err_maximoPuertasPermitidasPorContrato" name="err_maximoPuertasPermitidasPorContrato" tabindex="-1" aria-labelledby="errorOperadoresLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Error!</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						No se puede superar el limite de puertas del contrato!
					</div>
					<div class="modal-footer">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<button type="button" class="btn btn-danger text-white" data-dismiss="modal" aria-label="Close">Cerrar</button>
					</div>
				</div>
			</div>
	      </div>
			</div>
		</div>
	</div>
</div>
<?php include_once('../includes/scripts_footer.php');?>
<script src="./../includes/script_adminpuertas.js"></script>
</body>
</html>