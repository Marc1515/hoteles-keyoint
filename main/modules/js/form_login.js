const formulario = document.getElementById('loginform');
const inputs = document.querySelectorAll('#loginform input');

const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,20}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/ // 7 a 14 numeros.
}

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "user":
            if(expresiones.usuario.test(e.target.value)) {
                document.getElementById('grupo__usuario').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('user').classList.remove('input-incorrecto');
                document.getElementById('error__p__user').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__usuario').classList.add('formulario__grupo-incorrecto');
                document.getElementById('user').classList.add('input-incorrecto');
                document.getElementById('error__p__user').classList.add('error__p-active');
            }

        break;
        
        case "pass":
            if(expresiones.password.test(e.target.value)) {
                document.getElementById('grupo__pwd').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('pass').classList.remove('input-incorrecto');
                document.getElementById('error__p__pwd').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__pwd').classList.add('formulario__grupo-incorrecto');
                document.getElementById('pass').classList.add('input-incorrecto');
                document.getElementById('error__p__pwd').classList.add('error__p-active');
            }

        break;

    }
}

inputs.forEach((input) => {

    input.addEventListener('keyup', validarFormulario);
    input.addEventListener('blur', validarFormulario);

})

formulario.addEventListener('submit', (e) => {
    /* e.preventDefault(); */
})