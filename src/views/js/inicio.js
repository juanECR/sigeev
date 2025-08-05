// Seleccionar los elementos del DOM
const hamburgerMenu = document.querySelector('.hamburger-menu');
const navLinks = document.querySelector('.nav-links');

// Añadir un event listener al botón de hamburguesa
hamburgerMenu.addEventListener('click', () => {
    // Alternar la clase 'active' en ambos elementos
    hamburgerMenu.classList.toggle('active');
    navLinks.classList.toggle('active');
});