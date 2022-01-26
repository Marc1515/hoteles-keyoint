$(document).ready(function() {
    tablalockers = $('#listTicket_trazabilidadPorFechas').DataTable({
        responsive: true,
        searching: true,
        dom: 'Blfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary mr-1',
            text:'<span class=\"far fa-file-pdf \" title=\"Exportar a PDF\"></span>',
            filename : 'trazabilidadPorFechas',
            title: 'Trazabilidad por Fechas',
            pageSize: 'A4',
            orientation: 'landscape',
            download: 'open',
            exportOptions: {columns: [0,1,2,3,4,5]},
            customize : function(doc) {
                doc.styles.tableHeader.alignment = 'left';
                doc.content[1].table.widths = [ '20%', '10%', '15%', '20%', '25%', '10%' ];
            }
        },
        {
            extend: 'excelHtml5',
            className: 'btn btn-primary mr-1',
            text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
            filename : 'trazabilidadPorFechas',
            pageSize: 'A4',
            orientation: 'portrait',
            exportOptions: {columns: [0,1,2,3,4,5]},
            }],             
        language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
    });
});