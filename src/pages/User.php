<?php
require_once '../classes/Autoload.php';
session_start();

// Verifica se o usuário está logado
$usuarioSessao = $_SESSION['usuario'] ?? null;

if (!$usuarioSessao) {
    // Redireciona para a página de login se não estiver logado
    header('Location: ../../index.php');
    exit;
}

// Conexão com o banco
$db = new Database();
$pdo = $db->getConnection();

// Instancia a classe CreateUser corretamente
$createUser = new CreateUser($pdo);

// Recupera o ID do usuário salvo na sessão
$usuario_id = $usuarioSessao['usuario_id'] ?? null;

// Busca os dados do usuário
$usuario = $usuario_id ? $createUser->searchUserImage($usuario_id) : null;

$baseUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/gestaoStock/';

// Verifica se a imagem do usuário existe no banco e é válida
if (!empty($usuario['imagem_url']) && file_exists(__DIR__ . '/../../' . $usuario['imagem_url'])) {
    // Imagem do usuário existe
    $imagem = $baseUrl . ltrim($usuario['imagem_url'], '/');
} else {
    // Se não houver imagem, usa a imagem padrão
    $imagem = $baseUrl . 'src/assets/img/uploads_img_usuario/profile_user.svg';
}

// Matrícula do usuário
$matricula = $usuarioSessao['matricula'] ?? 'Sem matrícula';
?> 


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/User.css">
    <link rel="stylesheet" href="../assets/css/sair/sair.css">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- SCRIPTS -->
    <script src="../scripts/Menu.js" defer></script>
    <script src="../scripts/BtnCloseMenu.js" defer></script>
    <script src="../scripts/btnOptionMenu.js" defer></script>
</head>

<body>
    <!-- HEADER -->
    <header>
        <nav>
            <img src="../assets/img/logo.png" alt="Logo">
            <i class="material-icons iconMenu" id="iconCircle" onclick="menu()">menu</i>
        </nav>
    </header>

    <!-- MENU ASIDE -->
    <div id="menu">
        <aside>
            <label for="close">
                <img src="<?= htmlspecialchars($imagem); ?>" alt="Imagem do usuário">
                <i class="material-icons iconMenu" name="close" id="iconClose">cancel</i>
                <p><?= htmlspecialchars($matricula); ?></p>
            </label>

            <!-- Menus -->
            <!-- HOME -->
            <a name="home" href="User.php">
                <i class="material-icons iconProfile">home</i>
                home
            </a>
            <!-- PERFIL -->
            <a href="javascript:void(0);" onclick="exibirPerfil()">
                <i class="material-icons iconProfile">badge</i>
                Perfil
            </a>

            <!-- CADASTROS -->
            <a href="#" onclick="exibirCadastros()">
                <i class="material-icons iconRegister">fact_check</i>
                Cadastros
            </a>

            <!-- CLIENTES -->
            <a href="#" onclick="exibirClientes()">
                <i class="material-icons iconClients">groups</i>
                clientes
            </a>
            <!-- TÉCNICOS -->
            <a href="#" onclick="exibirTecnicos()">
                <i class="material-icons iconClients">engineering</i>
                tecnicos
            </a>
            <!-- TAREFAS -->
            <a href="#" onclick="exibirTarefas()">
                <i class="material-icons iconTasks">assignment</i>
                tarefas
            </a>
            <!-- EQUIPAMENTOS -->
            <a href="#" onclick="exibirEquip()">
                <i class="material-icons iconEquipments">construction</i>
                equipamentos
            </a>
            <!-- FORNECEDORES -->
            <a href="#" onclick="exibirFornecedores()">
                <i class="material-icons iconSuppliers">group</i>
                fornecedores
            </a>
            <!-- SUPORTE -->
            <a href="#">
                <i class="material-icons iconSupport">support_agent</i>
                suporte
            </a>
            <!-- SAIR -->
            <a href="../pages/login/Logout.php" class="iconLogout" id="btnSair">
                <i class="material-icons iconLogout">keyboard_double_arrow_left</i>
                sair
            </a>
        </aside>
    </div>

    <!-- MAIN -->
    <main>
        <div class="container">
            
        </div>

        <div class="container">
            <span>
                <a href="registrations/registerEquip/RegisterEquip.php" target="_blank"  id="equipamentRegistration">
                    <i class="material-icons" id="iconEquipament">construction</i>
                    <p>Cadastro de equipamentos</p>
                </a>
                <a href="registrations/registerCustomers/RegisterCustomers.php" target="_blank" target="_blank"  id="equipamentRegistration">
                    <i class="material-icons" id="iconEquipament">group_add</i>
                    <p>Cadastro de clientes</p>
                </a>
                <a href="registrations/registerSuppliers/RegisterSuppliers.php" target="_blank"  id="equipamentRegistration">
                    <i class="material-icons" id="iconEquipament">group</i>
                    <p>Cadastro de fornecedores</p>
                </a>
                
            </span>
        </div>

        <div class="container">
            <span>
                <a id="customersRegistration">
                    <i class="material-icons" id="iconCustomers">support_agent</i>
                    <p>Suporte</p>
                </a>
                <a href="registrations/category/DisplayCategory.php" target="_blank"  id="favorites">
                    <i class="material-icons" id="iconFavorites">category</i>
                    <p>Cadastro de categoria</p>
                </a>
                <a  href="registrations/registerTechnicians/registerTechnicians.php" target="_blank" id="history">
                    <i class="material-icons" id="iconHistory">engineering</i>
                    <p>Cadastro de técnicos</p>
                </a>
            </span>
        </div>
    </main>
    <!-- Container para carregar o modal -->
<div id="containerModalSair"></div>

<script>
    const btnSair = document.getElementById("btnSair");
    const containerModalSair = document.getElementById("containerModalSair");

    btnSair.addEventListener("click", (e) => {
        e.preventDefault(); // impede redirecionamento

        // Cria o modal diretamente no DOM
        containerModalSair.innerHTML = `
            <div id="modalSair" class="modal">
                <div class="modal-content">
                    <p>Tem certeza que deseja sair?</p>
                    <div class="modal-buttons">
                        <button id="btnConfirmarSair" class="btn btn-confirm">Sim</button>
                        <button id="cancelarSair" class="btn btn-cancel">Não</button>
                    </div>
                </div>
            </div>
        `;

        const modalSair = document.getElementById("modalSair");
        modalSair.style.display = "flex";

        const btnConfirmarSair = document.getElementById("btnConfirmarSair");
        const cancelarSair = document.getElementById("cancelarSair");

        // Confirma logout via fetch
        btnConfirmarSair.addEventListener("click", () => {
            fetch('../pages/login/Logout.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'logout_confirm=1'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.redirect; // Redireciona para index.php
                }
            });
        });

        // Cancela logout
        cancelarSair.addEventListener("click", () => {
            modalSair.style.display = "none";
            containerModalSair.innerHTML = '';
        });

        // Fecha modal ao clicar fora
        window.addEventListener("click", (event) => {
            if (event.target === modalSair) {
                modalSair.style.display = "none";
                containerModalSair.innerHTML = '';
            }
        });
    });
</script>
</body>

</html>