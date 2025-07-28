<?php
require_once '../classes/Autoload.php';
require_once 'Logout.php';
session_start();

$usuarioSessao = $_SESSION['usuario'] ?? null;

// Conexão com o banco
$db = new Database();
$pdo = $db->getConnection();

// Instancia a classe CreateUser corretamente
$createUser = new CreateUser($pdo);

// Verifica se temos um ID de usuário
$usuario_id = $usuarioSessao['usuario_id'] ?? null;

// Busca os dados do usuário (inclusive imagem)
$usuario = $usuario_id ? $createUser->searchUserImage($usuario_id) : null;

// Protege contra erro de chave indefinida
$imagem = (is_array($usuario) && isset($usuario['image_url']))
    ? $usuario['image_url']
    : "../assets/img/uploads_img_usuario/profile_user.svg";

$matricula = $usuarioSessao['matricula'] ?? 'Sem matrícula';


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/User.css">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- LINK SCRIPT MENU -->
    <script src="../scripts/Menu.js" defer></script>
    <!-- LINK SCRIPT BTN CLOSE MENU  -->
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
            <!-- PERFIL -->
            <label for="profile">
                <i class="material-icons iconMenu" name="profile" id="iconProfile">manage_accounts</i>
                <p>perfil</p>
            </label>
            <!-- CLIENTES -->
            <label for="clients">
                <i class="material-icons iconMenu" name="clients" id="iconClients">groups</i>
                <p>clientes</p>
            </label>
            <!-- EQUIPAMENTOS -->
            <label for="equipment">
                <i class="material-icons iconMenu" name="equipment" id="iconEquipment">construction</i>
                <p>equipamentos</p>
            </label>
            <!-- FORNECEDORES -->
            <label for="suppliers">
                <i class="material-icons iconMenu" name="suppliers" id="iconSuppliers">group</i>
                <p>fornecedores</p>
            </label>
            <!-- SUPORTE -->
             <label for="support">
                <i class="material-icons iconMenu" name="support" id="iconSupport">support_agent</i>
                <p>suporte</p>
            </label>
            <!-- FEEDBACK -->
             <label for="feedback">
                <i class="material-icons iconMenu" name="feedback" id="iconFeedback">thumbs_up_down</i>
                <p>feedback</p>
            </label>
            <!-- SAIR -->
             <label for="logout">
                <i class="material-icons iconMenu" name="logout" id="iconLogout">keyboard_double_arrow_left</i>
                <p>sair</p>
            </label>

        </aside>
    </div>
    <!-- MAIN -->
    <main>
        <div class="container">
            <div id="equipment">
                <p>Equipamento precisando de reparos</p>
                <span>
                    <p>0</p>
                    <i class="material-icons" id="iconError">error</i>
                </span>
            </div>
            <div id="amount">
                <p>Quantidade de produtos no estoque</p>
                <span>
                    <p>0</p>
                    <i class="material-icons" id="iconStock">inventory</i>
                </span>
            </div>
            <div id="cost">
                <p>Custo total de produtos</p>
                <span>
                    <p>0</p>
                    <i class="material-icons" id="iconDolar">attach_money</i>
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