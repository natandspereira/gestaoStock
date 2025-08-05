





function exibirPerfil() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/profile/Profile.php")
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

function exibirClientes() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/registerCustomers/RegisterCustomers.php")
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

function exibirTarefas() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/registerTasks/RegisterTasks.php")
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

function exibirTecnicos(){
        const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/registerTechnicians/ListTechnicians.php")
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
