

function close() {
    const btnClose = document.querySelector('#iconClose');
    const menu = document.querySelector('#menu');

    if (btnClose && menu) {
        btnClose.addEventListener('click', () => {
            menu.style.display = 'none';
        });
    }
}

document.addEventListener('DOMContentLoaded', close);


