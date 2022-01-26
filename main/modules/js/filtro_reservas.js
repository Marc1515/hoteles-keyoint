$('formSearchReserves').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarReservas_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
