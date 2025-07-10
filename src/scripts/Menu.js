console.log("Menu.js carregado");


document.addEventListener("DOMContentLoaded", () => {
    const btnMenu = document.getElementById('iconMenu');
    const menu = document.getElementById('menuUsuario');

    btnMenu.addEventListener('click', (event) => {
        event.stopPropagation();
        menu.style.display = (menu.style.display === 'flex') ? 'none' : 'flex';
    });

    // Fecha o menu ao clicar fora dele
    window.addEventListener('click', (event) => {
        if (!menu.contains(event.target) && event.target !== btnMenu) {
            menu.style.display = 'none';
        }
    });
});

