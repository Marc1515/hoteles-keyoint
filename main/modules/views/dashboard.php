<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-dashboard.php') ?>


<body class="skin-default-dark fixed-layout">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <?php /* require('preloader.php') */ ?>
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php require('header.php') ?>
        <?php require './../ws/ws_reservas/ws_dameReservasPorOperador_donutHoy.php' ?>
        <?php require './../ws/ws_reservas/ws_dameReservasPorOperador_donutMes.php' ?>
        <?php require './../ws/ws_reservas/ws_dameReservasPorOperador_donutAno.php' ?> 
        <?php require './../ws/ws_reservas/ws_dameReservasPorOperador_donutAnoAnuladas.php' ?> 
        <?php require './../ws/ws_reservas/ws_dameOcupacionEntreFechas_dashboard.php' ?>
        <?php require './../ws/ws_reservas/ws_dameReservasporOperador_grafica.php' ?>
        <?php require './../ws/ws_cupos/ws_damePuertas.php' ?>

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


        ?>

        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php require('left-sidebar.php')?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- =====================COMMIT========================================= -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h4 class="text-themecolor">Datatable</h4>
                    </div>
                    <div class="col-md-7 align-self-center text-right">
                        <div class="d-flex justify-content-end align-items-center">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                                <li class="breadcrumb-item active">Datatable</li>
                            </ol>
                            <button type="button" class="btn btn-info d-none d-lg-block m-l-15"><i
                                    class="fa fa-plus-circle"></i> Create New</button>
                        </div>
                    </div>
                </div> -->
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Start Page Content -->
                <!-- ============================================================== -->

                        <div class="card">
                            <div class="card-body">
                                <div class="row my-5 d-flex justify-content-around">
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-5">
                                        <h3 class="mb-3">Reservas Totales</h3>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card bg-success text-white text-center py-5">
                                                    <div class="zoomDash">
                                                        <h4>Hoy</h4>

                                                        <h1><?php echo $reservasHoy ?></h1>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="card bg-info text-white text-center py-5">
                                                    <div class="zoomDash">
                                                        <h4><?php echo $mes ?></h4>

                                                        <h1><?php echo $reservasMes ?></h1>
                                                    </div>
                                                </div>
                                            </div>                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="card bg-primary text-white text-center py-5">
                                                    <div class="zoomDash">
                                                        <h4><?php $ano = date('Y'); echo $ano ?></h4>

                                                        <h1><?php echo $reservasAno ?></h1>

                                                        <h4>Confirmadas</h4>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="card bg-danger text-white text-center py-5">
                                                    <div class="zoomDash">
                                                        <h4><?php $ano = date('Y'); echo $ano ?></h4>

                                                        <h1><?php echo $reservasAnoAnuladas ?></h1>

                                                        <h4>Anuladas</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-5">

                                    <h3 class="mb-3">Disponiblidad en los dias siguientes</h3>

                                        <div class="table-responsive">
                                            
                                            <table class="table color-table info-table">
                                                
                                                <thead>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Total</th>
                                                        <th>Libres</th>
                                                        <th>Reservadas</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    
                                                    <?php


                                                      if (!is_array($array_dameOcupacionEntreFechas) && !is_null($array_dameOcupacionEntreFechas)) {


                                                        require './../../../../ws_include/ws_Keys_reserva.php';


                                                        // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                        $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$array_dameOcupacionEntreFechas->IdOperador);
                                                        $soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);


                                                        $objeto_dameContrato = $soap_result_DC->DameContratoResult;

                                                        $finalContratoString = $objeto_dameContrato->Hasta;
                                                        $finalContrato = intval($finalContratoString);

                                                        $fechaString = $array_dameOcupacionEntreFechas->Fecha;
                                                        $fecha = intval($fechaString);



                                                        $entradaFrom = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas->Fecha));

                                                        if ($fecha <= $finalContrato) {

                                                          echo '
                                                          
                                                          <tr>
                                                              <td>'.$entradaFrom.'</td>
                                                              <td>'.$array_dameOcupacionEntreFechas->Total.'</td>
                                                              <td>'.$array_dameOcupacionEntreFechas->Libres.'</td>
                                                              <td>'.$array_dameOcupacionEntreFechas->Reservadas.'</td>
                                                          </tr>
                                                          
                                                          
                                                          ';


                                                        }


                                                      } elseif (is_array($array_dameOcupacionEntreFechas)) {

                                                    
                                                        for ($step=0; $step<count($array_dameOcupacionEntreFechas); $step++) {


                                                          require './../../../../ws_include/ws_Keys_reserva.php';


                                                          // --- LLAMAR WS : DameContrato --------------------------------------------------------------------------------------------------------------------------------------------------->
                                                          $parametros_dameContrato = array('token'=>$token_ws, 'IdLocker'=>$idLocker, 'IdOperador'=>$array_dameOcupacionEntreFechas[$step]->IdOperador);
                                                          $soap_result_DC = $SoapClient_KeysReserva->DameContrato($parametros_dameContrato);


                                                          $objeto_dameContrato = $soap_result_DC->DameContratoResult;

                                                          $finalContratoString = $objeto_dameContrato->Hasta;
                                                          $finalContrato = intval($finalContratoString);

                                                          $fechaString = $array_dameOcupacionEntreFechas[$step]->Fecha;
                                                          $fecha = intval($fechaString);



                                                          $entradaFrom = date("d-m-Y", strtotime($array_dameOcupacionEntreFechas[$step]->Fecha));

                                                          if ($fecha <= $finalContrato) {

                                                            echo '
                                                            
                                                            <tr>
                                                                <td>'.$entradaFrom.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas[$step]->Total.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas[$step]->Libres.'</td>
                                                                <td>'.$array_dameOcupacionEntreFechas[$step]->Reservadas.'</td>
                                                            </tr>
                                                            
                                                            
                                                            ';


                                                          }

                                                        }

                                                      } else {



                                                      }
                                                    
                                                    ?>

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>
                                </div>

                                <div class="row my-5 d-flex justify-content-center">
                                    <div class="col-11 my-5">
                                        <h3 class="mb-3">Todas las reservas del <?php echo date("Y"); ?></h3>
                                        <div id="chartdiv4" style="height: 700px;"></div>
                                    </div>
                                </div>

                                <div class="row my-5 d-flex justify-content-center">
                                    <div class="col-11 my-5">
                                        <h3 class="mb-3">Todas las reservas del <?php echo $mes ?></h3>
                                        <canvas id="myAreaChart"></canvas>
                                    </div>
                                </div>

                            </div>
                        </div>
                                               
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <?php require('right-sidebar.php') ?>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <?php require('footer.php');?>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="../../../assets/node_modules/jquery/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="../../../assets/node_modules/popper/popper.min.js"></script>
    <script src="../../../assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../../dist/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="../../dist/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../../dist/js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="../../../assets/node_modules/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../../../assets/node_modules/sparkline/jquery.sparkline.min.js"></script>
    <!--Custom JavaScript -->
    <script src="../../dist/js/custom.min.js"></script>
    <!-- This is data table -->
    <script src="../../../assets/node_modules/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="../../../assets/node_modules/datatables.net-bs4/js/dataTables.responsive.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    
    <script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  /* Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif'; */
  /* Chart.defaults.global.defaultFontColor = '#858796'; */

