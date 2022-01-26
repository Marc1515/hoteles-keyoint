$(document).ready(function() {
    tablalockers = $('#listTicket_operadores').DataTable({
        responsive: true,
        searching: true,
        dom: 'Blfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            className: 'btn btn-primary mr-1',
            text:'<span class=\"far fa-file-pdf \" title=\"Exportar a PDF\"></span>',
            filename : 'listadoOperadores',
            title: 'Listado de Operadores',
            pageSize: 'A4',
            orientation: 'portrait',
            download: 'open',
            exportOptions: {columns: [0,1,2,3]},
            customize : function(doc) {
                doc.styles.tableHeader.alignment = 'left';
                doc.content[1].table.widths = [ '7%', '33%', '40%', '20%' ];
            }
        },
        {
            extend: 'excelHtml5',
            className: 'btn btn-primary mr-1',
            text:'<span class=\"far fa-file-excel \" title=\"Exportar a Excel\"></span>',
            filename : 'listadoOperadores',
            pageSize: 'A4',
            orientation: 'portrait',
            exportOptions: {columns: [0,1,2,3]},
            }],             
        language: {'url': "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"}
    });
});