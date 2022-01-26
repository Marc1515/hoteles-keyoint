$('filtrarGrafica').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarReservasPorAno_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
