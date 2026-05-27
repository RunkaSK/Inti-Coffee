function setActiveNav() {
    const navLinks = document.querySelectorAll('.nav-link');
    const path = window.location.pathname.split('/').pop() || 'index.html';

    navLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href');

        if (href === path || (href === 'index.html' && path === '')) {
            link.classList.add('active');
        }
    });
}

function irAlMenu() {
    window.location.href = 'menu.html';
}

function filtrar(categoria) {
    const cards = document.querySelectorAll(".card");

    cards.forEach(card => {
        const tipo = card.getAttribute("data-category");

        if (categoria === "todos" || tipo === categoria) {
            card.style.display = "block";
        } else {
            card.style.display = "none";
        }
    });
}

function initCards() {
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, i) => {
        setTimeout(() => card.classList.add('show'), i * 120);
    });
}

function initSlider() {
    const slides = document.querySelectorAll('.slides img');
    if (!slides.length) return;

    let index = 0;
    setInterval(() => {
        slides[index].classList.remove('active');
        index = (index + 1) % slides.length;
        slides[index].classList.add('active');
    }, 3000);
}

window.addEventListener('load', () => {
    setActiveNav();
    initCards();
    initSlider();
});

// Funciones para Modal de Autenticación
function toggleAuthModal() {
    const modal = document.getElementById('authModal');
    modal.classList.toggle('show');
}

function switchTab(tabName) {
    // Ocultar todos los tab-content
    const contents = document.querySelectorAll('.tab-content');
    contents.forEach(content => content.classList.remove('active'));

    // Desactivar todos los botones
    const buttons = document.querySelectorAll('.tab-btn');
    buttons.forEach(btn => btn.classList.remove('active'));

    // Mostrar el tab seleccionado
    document.getElementById(tabName).classList.add('active');
    event.target.classList.add('active');
}

// Cerrar modal al hacer click fuera de él
document.addEventListener('click', (e) => {
    const modal = document.getElementById('authModal');
    const userProfile = document.querySelector('.user-profile');
    
    if (modal && modal.classList.contains('show') && 
        !modal.querySelector('.auth-container').contains(e.target) && 
        !userProfile.contains(e.target)) {
        modal.classList.remove('show');
    }
});

const carousel = document.getElementById("carousel");

function scrollLeft() {
    carousel.scrollBy({
        left: -300,
        behavior: "smooth"
    });
}

function scrollRight() {
    carousel.scrollBy({
        left: 300,
        behavior: "smooth"
    });

    checkInfinite();
}

/* INFINITE SCROLL REAL */
function checkInfinite() {

    const cards = document.querySelectorAll(".card");

    const lastCards = Array.from(cards).slice(0, 4);

    lastCards.forEach(card => {

        const clone = card.cloneNode(true);

        clone.classList.add("fade-in");

        carousel.appendChild(clone);

    });

}