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
$usuario_id = $usuarioSessao['id'] ?? null;

// Busca os dados do usuário (inclusive imagem)
$usuario = $usuario_id ? $createUser->searchUserImage($usuario_id) : null;

// Define a imagem padrão, caso não haja imagem cadastrada
$imagem = (is_array($usuario) && isset($usuario['image_url']))
    ? $usuario['image_url']
    : "../assets/img/uploads_img_usuario/profile_user.svg";

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
            <label><i class="material-icons iconMenu">manage_accounts</i><p>perfil</p></label>
            <label><i class="material-icons iconMenu">groups</i><p>clientes</p></label>
            <label><i class="material-icons iconMenu">construction</i><p>equipamentos</p></label>
            <label><i class="material-icons iconMenu">group</i><p>fornecedores</p></label>
            <label><i class="material-icons iconMenu">support_agent</i><p>suporte</p></label>
            <label><i class="material-icons iconMenu">thumbs_up_down</i><p>feedback</p></label>

            <!-- SAIR -->
            <label>
                <i class="material-icons iconMenu">keyboard_double_arrow_left</i>
                <a href="Logout.php">sair</a>
            </label>
        </aside>
    </div>

    <!-- MAIN -->
    <main>
        <div class="container">
            <div id="equipment">
                <p>Equipamento precisando de reparos</p>
                <span><p>0</p><i class="material-icons" id="iconError">error</i></span>
            </div>
            <div id="amount">
                <p>Quantidade de produtos no estoque</p>
                <span><p>0</p><i class="material-icons" id="iconStock">inventory</i></span>
            </div>
            <div id="cost">
                <p>Custo total de produtos</p>
                <span><p>0</p><i class="material-icons" id="iconDolar">attach_money</i></span>
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
