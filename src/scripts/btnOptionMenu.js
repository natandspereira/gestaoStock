




function exibirPerfil() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("Profile.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao carregar o perfil.");
            }
            return response.text();
        })
        .then(data => {
            main.innerHTML = data;
        })
        .catch(error => {
            main.innerHTML = `<p style="color: red;">Erro: ${error.message}</p>`;
        });
}

