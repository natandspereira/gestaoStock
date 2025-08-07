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
            <!-- FEEDBACK -->
            <a href="#">
                <i class="material-icons iconFeedback">thumbs_up_down</i>
                feedback
            </a>
            <!-- SAIR -->
            <a href="../pages/login/Logout.php" class="iconLogout">
                <i class="material-icons iconLogout">keyboard_double_arrow_left</i>
                sair
            </a>
        </aside>
    </div>

    <!-- MAIN -->
    <main>
        <div class="container">
            <div id="equipment">
                <p>Equipamento precisando de reparos</p>
                <span>
                    <p>0</p><i class="material-icons" id="iconError">error</i>
                </span>
            </div>
            <div id="amount">
                <p>Quantidade de produtos no estoque</p>
                <span>
                    <p>0</p><i class="material-icons" id="iconStock">inventory</i>
                </span>
            </div>
            <div id="cost">
                <p>Custo total de produtos</p>
                <span>
                    <p>0</p><i class="material-icons" id="iconDolar">attach_money</i>
                </span>
            </div>
        </div>

        <div class="container">
            <span>
                <div id="equipamentRegistration">
                    <i class="material-icons" id="iconEquipament">construction</i>
                    <p>Cadastro de equipamentos</p>
                </div>
                <div id="contacts">
                    <i class="material-icons" id="iconContacts">groups</i>
                    <p>Contatos Técnicos</p>
                </div>
                <div id="finance">
                    <i class="material-icons" id="iconFinance">attach_money</i>
                    <p>Finanças</p>
                </div>
            </span>
        </div>

        <div class="container">
            <span>
                <div id="customersRegistration">
                    <i class="material-icons" id="iconCustomers">group_add</i>
                    <p>Cadastro de clientes</p>
                </div>
                <div id="favorites">
                    <i class="material-icons" id="iconFavorites">workspace_premium</i>
                    <p>Equipamentos mais utilizados</p>
                </div>
                <div id="history">
                    <i class="material-icons" id="iconHistory">history</i>
                    <p>Últimas movimentações</p>
                </div>
            </span>
        </div>
    </main>
</body>

</html>