<?php
session_start();
include '../data/DB.php';
// REDIRECIONA O USUÁRIO PARA PÁGINA DE LOGIN, CASO ELE NÃO TENHA FEITO LOGIN
if (!isset($_SESSION['usuario'])) {
    header('Location: Login.php');
    exit();
}

$matricula = $_SESSION['usuario'];

$stmt = $pdo->prepare("SELECT imagem_url FROM usuarios WHERE matricula = :matricula");
$stmt->execute(['matricula' => $matricula]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

//HORA E DATA 
date_default_timezone_set('America/Sao_Paulo');
$dataHora = date("d/m/y H:i:s");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Usuário</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/Dashboard_User.css">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- SCRIPT MENU -->
     <script src="../scripts/Menu.js" defer></script>
</head>

<body>
    <!-- HEADER -->
    <header>
        <nav>
            <div class="btnMenu">
                <i class="material-icons" id="iconMenu" onclick="abrirMenu()">menu</i>
            </div>
            <div class="logo">
                <img src="../assets//img/logo.svg" alt="logo">
            </div>
        </nav>
    </header>
    <!-- HR -->
     <hr>
    <!-- MAIN -->
    <main>
        <aside id="menuUsuario">
            <!-- NOME USUÁRIO -->
             <div id="nomeUsuario">
                <div class="imgUsuario">
                    <div class="imgUsuario">
                        <?php if (!empty($usuario['imagem_url'])): ?>
                            <img src="/gestaoStock/<?= htmlspecialchars($usuario['imagem_url']) ?>" width="150" alt="Foto do usuário">
                        <?php else: ?>
                            <img src="../assets/img/default.png" width="150" alt="Sem imagem">
                        <?php endif; ?>
                    </div>
                </div>
                <p>
                    <?= htmlspecialchars($_SESSION['usuario']);?>
                </p>
                <p>
                    <?= htmlspecialchars($dataHora);?>
                </p>
             </div>
            <!-- PERFIL -->
            <ul id="perfil">
                <i class="material-icons" id="iconAccount">account_circle</i>
                <li>Perfil</li>
            </ul>
            <!-- CLIENTES -->
             <ul id="clientes">
                <i class="material-icons" id="iconSuporte">groups</i>
                <li>Clientes</li>
            </ul>
            <!-- TÉCNICOS -->
              <ul id="tecnicos">
                <i class="material-icons" id="iconSuporte">support_agent</i>
                <li>Técnicos</li>
            </ul>
             <!-- EQUIPAMENTOS -->
            <ul id="equipamentos">
                <i class="material-icons" id="iconSuporte">groups</i>
                <li>Equipamentos</li>
            </ul> 
            <!-- FORNECEDORES -->
            <ul id="fornecedores">
                <i class="material-icons" id="iconSuporte">groups</i>
                <li>Fornecedores</li>
            </ul>
            <!-- SUPORTE -->
            <ul id="suporte">
                <i class="material-icons" id="iconSuporte">support_agent</i>
                <li>Suporte</li>
            </ul>
            <!-- SAIR -->
             <ul id="sair">
                <i class="material-icons" id="iconSuporte">logout</i>
                <li><a href="../data/DB_Logout.php">Sair</a></li> 
            </ul>
        </aside>
    </main>
</body>

</html>