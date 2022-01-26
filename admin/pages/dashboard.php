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

require './../../../ws_include/ws_dameEstadisticasEntreFechas_delAno.php';


require './../../../ws_include/ws_dameEstadisticasEntreFechas_delMes.php';


require './../../../ws_include/ws_dameEstadisticasEntreFechas_deHoy.php';
?>

<?php
        
        
        $mes = date('F');

        if ($mes === 'January') {

            $mes = 'Enero';

        } elseif ($mes === 'February') {

            $mes = 'Febrero';

        } elseif ($mes === 'March') {

            $mes = 'Marzo';

        } elseif ($mes === 'April') {

            $mes = 'Abril';

        } elseif ($mes === 'May') {

            $mes = 'Mayo';

        } elseif ($mes === 'June') {

            $mes = 'Junio';

        } elseif ($mes === 'July') {

            $mes = 'Julio';

        } elseif ($mes === 'August') {

            $mes = 'Agosto';

        } elseif ($mes === 'September') {

            $mes = 'Septiembre';

        } elseif ($mes === 'October') {

            $mes = 'Octubre';

        } elseif ($mes === 'November') {

            $mes = 'Noviembre';

        } elseif ($mes === 'December') {

            $mes = 'Diciembre';

        }


        require './../../../ws_include/ws2.php';
        require './../../../ws_include/ws_Keys_reserva.php';
    
        $idLocker = $_SESSION['IdLocker'];
    
        // --- LLAMAR WS : DameOperadores --------------------------------------------------------------------------------------------------------------------------------------------------->
        $parametros_dameOperadores = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'OrdenAoN'=>'A');
        $soap_result_DO = $client->DameOperadores($parametros_dameOperadores);
    
        $objeto_dameOperadores = $soap_result_DO->DameOperadoresResult->Operador;

        /* var_dump($_SESSION); */


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
      <?php include_once("./../includes/menu.php"); ?>
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
              <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            </div>

            
            <!-- Content Row -->
            <div class="row d-flex justify-content-between">

              <div class="col-3">
                <h4 class="text-center">Reservas del <?php echo date('Y') ?></h4>
                <canvas id="myChart" width="200" height="200"></canvas>
              </div>
              <div class="col-3">
                <h4 class="text-center">Reservas del <?php echo $mes ?></h4>
                <canvas id="myChart2" width="200" height="200"></canvas>
              </div>
              <div class="col-3">
                <h4 class="text-center">Reservas de Hoy</h4>
                <canvas id="myChart3" width="200" height="200"></canvas>
              </div>

            </div>

            <div class="row mt-5">
              <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Puertas Asignadas en Contratos</h6>
              </div>
            </div>
            <div class="row">
              <div class="col-8">
                <div class="card-body">

                  <?php

                    if (!is_array($objeto_dameOperadores) && !is_null($objeto_dameOperadores)) {

                      if ($objeto_dameOperadores->IdOperador !== 0 && $objeto_dameOperadores->IdOperador !== 111) {


                        // --- LLAMAR WS : DameLineaContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
                        $parametros_dameLineaContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameOperadores->IdOperador);
                        $soap_result_DLC = $SoapClient_KeysReserva->DameLineaContrato($parametros_dameLineaContrato);
                    
                        $objeto_dameLineaContrato = $soap_result_DLC->DameLineaContratoResult;


                          if ($objeto_dameOperadores->IdOperador === $objeto_dameLineaContrato->IdOperador) {

                            $cupo = $objeto_dameLineaContrato->Cupo;
                            $asignadas = $objeto_dameLineaContrato->Asignadas;
                            
                          }

                        
                        $porcentage = round($asignadas/$cupo*100);

                        echo '

                        <h4 class="small font-weight-bold">'.$objeto_dameOperadores[$step]->Nombre.' <span class="float-right">'.$porcentage.'%</span></h4>
                        <div class="progress mb-4">

                          <div class="progress-bar bg-primary" role="progressbar" style="width: '.$porcentage.'%">'.$asignadas.' / '.$cupo.'</div>

                        </div>';

                      }

                    } elseif (is_array($objeto_dameOperadores)) {

                      for ($step=0; $step<count($objeto_dameOperadores); $step++) {

                        if ($objeto_dameOperadores[$step]->IdOperador !== 0 && $objeto_dameOperadores[$step]->IdOperador !== 111) {


                          // --- LLAMAR WS : DameLineaContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
                          $parametros_dameLineaContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$objeto_dameOperadores[$step]->IdOperador);
                          $soap_result_DLC = $SoapClient_KeysReserva->DameLineaContrato($parametros_dameLineaContrato);
                      
                          $objeto_dameLineaContrato = $soap_result_DLC->DameLineaContratoResult;


                            if ($objeto_dameOperadores[$step]->IdOperador === $objeto_dameLineaContrato->IdOperador) {

                              $cupo = $objeto_dameLineaContrato->Cupo;
                              $asignadas = $objeto_dameLineaContrato->Asignadas;
                              
                            }

                          
                          $porcentage = round($asignadas/$cupo*100);

                          echo '

                          <h4 class="small font-weight-bold">'.$objeto_dameOperadores[$step]->Nombre.' <span class="float-right">'.$porcentage.'%</span></h4>
                          <div class="progress mb-4">

                            <div class="progress-bar bg-primary" role="progressbar" style="width: '.$porcentage.'%">'.$asignadas.' / '.$cupo.'</div>

                          </div>';

                        }

                      }

                    } else {

                      echo 'hola';

                    }

                  ?>

                </div>
              </div>
            </div>
            
          </div>
        </div>
      </div>

    <!-- /page content -->
    <?php include_once('../includes/scripts_footer.php');?>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>

      var ctx = document.getElementById('myChart').getContext("2d");

      var myChart = new Chart (ctx, {

        type:"doughnut",
        data:{
          labels: <?php echo $todosLosOperadoresDelAno ?>,
          datasets:[{
            label:'Num datos',
            data:<?php echo $todasDelAno ?>,
            backgroundColor: <?php echo $coloresDelAno ?>
          }]
        },
        
        options: {

          plugins: {
            
            legend: {

              display: false

            }
          
          }
        
        }


      });

    </script>


    <script>

      var ctx = document.getElementById('myChart2').getContext("2d");
      console.log(ctx);

      var myChart = new Chart (ctx, {

        type:"doughnut",
        data:{
          labels: <?php echo $todosLosOperadoresDelMes ?>,
          datasets:[{
            label:'Num datos',
            data:<?php echo $todasDelMes ?>,
            backgroundColor: <?php echo $coloresDelMes ?>
          }]
        },

        options: {

          plugins: {
            
            legend: {

              display: false

            }

          }

        }


      });

    </script>

    <script>

      var ctx = document.getElementById('myChart3').getContext("2d");

      console.log(ctx);

      var sinReservas = '1';

      var myChart = new Chart (ctx, {

        type:"doughnut",
        data:{
          labels: <?php echo $todosLosOperadoresDeHoy; ?>,
          datasets:[{
            label:'Num datos',
            data:<?php echo $todasDeHoy; ?>,
            backgroundColor: <?php echo $coloresDeHoy ?>
          }]
        },

        options: {

          plugins: {
            
            legend: {

              display: false

            }

          }

        }


      });

    </script>

  </body>
</html>