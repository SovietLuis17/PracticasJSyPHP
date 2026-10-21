document.addEventListener('DOMContentLoaded', function () {
  const nombre     = document.querySelector('#nombre');
  const apellido   = document.querySelector('#apellido');
  const correo     = document.querySelector('#correo');
  const telefono   = document.querySelector('#telefono');
  const formulario = document.querySelector('#formulario');
  const btnEnviar  = document.querySelector('#enviar');
  const contenedorMensaje = document.querySelector('#mensaje-servidor');

  if (!nombre || !apellido || !correo || !telefono || !formulario || !btnEnviar) {
    console.error('Faltan elementos del formulario');
    return;
  }

  const campos = [nombre, apellido, correo, telefono];

  campos.forEach(function (campo) {
    campo.addEventListener('blur', function () {
      validarCampo(campo, true);
      actualizarBoton();
    });

    campo.addEventListener('input', function () {
      actualizarBoton();
      const referencia = campo.parentElement;
      if (referencia.querySelector('.bg-red-600')) {
        validarCampo(campo, true);
      }
    });
  });

  // ─────────── SUBMIT CON FETCH ───────────
  formulario.addEventListener('submit', async function (e) {
    e.preventDefault(); // No dejar que el navegador navegue

    // 1) Validación del lado cliente
    const valido = campos
      .map(function (campo) { return validarCampo(campo, true); })
      .every(Boolean);

    actualizarBoton();

    if (!valido) return;

    // 2) Estado de carga en el botón
    const textoOriginal = btnEnviar.textContent;
    btnEnviar.disabled = true;
    btnEnviar.textContent = 'Enviando...';
    limpiarMensajeServidor();

    try {
      // 3) Enviar con Fetch
      const formData = new FormData(formulario);

      const respuesta = await fetch('enviar.php', {
        method: 'POST',
        body: formData
        // No pongas Content-Type manual: FormData lo pone solo
        // ("multipart/form-data; boundary=...")
      });

      const data = await respuesta.json();

      // 4) Manejar la respuesta del servidor
      if (data.success) {
        mostrarMensajeServidor('exito', data.mensaje);
        formulario.reset(); // Limpia los campos
      } else {
        // Errores por campo (422)
        if (data.errores) {
          Object.entries(data.errores).forEach(function ([campoId, mensaje]) {
            const input = document.querySelector('#' + campoId);
            if (input) {
              mostrarAlerta(mensaje, input.parentElement);
            }
          });
        }
        mostrarMensajeServidor('error', data.mensaje || 'Error en el servidor');
      }
    } catch (error) {
      // 5) Error de red o JSON inválido
      console.error(error);
      mostrarMensajeServidor('error', 'No se pudo conectar con el servidor.');
    } finally {
      // 6) Restaurar el botón
      btnEnviar.textContent = textoOriginal;
      actualizarBoton(); // Vuelve a bloquearlo porque los campos están vacíos (si hubo reset)
    }
  });

  // ─────── Resto de funciones (iguales) ───────
  actualizarBoton();

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
      if (mensaje) mostrarAlerta(mensaje, referencia);
    }
    return mensaje === '';
  }

  function formularioValido() {
    return campos.every(function (campo) { return validarCampo(campo, false); });
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
    if (alerta) alerta.remove();
  }

  function validarEmail(email) {
    const regex = /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
    return regex.test(email);
  }

  function validarNombresApellidos(v) {
    const regex = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+(?:\s+[A-Za-zÁÉÍÓÚÜÑáéíóúüñ]+)*$/;
    return regex.test(v);
  }

  function validarTelefono(t) {
    const regex = /^[0-9+\s()-]{7,20}$/;
    return regex.test(t);
  }

  // ─────── Mensajes globales del servidor ───────
  function mostrarMensajeServidor(tipo, mensaje) {
    if (!contenedorMensaje) return;

    limpiarMensajeServidor();

    const p = document.createElement('p');
    p.textContent = mensaje;
    p.classList.add('text-center', 'p-3', 'mb-4', 'rounded-lg', 'font-semibold');

    if (tipo === 'exito') {
      p.classList.add('bg-green-600', 'text-white');
    } else {
      p.classList.add('bg-red-600', 'text-white');
    }

    contenedorMensaje.appendChild(p);
  }

  function limpiarMensajeServidor() {
    if (contenedorMensaje) {
      contenedorMensaje.innerHTML = '';
    }
  }
});