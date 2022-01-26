$('formSearchDisponiblidad').submit(function(e){

    e.preventDefault();

    $.ajax({
        url: 'filtrarDisponiblidad_validate.php',
        type: 'POST',
        data: from.serialize(),

    });

});