/*   function number_format(number, decimals, dec_point, thousands_sep) {
    // *     example: number_format(1234.56, 2, ',', ' ');
    // *     return: '1 234,56'
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
      prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
      sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
      dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
      s = '',
      toFixedFix = function(n, prec) {
        var k = Math.pow(10, prec);
        return '' + Math.round(n * k) / k;
      };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  } */

  // Area Chart
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ["<?php echo date('01-m') ?>", "<?php echo date('02-m') ?>", "<?php echo date('03-m') ?>", "<?php echo date('04-m') ?>", "<?php echo date('05-m') ?>", "<?php echo date('06-m') ?>", "<?php echo date('07-m') ?>", "<?php echo date('08-m') ?>", "<?php echo date('09-m') ?>", "<?php echo date('10-m') ?>", "<?php echo date('11-m') ?>", "<?php echo date('12-m') ?>", "<?php echo date('13-m') ?>", "<?php echo date('14-m') ?>", "<?php echo date('15-m') ?>", "<?php echo date('16-m') ?>", "<?php echo date('17-m') ?>", "<?php echo date('18-m') ?>", "<?php echo date('19-m') ?>", "<?php echo date('20-m') ?>", "<?php echo date('21-m') ?>", "<?php echo date('22-m') ?>", "<?php echo date('23-m') ?>", "<?php echo date('24-m') ?>", "<?php echo date('25-m') ?>", "<?php echo date('26-m') ?>", "<?php echo date('27-m') ?>", "<?php echo date('28-m') ?>", "<?php echo date('29-m') ?>", "<?php echo date('30-m') ?>", "<?php echo date('31-m') ?>"],
      datasets: [{
        lineTension: 0.3,
        backgroundColor: "rgb(139, 165, 209)",
        borderColor: "rgb(93, 126, 189)",
        pointRadius: 3,
        pointBackgroundColor: "rgb(93, 126, 189)",
        pointBorderColor: "rgb(93, 126, 189)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgb(93, 126, 189)",
        pointHoverBorderColor: "rgb(93, 126, 189)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [<?php echo $dia01 ?>, <?php echo $dia02 ?>, <?php echo $dia03 ?>, <?php echo $dia04 ?>, <?php echo $dia05 ?>, <?php echo $dia06 ?>, <?php echo $dia07 ?>, <?php echo $dia08 ?>, <?php echo $dia09 ?>, <?php echo $dia10 ?>, <?php echo $dia11 ?>, <?php echo $dia12 ?>, <?php echo $dia13 ?>, <?php echo $dia14 ?>, <?php echo $dia15 ?>, <?php echo $dia16 ?>, <?php echo $dia17 ?>, <?php echo $dia18 ?>, <?php echo $dia19 ?>, <?php echo $dia20 ?>, <?php echo $dia21 ?>, <?php echo $dia22 ?>, <?php echo $dia23 ?>, <?php echo $dia24 ?>, <?php echo $dia25 ?>, <?php echo $dia26 ?>, <?php echo $dia27 ?>, <?php echo $dia28 ?>, <?php echo $dia29 ?>, <?php echo $dia30 ?>, <?php echo $dia31 ?>]
      }/* ,{
        lineTension: 0.3,
        backgroundColor: "rgb(139, 165, 209)",
        borderColor: "rgb(183, 82, 78)",
        pointRadius: 3,
        pointBackgroundColor: "rgb(183, 82, 78)",
        pointBorderColor: "rgb(183, 82, 78)",
        pointHoverRadius: 3,
        pointHoverBackgroundColor: "rgb(183, 82, 78)",
        pointHoverBorderColor: "rgb(183, 82, 78)",
        pointHitRadius: 10,
        pointBorderWidth: 2,
        data: [40, 43, 39, 45, 33, 36, 38, 32, 49, 56, 42, 32, 41, 31, 26, 52, 44, 46, 25, 35, 45, 58, 40, 30, 36, 37, 51, 40, 34, 32, 49, 63, , , , , , , , , , , , , , , , , , , , , , , , , , , , , , , ]
      } */],
    }/* ,
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [{
          time: {
            unit: 'date'
          },
          gridLines: {
            display: false,
            drawBorder: false
          },
          ticks: {
            maxTicksLimit: 7
          }
        }],
        yAxes: [{
          ticks: {
            maxTicksLimit: 5,
            padding: 10,
            callback: function(value, index, values) {
              return number_format(value) + ' €';
            }
          },
          gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
          }
        }],
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: '#6e707e',
        titleFontSize: 14,
        borderColor: '#dddfeb',
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: 'index',
        caretPadding: 10,
        callbacks: {
          label: function(tooltipItem, chart) {
            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
            switch (tooltipItem.datasetIndex){
              case 0:
                txt_valor = number_format(tooltipItem.yLabel) + ' €';
              break;
              case 1:
                if(number_format(tooltipItem.yLabel) == 1){
                  txt_valor = number_format(tooltipItem.yLabel) + ' unidad';
                }else{
                  txt_valor = number_format(tooltipItem.yLabel) + ' unidades';
                }
              break;
            }
            return datasetLabel + txt_valor;
          }
        }
      }
    } */
  });

  




