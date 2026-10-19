
// 1. Seleccionamos el botón y el footer usando sus clases
const botonFooter = document.querySelector('.btn-footer');
const footer = document.querySelector('.footer');

// 2. Escuchamos cuando el usuario hace clic en el botón
botonFooter.addEventListener('click', function(event) {
  event.preventDefault(); // Evita que la página se recargue (ya que es un enlace <a>)
  
  // 3. Alternamos la clase 'mostrar' en el footer
  footer.classList.toggle('mostrar');
});

