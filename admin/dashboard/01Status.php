<?php
	include_once('../../ws_include/ws_gestion.php');

	// --- LLAMAR WS : ContarEstadosPuertas ------------------------------------------------------------------------------------------------------------------>
	$soap_status = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker']);
	$soap_status_result = $SoapClient_Gestion->__soapCall('ContarEstadosPuertas', array($soap_status));
?>
<div style="width: 188%">
	<h2>Estado Actual del Locker</h2>
</div>
<!-- TARJETAS ESTADO ACTUAL -->
<div class="col-xl-2 col-md-4 mb-2">
    <div class="card shadow h-100 py-2" style="border-left: .25rem solid green!important">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: green !important">Libres</div>
                    <div class="h5 mb-0 font-weight-bold text-green-800" style="color: green !important"><?php echo $soap_status_result->ContarEstadosPuertasResult->Libres;?></div>
                </div>
                <div class="col-auto">
                    <i class="fas fa-check fa-2x text-green-300" style="color: green !important"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-2 col-md-4 mb-2">
    <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid blue!important">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"style="color: blue !important">Ocupadas</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"style="color: blue !important"><?php echo $soap_status_result->ContarEstadosPuertasResult->Ocupadas;?></div>
                </div>
                <div class="col-auto">
                    <i class="far fa-thumbs-up fa-2x text-gray-300" style="color: blue !important"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// TCH NO TIENE SUCIAS. CONTENIDO ESTÁTICO QUE HAY QUE PASAR A DINÁMICO
if($_SESSION['IdLocker'] != 21051){
	echo '	<div class="col-xl-2 col-md-4 mb-2">
			    <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid red!important">
			        <div class="card-body">
			            <div class="row no-gutters align-items-center">
			                <div class="col mr-2">
			                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"style="color: red !important">Sucias</div>
			                    <div class="h5 mb-0 font-weight-bold text-gray-800"style="color: red !important">'.$soap_status_result->ContarEstadosPuertasResult->Sucias.'</div>
			                </div>
			                <div class="col-auto">
			                    <i class="fa fa-soap fa-2x text-gray-300" style="color: red !important"></i>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>';
}
?>

<div class="col-xl-2 col-md-4 mb-2">
    <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid black!important">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"style="color: black !important">Caducadas</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"style="color: black !important"><?php echo $soap_status_result->ContarEstadosPuertasResult->Caducadas;?></div>
                </div>
                <div class="col-auto">
                    <i class="far fa-calendar-times fa-2x text-gray-300" style="color: black !important"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xl-2 col-md-4 mb-2">
    <div class="card border-left-primary shadow h-100 py-2" style="border-left: .25rem solid #cccc00!important">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"style="color: #cccc00 !important">Deshabilitada</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"style="color: #cccc00 !important"><?php echo $soap_status_result->ContarEstadosPuertasResult->Bloqueadas;?></div>
                </div>
                <div class="col-auto">
                    <i class="fa fa-tools fa-2x text-gray-300" style="color: #cccc00 !important"></i>
                </div>
            </div>
        </div>
    </div>
</div>