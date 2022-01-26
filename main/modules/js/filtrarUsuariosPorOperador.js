$('formSearchTrazabilidad').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarUsuariosPorOperador_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
