const btnMenu = document.getElementById('iconMenu');
const menu = document.getElementById('menuUsuario');


function abrirMenu(){
    btnMenu.addEventListener("click", (event)=>{
         event.stopPropagation();
         const display = window.getComputedStyle(menu).display;
         menu.style.display = (display === 'none') ? 'flex' : 'none';
    });

    window.addEventListener("click", (event)=>{
        if(!menu.contains(event.target) && event.target !== btnMenu){
            menu.style.display = "none";
        }
    });
}

