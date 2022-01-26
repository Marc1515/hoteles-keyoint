$('formSearchTrazabilidad').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarTrazabilidad_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
