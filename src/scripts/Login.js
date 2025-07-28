

function login() {
    const btnLogin = document.querySelector('#btnLogin');
    const loginModal = document.querySelector('#loginModal');
    const iconCancel = document.getElementById('iconCancel');
    const iframe = document.getElementById('loginIframe'); // Adicionar referência ao iframe

    // ABRIR MODAL
    btnLogin.addEventListener('click', function () {
        loginModal.style.display = 'flex';
        
        
        // RECARREGA O IFRAME QUANDO O MODAL FOR ABERTO
        iframe.src = iframe.src; //FORÇA O RECARREGAMENTO DO IFRAME
    });

    // FECHAR MODAL
    iconCancel.addEventListener('click', function () {
        loginModal.style.display = 'none';
    });

    // FECHAR MODAL QUANDO CLICAR FORA DELE
    window.addEventListener('click', function (e) {
        if (e.target === loginModal) {
            loginModal.style.display = 'none';
        }
    });
}

login();
