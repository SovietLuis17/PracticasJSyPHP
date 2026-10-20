document.addEventListener('DOMContentLoaded', function () {
  /*
  DOMContentLoaded se dispara cuando el HTML ya se cargó y el navegador ya creó todos
   los elementos del DOM, pero antes de esperar imágenes, CSS, etc.
  */
  
   //seleccion de elementos
  const nombre = document.querySelector('#nombre');
  const apellido = document.querySelector('#apellido');
  const correo = document.querySelector('#correo');
  const telefono = document.querySelector('#telefono');
  const formulario = document.querySelector('#formulario');
  const btnEnviar = document.querySelector('#enviar');

  //comprobacion de los elementos
  if (!nombre || !apellido || !correo || !telefono || !formulario || !btnEnviar) {
    console.error('Faltan elementos del formulario');
    return; //detiene la ejecuccion swi falta algo, es una red de seguridad
  }
//crear arreglo con los campos de texto
  const campos = [nombre, apellido, correo, telefono];

  // recorre los campos de texto
  campos.forEach(function (campo) {
    campo.addEventListener('blur', function () { //agrega el evento
      validarCampo(campo, true); //llama a la funcion
      actualizarBoton(); //lamar otra funcion
    }); //finaliza el evento blur

    campo.addEventListener('input', function () { //evento input
      actualizarBoton();

      const referencia = campo.parentElement;
      const tieneAlerta = referencia.querySelector('.bg-red-600');

      if (tieneAlerta) {
        validarCampo(campo, true);
      }
    }); //finaliza el evento input

  }); // finaliza el arreglo

  formulario.addEventListener('submit', function (e) { //evento de formulario
    const resultados = campos.map(function (campo) {
      return validarCampo(campo, true);
    });

    const valido = resultados.every(Boolean);
    actualizarBoton();

    if (!valido) {
      e.preventDefault();
    }
  }); 

  // Estado inicial: el botón empieza bloqueado
  actualizarBoton();

  //funcion validar campos
  function validarCampo(campo, mostrar) {
    const referencia = campo.parentElement;
    const valor = campo.value.trim();
    let mensaje = '';

    if (valor === '') {
      mensaje = `El campo ${campo.id} está vacío`;
    } else if (campo.id === 'correo' && !validarEmail(valor)) {
      mensaje = 'El correo no es válido';
    } else if (campo.id === 'nombre' && !validarNombresApellidos(valor)) {
      mensaje = 'El nombre no es válido';
    } else if (campo.id === 'apellido' && !validarNombresApellidos(valor)) {
      mensaje = 'El apellido no es válido';
    } else if (campo.id === 'telefono' && !validarTelefono(valor)) {
      mensaje = 'El teléfono no es válido';
    }

    if (mostrar) {
      limpiarAlerta(referencia);

      if (mensaje) {
        mostrarAlerta(mensaje, referencia);
      }
    }

    return mensaje === '';
  }

  function formularioValido() {
    return campos.every(function (campo) {
      return validarCampo(campo, false);
    });
  }

  function actualizarBoton() {
    btnEnviar.disabled = !formularioValido();
  }

  function mostrarAlerta(mensaje, referencia) {
    limpiarAlerta(referencia);

    const error = document.createElement('p');
    error.textContent = mensaje;
    error.classList.add('bg-red-600', 'text-white', 'p-2', 'text-center', 'mt-2', 'rounded-lg', 'text-sm');

    referencia.appendChild(error);
  }

  function limpiarAlerta(referencia) {
    const alerta = referencia.querySelector('.bg-red-600');

    if (alerta) {
      alerta.remove();
    }
  }

  function validarEmail(email) {
    const regex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    return regex.test(email);
  }

  function validarNombresApellidos(nombreApellido) {
    const regex = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:\s+[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$/;
    return regex.test(nombreApellido);
  }

  function validarTelefono(telefono) {
    // Permite +, números, espacios, guiones y paréntesis
    const regex = /^[0-9+\s()-]{7,20}$/;
    return regex.test(telefono);
  }
});