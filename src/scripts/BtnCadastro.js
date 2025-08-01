function abrirCadastroENovaAba() {
    const botaoCadastro = document.getElementById("btnCadastro");

    if (botaoCadastro) {
        botaoCadastro.addEventListener("click", function () {
            // Abre a página de cadastro em nova aba
            window.open("../createUser/CreateUser.php", "_blank");

            // Fecha o modal se ele existir na janela principal
            const modal = window.parent.document.getElementById("loginModal");
            if (modal) {
                modal.style.display = "none";
            }
        });
    }
}

// Executa a função ao carregar o DOM
document.addEventListener("DOMContentLoaded", abrirCadastroENovaAba);