</script>
    <script src="./../js/filtro_reservas.js"></script>


    <!-- end - This is for export functionality only -->
    <script>
        $(function () {
           /*  $('#myTable').DataTable();
            var table = $('#example').DataTable({
                "columnDefs": [{
                    "visible": false,
                    "targets": 2
                }],
                "order": [
                    [2, 'asc']
                ],
                "displayLength": 25,
                "drawCallback": function (settings) {
                    var api = this.api();
                    var rows = api.rows({
                        page: 'current'
                    }).nodes();
                    var last = null;
                    api.column(2, {
                        page: 'current'
                    }).data().each(function (group, i) {
                        if (last !== group) {
                            $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                            last = group;
                        }
                    });
                }
            }); */
            // Order by the grouping
            $('#example tbody').on('click', 'tr.group', function () {
                var currentOrder = table.order()[0];
                if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                    table.order([2, 'desc']).draw();
                } else {
                    table.order([2, 'asc']).draw();
                }
            });

            $('#config-table').DataTable({
                responsive: true,
				"columns": [{ "searchable": false },{ "searchable": true },{ "searchable": true },{ "searchable": false },{ "searchable": false },{ "searchable": false },{ "searchable": true },{ "searchable": false }],
				language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
            });
        });
        $('#example23').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
        $('.buttons-copy, .buttons-csv, .buttons-print, .buttons-pdf, .buttons-excel').addClass('btn btn-primary mr-1');
    </script>


