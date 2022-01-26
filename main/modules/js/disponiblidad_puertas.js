$('formSearchPuertas').submit(function(e){

    /* e.preventDefault(); */

    $.ajax({
        url: 'disponiblidad_puertas_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
