
const btn = document.querySelector('.btn');


const newH = document.createElement('h1');
newH.textContent = "Aprestate el boton!";
//console.log(btn);

btn.addEventListener('click',() => {
 //console.log("<h1> Click! </h1>");
 btn.classList.toggle('btn-success');
 document.body.appendChild(newH);

});