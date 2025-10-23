const boton = document.getElementById('boton');
const nombre = document.getElementById('nombre');
const apellido = document.getElementById('apellido');
const email = document.getElementById('email');

boton.hidden = true;

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

function comprobarCampos() {
  const nombreValido = nombre.value.trim() !== "";
  const apellidoValido = apellido.value.trim() !== "";
  const emailValido = emailRegex.test(email.value.trim()); 

  if (nombreValido && apellidoValido && emailValido) {
    boton.hidden = false;   
  } else {
    boton.hidden = true;    
  }
}

nombre.addEventListener('input', comprobarCampos);
apellido.addEventListener('input', comprobarCampos);
email.addEventListener('input', comprobarCampos);