<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/moonrisekingdom.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/kelly.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv", am4charts.PieChart);

// Add data
chart.data = [ {
  "country": "Hoy",
  "litres": <?php echo $reservasHoy ?>
}, {
  "country": "<?php echo $ano ?>",
  "litres": <?php echo $reservasMes ?>
}, {
  "country": "<?php $ano = date('Y'); echo $ano ?>",
  "litres": <?php echo $reservasAno ?>
} ];

// Set inner radius
chart.innerRadius = am4core.percent(50);

// Add and configure Series
var pieSeries = chart.series.push(new am4charts.PieSeries());
pieSeries.dataFields.value = "litres";
pieSeries.dataFields.category = "country";
pieSeries.slices.template.stroke = am4core.color("#fff");
pieSeries.slices.template.strokeWidth = 2;
pieSeries.slices.template.strokeOpacity = 1;

// This creates initial animation
pieSeries.hiddenState.properties.opacity = 1;
pieSeries.hiddenState.properties.endAngle = -90;
pieSeries.hiddenState.properties.startAngle = -90;

}); // end am4core.ready()
</script>

<!-- Chart code -->
<script>
    am4core.ready(function() {

    // Themes begin
    am4core.useTheme(am4themes_animated);
    // Themes end

    // Create chart instance
    var chart = am4core.create("chartdiv2", am4charts.XYChart);

    // Add data
    chart.data = [{
    "country": "Enero",
    "visits": <?php echo $enero ?>
    }, {
    "country": "Febrero",
    "visits": <?php echo $febrero ?>
    }, {
    "country": "Marzo",
    "visits": <?php echo $marzo ?>
    }, {
    "country": "Abril",
    "visits": <?php echo $abril ?>
    }, {
    "country": "Mayo",
    "visits": <?php echo $mayo ?>
    }, {
    "country": "Junio",
    "visits": <?php echo $junio ?>
    }, {
    "country": "Julio",
    "visits": <?php echo $julio ?>
    }, {
    "country": "Agosto",
    "visits": <?php echo $agosto ?>
    }, {
    "country": "Septiembre",
    "visits": <?php echo $septiembre ?>
    }, {
    "country": "Octubre",
    "visits": <?php echo $octubre ?>
    }, {
    "country": "Noviembre",
    "visits": <?php echo $noviembre ?>
    }, {
    "country": "Diciembre",
    "visits": <?php echo $diciembre ?>
    }];


    // Create axes

    var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
    categoryAxis.dataFields.category = "country";
    categoryAxis.renderer.grid.template.location = 0;
    categoryAxis.renderer.minGridDistance = 30;

    categoryAxis.renderer.labels.template.adapter.add("dy", function(dy, target) {
    if (target.dataItem && target.dataItem.index & 2 == 2) {
        return dy + 25;
    }
    return dy;
    });

    var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

    // Create series
    var series = chart.series.push(new am4charts.ColumnSeries());
    series.dataFields.valueY = "visits";
    series.dataFields.categoryX = "country";
    series.name = "Visits";
    series.columns.template.tooltipText = "{categoryX}: [bold]{valueY}[/]";
    series.columns.template.fillOpacity = .8;

    var columnTemplate = series.columns.template;
    columnTemplate.strokeWidth = 2;
    columnTemplate.strokeOpacity = 1;

    }); // end am4core.ready()
