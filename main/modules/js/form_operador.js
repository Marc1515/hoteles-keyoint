const formulario = document.getElementById('formularioOperator');
const inputs = document.querySelectorAll('#formularioOperator input');

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
                document.getElementById('nombre').classList.remove('input-incorrecto');
                document.getElementById('error__p__nombre').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__nombre').classList.add('formulario__grupo-incorrecto');
                document.getElementById('nombre').classList.add('input-incorrecto');
                document.getElementById('error__p__nombre').classList.add('error__p-active');
            }
        break;
        
        case "email":
            if(expresiones.correo.test(e.target.value)) {
                document.getElementById('grupo__email').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('email').classList.remove('input-incorrecto');
                document.getElementById('error__p__email').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__email').classList.add('formulario__grupo-incorrecto');
                document.getElementById('email').classList.add('input-incorrecto');
                document.getElementById('error__p__email').classList.add('error__p-active');
            }
        break;

        case "movil":
            if(expresiones.telefono.test(e.target.value)) {
                document.getElementById('grupo__phone').classList.remove('formulario__grupo-incorrecto');
                document.getElementById('movil').classList.remove('input-incorrecto');
                document.getElementById('error__p__phone').classList.remove('error__p-active');
            } else {
                document.getElementById('grupo__phone').classList.add('formulario__grupo-incorrecto');
                document.getElementById('movil').classList.add('input-incorrecto');
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