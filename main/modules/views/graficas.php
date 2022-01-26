<!DOCTYPE html>
<html lang="en">

<!-- HEAD -->
<?php require('../heads/head-graficas.php') ?>


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
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php require('left-sidebar.php')?>
        <?php require('../ws/ws_reservas/ws_dameReservasporOperador_grafica.php') ?>
        <?php require('../ws/ws_users/ws_dameUsuarios.php') ?>

        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
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
                <div class="row pt-3">
                    <div class="col-12">
                        <!-- table responsive -->
                        <div class="card">
                            <div class="card-body">

                                <a href="./reservas.php"><i style="font-size: 1.5rem" class="fas fa-arrow-circle-left"></i></a>

                                <div class="row">
                                    <div class="col-9">
                                        <h1 class="text-center">Estadísticas de Reservas por mes</h1>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <form action="" method="POST" class="row" id="filtrarGrafica">
                                                <div class="col-8">
                                                    <select class="custom-select" id="inlineFormCustomSelect" name="filtro" data-toggle="tooltip" data-placement="top" title="Elige un año">

                                                        <?php require './../ws/ws_reservas/ws_dameEjerciciosConReservas.php'; 
                                                        

                                                            for($step=0; $step<count($array_dameEjerciciosConReservas); $step++) {

                                                                echo '
                                                                <option value="'.$array_dameEjerciciosConReservas[$step].'">'.$array_dameEjerciciosConReservas[$step].'</option>

                                                                ';
                                                            
                                                            }
                                                        
                                                        ?>

                                                    </select>
                                                </div>

                                                <div class="col-4">
                                                    <button type="submit" data-toggle="tooltip" data-placement="top" title="Buscar" class="btn btn-info btn-circle"><i class="fas fa-search" style="font-size: 1.25rem"></i> </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                

                                <div id="chartdiv"></div>

                                    <!-- Resources -->
                                <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
                                <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
                                <script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>

                                <!-- Chart code -->
                                <script>
                                    am4core.ready(function() {

                                    // Themes begin
                                    am4core.useTheme(am4themes_animated);
                                    // Themes end

                                    // Create chart instance
                                    var chart = am4core.create("chartdiv", am4charts.XYChart);

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
        <?php require('footer.php') ?>
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
    <script src="./../js/filtro_reservas.js"></script>

    <!-- AMCHARTS -->
    <script src="https://cdn.amcharts.com/lib/4/core.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/themes/material.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/lang/de_DE.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/geodata/germanyLow.js"></script>
    <script src="https://cdn.amcharts.com/lib/4/fonts/notosans-sc.js"></script>

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
    <script src="./../js/lista-reservas.js"></script>
    
</body>

</html>