</script>


<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_kelly);
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv4", am4charts.XYChart3D);

// Add data
chart.data = [
  {
    country: "Enero",
    visits: <?php echo $enero ?>
  },
  {
    country: "Febrero",
    visits: <?php echo $febrero ?>
  },
  {
    country: "Marzo",
    visits: <?php echo $marzo ?>
  },
  {
    country: "Abril",
    visits: <?php echo $abril ?>
  },
  {
    country: "Mayo",
    visits: <?php echo $mayo ?>
  },
  {
    country: "Junio",
    visits: <?php echo $junio ?>
  },
  {
    country: "Julio",
    visits: <?php echo $julio ?>
  },
  {
    country: "Agosto",
    visits: <?php echo $agosto ?>
  },
  {
    country: "Septiembre",
    visits: <?php echo $septiembre ?>
  },
  {
    country: "Octubre",
    visits: <?php echo $octubre ?>
  },
  {
    country: "Noviembre",
    visits: <?php echo $noviembre ?>
  },
  {
    country: "Diciembre",
    visits: <?php echo $diciembre ?>
  }
];

// Create axes
let categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
categoryAxis.dataFields.category = "country";
categoryAxis.renderer.labels.template.rotation = 270;
categoryAxis.renderer.labels.template.hideOversized = false;
categoryAxis.renderer.minGridDistance = 20;
categoryAxis.renderer.labels.template.horizontalCenter = "right";
categoryAxis.renderer.labels.template.verticalCenter = "middle";
categoryAxis.tooltip.label.rotation = 270;
categoryAxis.tooltip.label.horizontalCenter = "right";
categoryAxis.tooltip.label.verticalCenter = "middle";

let valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
valueAxis.title.text = "Reservas";
valueAxis.title.fontWeight = "bold";

// Create series
var series = chart.series.push(new am4charts.ColumnSeries3D());
series.dataFields.valueY = "visits";
series.dataFields.categoryX = "country";
series.name = "Visits";
series.tooltipText = "{categoryX}: [bold]{valueY}[/]";
series.columns.template.fillOpacity = .8;

var columnTemplate = series.columns.template;
columnTemplate.strokeWidth = 2;
columnTemplate.strokeOpacity = 1;
columnTemplate.stroke = am4core.color("#FFFFFF");

columnTemplate.adapter.add("fill", function(fill, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

columnTemplate.adapter.add("stroke", function(stroke, target) {
  return chart.colors.getIndex(target.dataItem.index);
})

chart.cursor = new am4charts.XYCursor();
chart.cursor.lineX.strokeOpacity = 0;
chart.cursor.lineY.strokeOpacity = 0;

}); // end am4core.ready()
</script>
   
<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

// Create chart instance
var chart = am4core.create("chartdiv3", am4charts.XYChart);

