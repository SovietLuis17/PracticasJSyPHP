
const formulario = document.querySelector('#formulario');
const input =  document.querySelector('#label');
const lista = document.querySelector('.list-group');

//console.log(lista);

// evento tipo submit

formulario.addEventListener('submit', (event) =>{
   //evitar recarga de pagina
   event.preventDefault();

   //obtener el texto del usuario y limpiando los espacios
   const textoUsuario = input.value.trim();

   // verificar que no este vacio
   if(textoUsuario !== '') {
     //  Crear el nuevo elemento <li>
    const nuevoLi = document.createElement("li");
    
    // Asignarle el texto del input
    nuevoLi.textContent = textoUsuario;

    //agregarle a css
   nuevoLi.classList.add("list-group-item");

    
    //  Meter el <li> dentro de la lista <ul>
    lista.appendChild(nuevoLi);
    
    //  Limpiar el input para que quede listo para el siguiente texto
    input.value = "";
   }
});