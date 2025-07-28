function contact() {
    const btnsForm = document.querySelectorAll('.btnForm'); // todos os botões
    const contactModal = document.querySelector('.contactModalForm');
    const iconCancelForm = document.getElementById('iconCancelForm');

    // ABRIR MODAL para todos os botões
    btnsForm.forEach(btn => {
        btn.addEventListener('click', function () {
            contactModal.style.display = 'flex';
        });
    });

    // FECHAR MODAL
    iconCancelForm.onclick = function () {
        contactModal.style.display = 'none';
    };

    // FECHAR MODAL QUANDO CLICAR FORA
    window.addEventListener('click', function (e) {
        if (e.target === contactModal) {
            contactModal.style.display = 'none';
        }
    });
}

contact();