// Add data
chart.data = [{
  "date": "<?php echo date('Y-m-01') ?>",
  "value": <?php echo $dia01 ?>
}, {
  "date": "<?php echo date('Y-m-02') ?>",
  "value": <?php echo $dia02 ?>
}, {
  "date": "<?php echo date('Y-m-03') ?>",
  "value": <?php echo $dia03 ?>
}, {
  "date": "<?php echo date('Y-m-04') ?>",
  "value": <?php echo $dia04 ?>
}, {
  "date": "<?php echo date('Y-m-05') ?>",
  "value": <?php echo $dia05 ?>
}, {
  "date": "<?php echo date('Y-m-06') ?>",
  "value": <?php echo $dia06 ?>
}, {
  "date": "<?php echo date('Y-m-07') ?>",
  "value": <?php echo $dia07 ?>
}, {
  "date": "<?php echo date('Y-m-08') ?>",
  "value": <?php echo $dia08 ?>
}, {
  "date": "<?php echo date('Y-m-09') ?>",
  "value": <?php echo $dia09 ?>
}, {
  "date": "<?php echo date('Y-m-10') ?>",
  "value": <?php echo $dia10 ?>
}, {
  "date": "<?php echo date('Y-m-11') ?>",
  "value": <?php echo $dia11 ?>
}, {
  "date": "<?php echo date('Y-m-12') ?>",
  "value": <?php echo $dia12 ?>
}, {
  "date": "<?php echo date('Y-m-13') ?>",
  "value": <?php echo $dia13 ?>
}, {
  "date": "<?php echo date('Y-m-14') ?>",
  "value": <?php echo $dia14 ?>
}, {
  "date": "<?php echo date('Y-m-15') ?>",
  "value": <?php echo $dia15 ?>
}, {
  "date": "<?php echo date('Y-m-16') ?>",
  "value": <?php echo $dia16 ?>
}, {
  "date": "<?php echo date('Y-m-17') ?>",
  "value": <?php echo $dia17 ?>
}, {
  "date": "<?php echo date('Y-m-18') ?>",
  "value": <?php echo $dia18 ?>
}, {
  "date": "<?php echo date('Y-m-19') ?>",
  "value": <?php echo $dia19 ?>
}, {
  "date": "<?php echo date('Y-m-20') ?>",
  "value": <?php echo $dia20 ?>
}, {
  "date": "<?php echo date('Y-m-21') ?>",
  "value": <?php echo $dia21 ?>
}, {
  "date": "<?php echo date('Y-m-22') ?>",
  "value": <?php echo $dia22 ?>
}, {
  "date": "<?php echo date('Y-m-23') ?>",
  "value": <?php echo $dia23 ?>
}, {
  "date": "<?php echo date('Y-m-24') ?>",
  "value": <?php echo $dia24 ?>
}, {
  "date": "<?php echo date('Y-m-25') ?>",
  "value": <?php echo $dia25 ?>
}, {
  "date": "<?php echo date('Y-m-26') ?>",
  "value": <?php echo $dia26 ?>
}, {
  "date": "<?php echo date('Y-m-27') ?>",
  "value": <?php echo $dia27 ?>
}, {
  "date": "<?php echo date('Y-m-28') ?>",
  "value": <?php echo $dia28 ?>
}, {
  "date": "<?php echo date('Y-m-29') ?>",
  "value": <?php echo $dia29 ?>
}, {
  "date": "<?php echo date('Y-m-30') ?>",
  "value": <?php echo $dia30 ?>
}, {
  "date": "<?php echo date('Y-m-31') ?>",
  "value": <?php echo $dia31 ?>
}];

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0;
dateAxis.renderer.minGridDistance = 50;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series
var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.valueY = "value";
series.dataFields.dateX = "date";
series.strokeWidth = 3;
series.fillOpacity = 0.5;

// Add vertical scrollbar
/* chart.scrollbarY = new am4core.Scrollbar();
chart.scrollbarY.marginLeft = 0; */

// Add cursor
chart.cursor = new am4charts.XYCursor();
chart.cursor.behavior = "zoomY";
chart.cursor.lineX.disabled = true;

}); // end am4core.ready()
</script>

