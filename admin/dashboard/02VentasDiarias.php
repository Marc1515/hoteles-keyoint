<?php
  $buscar_hasta = date("d-m-Y", mktime(0, 0, 0, date("m"), date("d"),   date("Y")));
  $faunmes = date("d-m-Y", mktime(0, 0, 0, date("m")-1, date("d"),   date("Y")));
  $txt_dias = '';
  $txt_importe = '';
  $txt_unidades = '';

  include_once('../ws_include/ws_gestion.php');

  // --- LLAMAR WS : DameDetalleVentasDiarias ------------------------------------------------------------------------------------------------------------------>
  $soap_ventasdia = array('token'=>$token_ws, 'IdLocker'=>$_SESSION['IdLocker'], 'desde'=> $faunmes,'hasta'=>$buscar_hasta);
  $soap_ventasdia_result = $SoapClient_Gestion->__soapCall('DameDetalleVentasDiarias', array($soap_ventasdia));

  if((array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->IdLocker){ // SÓLO 1
    $fecha = new DateTime($soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Fecha);
    $fecha_graf = date("d-m",strtotime($soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Fecha));
    $txt_dias .= '"'.$fecha_graf.'"';
    $txt_importe .= $soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Importe;
    $txt_unidades .= $soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Unidades;

  }else{
    for ($i = 0; $i < count((array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta); $i++){
      $lista_ventas = (array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta;
      $datos_venta = $lista_ventas[$i];
      $fecha = new DateTime($datos_venta->Fecha);
      $fecha_graf = date("d-m",strtotime($datos_venta->Fecha));
      $txt_dias .= '"'.$fecha_graf.'"';
      $txt_importe .= $datos_venta->Importe;
      $txt_unidades .= $datos_venta->Unidades;
      if($i+1 < count((array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta)){
        $txt_dias .= ', ';
        $txt_importe .= ', ';
        $txt_unidades .= ', ';
      }
      
    }
    
  }




  if((array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->IdLocker){ // SÓLO 1
    $fecha = new DateTime($soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Fecha);
    $txt_fecha = date("m",strtotime($soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Fecha."- 1 month"));
    $txt_graficaVentaDia .= '{x: new Date('.$fecha->format('Y').', '.$txt_fecha.', '.$fecha->format('d').'), y: '.$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Importe.'}';
    //$txt_unidades .= '{x: new Date('.$fecha->format('Y').', '.$txt_fecha.', '.$fecha->format('d').'), y: '.$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Unidades.'}';
    $ventamedia = $soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta->Importe;
  }else{
    for ($i = 0; $i < count((array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta); $i++){
      if($i != 0){
        $txt_graficaVentaDia .= ', ';
        $txt_unidades .= ', ';
      }
      $lista_ventas = (array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta;
          $datos_venta = $lista_ventas[$i];
          $fecha = new DateTime($datos_venta->Fecha);
          $fecha_unmes = date("d-m-Y",strtotime($datos_venta->Fecha."- 1 month"));
          $fecha_txtunmes = new DateTime($fecha_unmes);
          $txt_graficaVentaDia .= '
          {x: new Date('.$fecha_txtunmes->format('Y').', '.$fecha_txtunmes->format('m').', '.$fecha_txtunmes->format('d').'), y: '.$datos_venta->Importe.'}';
          //$txt_unidades .= '{x: new Date('.$fecha_txtunmes->format('Y').', '.$fecha_txtunmes->format('m').', '.$fecha_txtunmes->format('d').'), y: '.$datos_venta->Unidades.'}';
          $ventamedia = $ventamedia + $datos_venta->Importe;
      }
      $txt_ventamedia = $ventamedia / count((array)$soap_ventasdia_result->DameDetalleVentasDiariasResult->LineaDetalleVenta);
  }
?>
<!-- Area Chart -->
<div class="col-xl-12 col-lg-10">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div
            class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Ventas por día (último mes)</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <div class="chart-area">
                <canvas id="myAreaChart"></canvas>
            </div>
        </div>
    </div>
</div>
<script src="../includes/js/chart.js/Chart.min.js"></script>
<script>
  // Set new default font family and font color to mimic Bootstrap's default styling
  Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
  Chart.defaults.global.defaultFontColor = '#858796';

  function number_format(number, decimals, dec_point, thousands_sep) {
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
  }

  // Area Chart
  var ctx = document.getElementById("myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: [<?php echo $txt_dias;?>],
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
        data: [<?php echo $txt_importe;?>]
      },{
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
        data: [<?php echo $txt_unidades;?>]
      }],
    },
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
    }
  });

  




</script>










<script>
/*function VentasDiarias02(){
	var chart02 = new CanvasJS.Chart("chartContainer02", {
		animationEnabled: true,  
		axisY: {
			title: "Euros",
			stripLines: [{
				value: <?php echo $txt_ventamedia;?>,
				label: "Media por día"
			}]
		},
		axisX:{      
            valueFormatString: "DD-MMM" 
        },
		data: [{
			yValueFormatString: "#.## €",
			xValueFormatString: "DD-MM-YY",
			type: "area",
			dataPoints: [<?php echo $txt_graficaVentaDia; ?>]},
		{
			yValueFormatString: "# unidades",
			xValueFormatString: "DD-MM-YY",
			type: "spline",
			dataPoints: [<?php echo $txt_unidades; ?>]}
		]
	});*/
	//chart02.render();
//}
</script>