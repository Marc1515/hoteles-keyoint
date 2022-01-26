const formulario = document.getElementById('formularioUser');
const inputs = document.querySelectorAll('#formularioUser input');

const expresiones = {
	usuario: /^[a-zA-Z0-9\_\-]{4,20}$/, // Letras, numeros, guion y guion_bajo
	nombre: /^[a-zA-ZÀ-ÿ\s]{1,40}$/, // Letras y espacios, pueden llevar acentos.
	password: /^.{4,12}$/, // 4 a 12 digitos.
	correo: /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/,
	telefono: /^\d{7,14}$/ // 7 a 14 numeros.
}

const validarFormulario = (e) => {
    switch (e.target.name) {
        case "nombre":
            if(expresiones.nombre.test(e.target.value)) {
                document.getElementById('grupo__nombre').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('nameUser').classList.remove('input-incorrecto');
                document.getElementById('error__p__nombre').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__nombre').classList.add('formulario__grupo-incorrecto');
                document.getElementById('nameUser').classList.add('input-incorrecto');
                document.getElementById('error__p__nombre').classList.add('error__p-active');
            }
        break;

        case "nombreUsuario":
            if(expresiones.usuario.test(e.target.value)) {
                document.getElementById('grupo__usuario').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('nickName').classList.remove('input-incorrecto');
                document.getElementById('error__p__user').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__usuario').classList.add('formulario__grupo-incorrecto');
                document.getElementById('nickName').classList.add('input-incorrecto');
                document.getElementById('error__p__user').classList.add('error__p-active');
            }
        break;
        
        case "pwd":
            if(expresiones.password.test(e.target.value)) {
                document.getElementById('grupo__pwd').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('pwd').classList.remove('input-incorrecto');
                document.getElementById('error__p__pwd').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__pwd').classList.add('formulario__grupo-incorrecto');
                document.getElementById('pwd').classList.add('input-incorrecto');
                document.getElementById('error__p__pwd').classList.add('error__p-active');
            }
        break;

        case "pwd2":
            if(expresiones.password.test(e.target.value)) {
                document.getElementById('grupo__pwd2').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('pwd2').classList.remove('input-incorrecto');
                document.getElementById('error__p__pwd2').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__pwd2').classList.add('formulario__grupo-incorrecto');
                document.getElementById('pwd2').classList.add('input-incorrecto');
                document.getElementById('error__p__pwd2').classList.add('error__p-active');
            }

            const inputPass1 = document.getElementById('pwd');
            const inputPass2 = document.getElementById('pwd2');
        
            if (inputPass1.value !== inputPass2.value) {
        
                document.getElementById('grupo__pwd2').classList.add('formulario__grupo-incorrecto');
                document.getElementById('pwd2').classList.add('input-incorrecto');
                document.getElementById('error__p__confirm').classList.add('error__p-active');
            } else {
        
                document.getElementById('grupo__pwd2').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('pwd2').classList.remove('input-incorrecto');
                document.getElementById('error__p__confirm').classList.remove('error__p-active');
        
            }
            
        break;
        
        case "example-email":
            if(expresiones.correo.test(e.target.value)) {
                document.getElementById('grupo__email').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('example-email').classList.remove('input-incorrecto');
                document.getElementById('error__p__email').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__email').classList.add('formulario__grupo-incorrecto');
                document.getElementById('example-email').classList.add('input-incorrecto');
                document.getElementById('error__p__email').classList.add('error__p-active');
            }
        break;

        case "movil":
            if(expresiones.telefono.test(e.target.value)) {
                document.getElementById('grupo__phone').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('phone').classList.remove('input-incorrecto');
                document.getElementById('error__p__phone').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__phone').classList.add('formulario__grupo-incorrecto');
                document.getElementById('phone').classList.add('input-incorrecto');
                document.getElementById('error__p__phone').classList.add('error__p-active');
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