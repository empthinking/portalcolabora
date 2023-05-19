var elementos = document.getElementsByClassName('navbar');
var el = elementos[0];
el.style.backgroundColor = '#63f253';


let btn = document.querySelector('.fa-eye')

btn.addEventListener('click', () => {
    let inputSenha = document.querySelector('#senha')

    if (inputSenha.getAttribute('type') == 'password') {
        inputSenha.setAttribute('type', 'text')
    } else {
        inputSenha.setAttribute('type', 'password')
    }
})

//modal
var modal = document.getElementById('singIn');
// Whegit pull
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

var botaoFiltro = document.querySelector('#botaoFiltro');

      botaoFiltro.addEventListener('click', () => {
        let divFiltro = document.querySelector('#divFilt')

        if (divFiltro.getAttribute('class') == 'menu-container fixed inset-0 overflow-hidden z-40 hidden') {
          divFiltro.setAttribute('class', '0')
        } else {
          divFiltro.setAttribute('class', 'menu-container fixed inset-0 overflow-hidden z-40 hidden')
        }
      });


      var filtroBack = document.querySelector('#filtroBack');
      filtroBack.addEventListener('click', () => {
        let filtroBack = document.querySelector('#divFilt')
        if (filtroBack.getAttribute('class') == 'menu-container fixed inset-0 overflow-hidden z-40 hidden') {
          filtroBack.setAttribute('class', 'menu-container fixed inset-0 overflow-hidden z-40 hidden')
        } else {
          filtroBack.setAttribute('class', 'menu-container fixed inset-0 overflow-hidden z-40 hidden')
        }
      });



// function verSenha(inputSenha) {
//     if (inputSenha.getAttribute('type') === 'password') {
//       inputSenha.setAttribute('type', 'text');
//     } else {
//       inputSenha.setAttribute('type', 'password');
//     }
//   }
//   const btn = document.querySelector('.fa-eye');
//   const inputSenha1 = document.querySelector('#senha1');
//   const inputSenha2 = document.querySelector('#senha2');
//   const inputSenha3 = document.querySelector('#senha3');
  
//   btn.addEventListener('click', () => {
//     verSenha(inputSenha1);
//     verSenha(inputSenha2);
//     verSenha(inputSenha3);
//   });
  
  
//modal end

// Navbar toggle
document.addEventListener('DOMContentLoaded', () => {

  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {

    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {

        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');

      });
    });
  }

});



