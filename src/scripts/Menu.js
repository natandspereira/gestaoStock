function menu() {
    document.addEventListener('DOMContentLoaded', () => {
        const btnMenu = document.querySelector('.iconMenu');
        const menuAside = document.querySelector('#menu');

        if (btnMenu && menuAside) {
            btnMenu.addEventListener('click', () => {
                // ALTERNA ENTRE 'FLEX E 'NONE
                menuAside.style.display = menuAside.style.display === 'flex' ? 'none' : 'flex';
            });
        }

        window.addEventListener('click', function(e){
            if(e.target === menuAside){
                menuAside.style.display = 'none';
            }
        })
    });
}

menu();
