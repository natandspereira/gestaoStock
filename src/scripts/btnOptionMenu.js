// EXIBIR PERFIL
function exibirPerfil() {
    const main = document.querySelector("main");

    fetch("../pages/profile/Profile.php")
        .then(response => {
            if (!response.ok) throw new Error("Erro ao carregar o perfil.");
            return response.json();
        })
        .then(data => {
            if (data.status !== 'success') {
                main.innerHTML = `<p style="color: red;">Erro: ${data.message}</p>`;
                return;
            }

            main.innerHTML = `
                <head>
                    <link rel="stylesheet" href="../assets/css/profile/Profile.css?v=1.1">
                    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
                    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
                </head>
                <div id="containerProfile">
                    <div id="mensagemPerfil"></div>
                    <div id="dataUser">
                        <p id="nomeUser"><strong>Nome:</strong> ${data.nome}</p>
                        <p id="emailUser"><strong>Email:</strong> ${data.email}</p>
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

            const mensagemDiv = document.getElementById("mensagemPerfil");

            function mostrarMensagem(texto, tipo) {
                mensagemDiv.textContent = texto;
                mensagemDiv.classList.remove('sucesso', 'erro'); 
                mensagemDiv.classList.add(tipo, 'show'); // 'sucesso' ou 'erro'

                setTimeout(() => {
                    mensagemDiv.classList.remove('show', 'sucesso', 'erro');
                }, 3000);
            }

            document.getElementById("profileForm").addEventListener("submit", function (event) {
                event.preventDefault();
                const formData = new FormData(this);

                // Valida campos obrigatórios
                const nome = formData.get("nome").trim();
                const email = formData.get("email").trim();
                const senha = formData.get("senha");
                const confirmarSenha = formData.get("confirmar_senha");

                if (!nome || !email) {
                    mostrarMensagem("Todos os campos obrigatórios devem ser preenchidos.", "erro");
                    return;
                }

                // Validação de senha se fornecida
                if (senha) {
                    if (senha !== confirmarSenha) {
                        mostrarMensagem("As senhas não coincidem.", "erro");
                        return;
                    }

                    const senhaRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
                    if (!senhaRegex.test(senha)) {
                        mostrarMensagem("A senha deve ter no mínimo 8 caracteres, contendo pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial.", "erro");
                        return;
                    }
                }

                // Envia para o PHP via fetch
                fetch("../pages/profile/Profile.php", {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(responseData => {
                    if (responseData.status === 'success') {
                        // Atualiza imagem do perfil
                        const imgPerfil = document.getElementById("imgPerfil");
                        if (imgPerfil && responseData.imagem_url) {
                            imgPerfil.src = responseData.imagem_url + "?t=" + new Date().getTime();
                        }

                        // Atualiza nome e email
                        document.getElementById("nomeUser").innerHTML = `<strong>Nome:</strong> ${responseData.nome}`;
                        document.getElementById("emailUser").innerHTML = `<strong>Email:</strong> ${responseData.email}`;

                        // Limpa campos de senha
                        this.senha.value = '';
                        this.confirmar_senha.value = '';

                        mostrarMensagem("Perfil atualizado com sucesso!", "sucesso");
                    } else {
                        mostrarMensagem(responseData.message, "erro");
                    }
                })
                .catch(error => {
                    mostrarMensagem("Erro: " + error.message, "erro");
                });
            });
        })
        .catch(error => {
            main.innerHTML = `<p style="color: red;">Erro: ${error.message}</p>`;
        });
}




// ======================================

// EXIBIR CADASTROS
function exibirCadastros() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/registrations/Registrations.php")
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
// ======================================

// EXIBIR CLIENTES - EXCLUIR CLIENTES - EDITAR CLIENTES
function exibirClientes() {
    const main = document.querySelector("main");
    main.innerHTML = "<p style='padding: 1rem;'>Carregando clientes...</p>";

    fetch("../pages/lists/listCustomers/ListCustomers.php")
        .then(response => {
            const contentType = response.headers.get("content-type");
            if (contentType && contentType.includes("application/json")) {
                return response.json();
            }
            return response.text();
        })
        .then(data => {
            if (typeof data === "object") {
                mostrarMensagem(data.status, data.mensagem);
                return;
            }
            main.innerHTML = data;
        })
        .catch(error => {
            mostrarMensagem("erro", "Erro ao carregar clientes: " + error.message);
        });
}

function excluirCliente(id) {
    if (!confirm("Tem certeza que deseja excluir este cliente?")) return;

    const formData = new FormData();
    formData.append("clientes_id", id);

    fetch("../pages/delete/deleteCustomers/deleteCustomers.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                setTimeout(exibirClientes, 1000);
            }
        })
        .catch(() => {
            mostrarMensagem("erro", "❌ Ocorreu um erro inesperado ao excluir o cliente.");
        });
}

function salvarEdicaoCliente() {
    const id = document.getElementById("edit_id").value.trim();
    const nome = document.getElementById("edit_nome").value.trim();
    const cpf_cnpj = document.getElementById("edit_cpf_cnpj").value.trim();
    const email = document.getElementById("edit_email").value.trim();
    const telefone = document.getElementById("edit_telefone").value.trim();
    const cidade = document.getElementById("edit_cidade").value.trim();
    const estado = document.getElementById("edit_estado").value.trim();

    // Validação básica
    if (!id || !nome || !cpf_cnpj || !email) {
        mostrarMensagem("erro", "Preencha todos os campos obrigatórios.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("cpf_cnpj", cpf_cnpj);
    formData.append("email", email);
    formData.append("telefone", telefone);
    formData.append("cidade", cidade);
    formData.append("estado", estado);

    fetch("../pages/edit/editCustomers/editCustomers.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                fecharModal();
                exibirClientes(); // Atualiza lista na tela
            }
        })
        .catch(error => {
            console.error("Erro na edição:", error);
            mostrarMensagem("erro", "Ocorreu um erro ao salvar a edição.");
        });
}


// ======================================

// EXIBIR TAREFAS - EXCLUIR TAREFAS
function exibirTarefas() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/lists/listTasks/ListTasks.php")
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

function excluirTarefa(id) {
    if (!confirm("Tem certeza que deseja excluir essa tarefa?")) return;

    const formData = new FormData();
    formData.append("tarefas_id", id);

    fetch("../pages/delete/deleteTask/deleteTask.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                setTimeout(exibirTarefas, 1000);
            }
        })
        .catch(() => {
            mostrarMensagem("erro", "❌ Ocorreu um erro inesperado ao excluir o tecnico.");
        });
}

function salvarEdicaoTarefa() {
    const id = document.getElementById("edit_id").value.trim();
    const nome = document.getElementById("edit_nome").value.trim();
    const prazo = document.getElementById("edit_prazo").value.trim();
    const qt_reparos = document.getElementById("edit_quantidade_reparos").value.trim();
    const dt_conclusao = document.getElementById("edit_data_conclusao").value.trim();
    const observacao = document.getElementById("edit_observacoes").value.trim();
    const status = document.getElementById("edit_status").value.trim();
    const categoria = document.getElementById("edit_categoria_id").value;
    const equipamentos = document.getElementById("edit_equipamentos_id").value;

    // Valida se os IDs são válidos antes de enviar
    if (!id || !categoria || !equipamentos) {
        mostrarMensagem("erro", "Por favor, selecione categoria e equipamento válidos.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("prazo", prazo);
    formData.append("quantidade_reparos", qt_reparos);
    formData.append("data_conclusao", dt_conclusao);
    formData.append("observacoes", observacao);
    formData.append("status", status);
    formData.append("categoria_id", parseInt(categoria)); // garante que seja número
    formData.append("equipamentos_id", parseInt(equipamentos)); // garante que seja número

    fetch("../pages/edit/editTask/editTask.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                fecharModal();
                exibirTarefas(); // Atualiza lista na tela
            }
        })
        .catch(error => {
            console.error("Erro na edição:", error);
            mostrarMensagem("erro", "Ocorreu um erro ao salvar a edição.");
        });
}

// ======================================

// EXIBIR TECNICOS - EXCLUIR TECNICOS
function exibirTecnicos() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/lists/listTechnicians/ListTechnicians.php")
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

function excluirTecnico(id) {
    if (!confirm("Tem certeza que deseja excluir este Tecnico?")) return;

    const formData = new FormData();
    formData.append("tecnico_id", id);

    fetch("../pages/delete/deleteTechnicians/deleteTechnicians.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                setTimeout(exibirTecnicos, 1000);
            }
        })
        .catch(() => {
            mostrarMensagem("erro", "❌ Ocorreu um erro inesperado ao excluir o tecnico.");
        });
}

function salvarEdicaoTecnico() {
    const id = document.getElementById("edit_id").value.trim();
    const nome = document.getElementById("edit_nome").value.trim();
    const email = document.getElementById("edit_email").value.trim();
    const telefone = document.getElementById("edit_telefone").value.trim();
    const cidade = document.getElementById("edit_cidade").value.trim();
    const estado = document.getElementById("edit_estado").value.trim();
    const tp_tecnico = document.getElementById("edit_especialidade").value.trim(); // <-- renomeado

    // Validação básica
    if (!id || !nome) {
        mostrarMensagem("erro", "Preencha todos os campos obrigatórios.");
        return;
    }

    const formData = new FormData();
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("email", email);
    formData.append("telefone", telefone);
    formData.append("cidade", cidade);
    formData.append("estado", estado);
    formData.append("tp_tecnico", tp_tecnico); // <-- envia com o mesmo nome do banco

    fetch("../pages/edit/editTechnicians/editTechnicians.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                fecharModal();
                exibirTecnicos(); // Atualiza lista na tela
            }
        })
        .catch(error => {
            console.error("Erro na edição:", error);
            mostrarMensagem("erro", "Ocorreu um erro ao salvar a edição.");
        });
}

// ======================================

// EXIBIR EQUIPAMENTOS - EXCLUIR EQUIPAMENTOS
function exibirEquip() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/lists/listEquip/ListEquip.php")
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

function excluirEquip(id) {
    if (!confirm("Tem certeza que deseja excluir este Equipamento?")) return;

    const formData = new FormData();
    formData.append("equipamentos_id", id);

    fetch("../pages/delete/deleteEquip/deleteEquip.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                setTimeout(exibirEquip, 1000);
            }
        })
        .catch(() => {
            mostrarMensagem("erro", "❌ Ocorreu um erro inesperado ao excluir o equipamento.");
        });
}

function salvarEdicaoEquip() {
    const id = document.getElementById("edit_id").value.trim();
    const nome = document.getElementById("edit_nome").value.trim();
    const codigo = document.getElementById("edit_codigo").value.trim();
    const patrimonio = document.getElementById("edit_patrimonio").value.trim();
    const qt_atual = document.getElementById("edit_qt_atual").value.trim();
    const qt_minima = document.getElementById("edit_qt_minima").value.trim();
    const valor_custo = document.getElementById("edit_valor_custo").value.trim();
    const valor_venda = document.getElementById("edit_valor_venda").value.trim();
    const valor_aluguel = document.getElementById("edit_valor_aluguel").value.trim();
    const valor_manutencao = document.getElementById("edit_valor_manutencao").value.trim();

    const formData = new FormData();
    formData.append("id", id);
    formData.append("nome", nome);
    formData.append("codigo", codigo);
    formData.append("patrimonio", patrimonio);
    formData.append("qt_atual", qt_atual);
    formData.append("qt_minima", qt_minima);
    formData.append("valor_custo", valor_custo);
    formData.append("valor_venda", valor_venda);
    formData.append("valor_aluguel", valor_aluguel);
    formData.append("valor_manutencao", valor_manutencao);


    fetch("../pages/edit/editEquip/editEquip.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                fecharModal();
                exibirEquip(); // Atualiza lista na tela
            }
        })
        .catch(error => {
            console.error("Erro na edição:", error);
            mostrarMensagem("erro", "Ocorreu um erro ao salvar a edição.");
        });
}
// ======================================

// EXIBIR FORNECEDORES - EXCLUIR FORNECEDORES
function exibirFornecedores() {
    const main = document.querySelector("main");

    // Mensagem de carregamento opcional
    main.innerHTML = "<p style='padding: 1rem;'>Carregando perfil...</p>";

    fetch("../pages/lists/listSuppliers/ListSuppliers.php")
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

function excluirFornecedor(id) {
    if (!confirm("Tem certeza que deseja excluir esse Fornecedor?")) return;

    const formData = new FormData();
    formData.append("fornecedor_id", id);

    fetch("../pages/delete/deleteSuppliers/deleteSuppliers.php", {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                setTimeout(exibirFornecedores, 1000);
            }
        })
        .catch(() => {
            mostrarMensagem("erro", "❌ Ocorreu um erro inesperado ao excluir o fornecedor.");
        });
}

function salvarEdicaoFornecedor() {
    const id = document.getElementById("edit_id").value.trim();
    const razao_social = document.getElementById("edit_razao_social").value.trim();
    const nome_fantasia = document.getElementById("edit_nome_fantasia").value.trim();
    const cnpj = document.getElementById("edit_cnpj").value.trim();
    const inscricao_estadual = document.getElementById("edit_inscricao_estadual").value.trim();
    const telefone = document.getElementById("edit_telefone").value.trim();
    const email = document.getElementById("edit_email").value.trim();
    const cep = document.getElementById("edit_cep").value.trim();
    const endereco = document.getElementById("edit_endereco").value.trim();
    const bairro = document.getElementById("edit_bairro").value.trim();
    const cidade = document.getElementById("edit_cidade").value.trim();
    const estado = document.getElementById("edit_estado").value.trim();
    const numero = document.getElementById("edit_numero").value.trim();
    const complemento = document.getElementById("edit_complemento").value.trim();
    const observacoes = document.getElementById("edit_observacoes").value.trim();

    const formData = new FormData();
    formData.append("id", id);
    formData.append("razao_social", razao_social);
    formData.append("nome_fantasia", nome_fantasia);
    formData.append("cnpj", cnpj);
    formData.append("inscricao_estadual", inscricao_estadual);
    formData.append("telefone", telefone);
    formData.append("email", email);
    formData.append("cep", cep);
    formData.append("endereco", endereco);
    formData.append("bairro", bairro);
    formData.append("cidade", cidade);
    formData.append("estado", estado);
    formData.append("numero", numero);
    formData.append("complemento", complemento);
    formData.append("observacoes", observacoes);


    fetch("../pages/edit/editSuppliers/editSuppliers.php", {
        method: "POST",
        body: formData
    })
        .then(response => response.json())
        .then(data => {
            mostrarMensagem(data.status, data.mensagem);

            if (data.status === "sucesso") {
                fecharModalSuppliers();
                exibirFornecedores(); // Atualiza lista na tela
            }
        })
        .catch(error => {
            console.error("Erro na edição:", error);
            mostrarMensagem("erro", "Ocorreu um erro ao salvar a edição.");
        });
}
// ======================================

// FUNÇÃO PARA EXIBIR MENSAGEM
function mostrarMensagem(tipo, texto) {
    const toast = document.createElement('div');
    toast.classList.add('toast', tipo);
    toast.textContent = texto;

    document.body.appendChild(toast);

    setTimeout(() => toast.classList.add('show'), 50);

    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}
// ======================================

// MODAL
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    const modal = document.getElementById("modalEditar");
    modal.style.display = "flex";

    for (const [key, value] of Object.entries(btn.dataset)) {
        const el = document.getElementById("edit_" + key);
        if (!el) continue;

        // Select ou input
        el.value = value;
    }
});

// Fechar modal
function fecharModal() {
    const modal = document.getElementById("modalEditar");
    modal.style.display = "none";
}

window.addEventListener("click", function (e) {
    const modal = document.getElementById("modalEditar");
    if (e.target === modal) fecharModal();
});
// ======================================

// MODAL Suppliers
document.addEventListener("click", function (e) {
    const btn = e.target.closest(".btn-editar");
    if (!btn) return;

    const modal = document.getElementById("modalEditarSuppliers");
    modal.style.display = "flex";

    for (const [key, value] of Object.entries(btn.dataset)) {
        const el = document.getElementById("edit_" + key);
        if (!el) continue;

        // Select ou input
        el.value = value;
    }
});

// Fechar modal
function fecharModalSuppliers() {
    const modal = document.getElementById("modalEditarSuppliers");
    modal.style.display = "none";
}

window.addEventListener("click", function (e) {
    const modal = document.getElementById("modalEditarSuppliers");
    if (e.target === modal) fecharModalSuppliers();
});