<!-- Chart code -->
<script>
am4core.ready(function() {

// Themes begin
am4core.useTheme(am4themes_animated);
// Themes end

var chart = am4core.create("chartdiv5", am4charts.XYChart);
chart.paddingRight = 20;

var data = [{
  "date": "<?php echo date('Y-m-01') ?>",
  "value": <?php echo $dia01 ?>
}, {
  "date": "<?php echo date('Y-m-02') ?>",
  "value": <?php echo $dia02 ?>
}, {
  "date": "<?php echo date('Y-m-03') ?>",
  "value": <?php echo $dia03 ?>
}, {
  "date": "<?php echo date('Y-m-04') ?>",
  "value": <?php echo $dia04 ?>
}, {
  "date": "<?php echo date('Y-m-05') ?>",
  "value": <?php echo $dia05 ?>
}, {
  "date": "<?php echo date('Y-m-06') ?>",
  "value": <?php echo $dia06 ?>
}, {
  "date": "<?php echo date('Y-m-07') ?>",
  "value": <?php echo $dia07 ?>
}, {
  "date": "<?php echo date('Y-m-08') ?>",
  "value": <?php echo $dia08 ?>
}, {
  "date": "<?php echo date('Y-m-09') ?>",
  "value": <?php echo $dia09 ?>
}, {
  "date": "<?php echo date('Y-m-10') ?>",
  "value": <?php echo $dia10 ?>
}, {
  "date": "<?php echo date('Y-m-11') ?>",
  "value": <?php echo $dia11 ?>
}, {
  "date": "<?php echo date('Y-m-12') ?>",
  "value": <?php echo $dia12 ?>
}, {
  "date": "<?php echo date('Y-m-13') ?>",
  "value": <?php echo $dia13 ?>
}, {
  "date": "<?php echo date('Y-m-14') ?>",
  "value": <?php echo $dia14 ?>
}, {
  "date": "<?php echo date('Y-m-15') ?>",
  "value": <?php echo $dia15 ?>
}, {
  "date": "<?php echo date('Y-m-16') ?>",
  "value": <?php echo $dia16 ?>
}, {
  "date": "<?php echo date('Y-m-17') ?>",
  "value": <?php echo $dia17 ?>
}, {
  "date": "<?php echo date('Y-m-18') ?>",
  "value": <?php echo $dia18 ?>
}, {
  "date": "<?php echo date('Y-m-19') ?>",
  "value": <?php echo $dia19 ?>
}, {
  "date": "<?php echo date('Y-m-20') ?>",
  "value": <?php echo $dia20 ?>
}, {
  "date": "<?php echo date('Y-m-21') ?>",
  "value": <?php echo $dia21 ?>
}, {
  "date": "<?php echo date('Y-m-22') ?>",
  "value": <?php echo $dia22 ?>
}, {
  "date": "<?php echo date('Y-m-23') ?>",
  "value": <?php echo $dia23 ?>
}, {
  "date": "<?php echo date('Y-m-24') ?>",
  "value": <?php echo $dia24 ?>
}, {
  "date": "<?php echo date('Y-m-25') ?>",
  "value": <?php echo $dia25 ?>
}, {
  "date": "<?php echo date('Y-m-26') ?>",
  "value": <?php echo $dia26 ?>
}, {
  "date": "<?php echo date('Y-m-27') ?>",
  "value": <?php echo $dia27 ?>
}, {
  "date": "<?php echo date('Y-m-28') ?>",
  "value": <?php echo $dia28 ?>
}, {
  "date": "<?php echo date('Y-m-29') ?>",
  "value": <?php echo $dia29 ?>
}, {
  "date": "<?php echo date('Y-m-30') ?>",
  "value": <?php echo $dia30 ?>
}, {
  "date": "<?php echo date('Y-m-31') ?>",
  "value": <?php echo $dia31 ?>
}];
/* var visits = 10;
for (var i = 1; i < 50000; i++) {
  visits += Math.round((Math.random() < 0.5 ? 1 : -1) * Math.random() * 10);
  data.push({ date: new Date(2018, 0, i), value: visits });
} */

chart.data = data;

var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.renderer.grid.template.location = 0;
dateAxis.minZoomCount = 5;


// this makes the data to be grouped
dateAxis.groupData = true;
dateAxis.groupCount = 500;

var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

var series = chart.series.push(new am4charts.LineSeries());
series.dataFields.dateX = "date";
series.dataFields.valueY = "value";
series.tooltipText = "{valueY}";
series.tooltip.pointerOrientation = "vertical";
series.tooltip.background.fillOpacity = 0.5;

chart.cursor = new am4charts.XYCursor();
chart.cursor.xAxis = dateAxis;

var scrollbarX = new am4core.Scrollbar();
scrollbarX.marginBottom = 20;
chart.scrollbarX = scrollbarX;

}); // end am4core.ready()
</script>








</body>

</html>