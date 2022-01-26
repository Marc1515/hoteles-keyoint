$('formSearchEstadosActuales').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarEstadosActuales_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
