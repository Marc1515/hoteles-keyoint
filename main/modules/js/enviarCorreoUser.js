$('#crearUser').click(function(){

    var nombre = document.getElementById('nameUser').value;
    var nickName = document.getElementById('nickName').value;
    var correo = document.getElementById('example-email').value;
    var contra = document.getElementById('pwd').value;
    var Pin = document.getElementById('pin').value;
    var nombreOpe = document.getElementById('operador').value;
    var numOpe = document.getElementById('numOperador').value;


    var ruta = "Nom="+nombre+"&NickName="+nickName+"&Email="+correo+"&pwd="+contra+"&pin="+Pin+"&Ope="+nombreOpe+"&numOperador="+numOpe;

    $.ajax({
        url: 'email_user.php',
        type: 'POST',
        data: ruta

    })
    .done(function(/* res */) {
        console.log("success");
        /* $('#respuesta').html(res); */
    })
    /* .done(function() {
        console.log("error");
    }) */
    .done(function() {
        console.log("complete");
    })


})
