function exibirPerfil() {
    const main = document.querySelector("main");

    fetch("../pages/profile/Profile.php")
        .then(response => {
            if (!response.ok) {
                throw new Error("Erro ao carregar o perfil.");
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                // Monta o HTML inicial do perfil (sem recarregar toda a página depois)
                main.innerHTML = `
                    <head>
                        <link rel="stylesheet" href="../assets/css/profile/Profile.css?=1.1">
                        <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
                        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                    </head>
                    <div id="containerProfile">
                        <div id="dataUser">
                            <div id="imgUser">
                                
                            </div>
                            <p id="nomeUser"><strong>Nome:</strong> ${data.nome}</p>
                            <p id="emailUser"><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Senha:</strong> **********</p>
                        </div>
                        <form id="profileForm" method="POST" enctype="multipart/form-data">
                            <input type="text" name="nome" value="${data.nome}" required>
                            <input type="email" name="email" value="${data.email}" required>
                            <input type="password" name="senha" placeholder="Nova senha">
                            <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha">
                            <input type="file" name="imagem" accept="image/*">
                            <button type="submit">Atualizar</button>
                        </form>
                    </div>
                `;

                // Adiciona evento ao formulário para atualizar perfil via AJAX
                document.getElementById("profileForm").addEventListener("submit", function(event) {
                    event.preventDefault();
                    const formData = new FormData(this);

                    fetch("../pages/profile/Profile.php", {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(responseData => {
                        if (responseData.status === 'success') {
                            // Atualiza imagem do perfil (força reload da imagem com timestamp para evitar cache)
                            const imgPerfil = document.getElementById("imgPerfil");
                            if (imgPerfil && responseData.imagem_url) {
                                imgPerfil.src = responseData.imagem_url + "?t=" + new Date().getTime();
                            }
                            // Atualiza nome e email exibidos
                            document.getElementById("nomeUser").innerHTML = `<strong>Nome:</strong> ${responseData.nome}`;
                            document.getElementById("emailUser").innerHTML = `<strong>Email:</strong> ${responseData.email}`;
                            // Limpa campos de senha do formulário
                            this.senha.value = '';
                            this.confirmar_senha.value = '';
                            // Opcional: exibe mensagem de sucesso
                            alert("Perfil atualizado com sucesso!");
                        } else {
                            alert("Erro: " + responseData.message);
                        }
                    })
                    .catch(error => {
                        alert("Erro: " + error.message);
                    });
                });
            } else {
                main.innerHTML = `<p style="color: red;">Erro: ${data.message}</p>`;
            }
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
