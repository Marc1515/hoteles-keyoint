$('formSearchTrazabilidadPorFecha').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarTrazabilidadPorFechas_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
