<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
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
            <i class="material-icons" id="iconMenu" onclick="abrirMenu()">menu</i>
            <span></span>
            <div class="logo">
                <img src="../assets/img/logo.svg" alt="logo">
            </div>
        </nav>
     </header>
     <hr>
    <main>
        <!-- MENU -->
        <aside class="menu" id="menu">
            <div class="nomeUsuario">
                <p>Bem vindo(a), <?= htmlspecialchars($_SESSION['usuario']); ?></p>
            </div>
            <div class="menuIcon">
                <!-- PERFIL -->
               <span>
                     <i class="material-icons" id="iconPerfil">account_box</i>
                     <p>Perfil</p>
               </span>
                <!-- CLIENTES -->
                <span>
                    <i class="material-icons" id="iconClientes">group</i>
                    <p>Clientes</p>
                </span>
                <!-- TECNICOS -->
               <span>
                     <i class="material-icons" id="iconTecnicos">groups_2</i>
                     <p>Técnicos</p>
               </span>
                <!-- EQUIPAMENTOS -->
                <span>
                    <i class="material-icons" id="iconEquipamentos">construction</i>
                    <p>Equipamentos</p>
                </span>
                 <!-- FORNECEDORES -->
                <span>
                     <i class="material-icons" id="iconFornecedores">groups_3</i>
                     <p class="iconFornecedores" >Fornecedores</p>
                </span>
                <!-- SUPORTE -->
                <span>
                    <i class="material-icons" id="iconSuporte">support_agent</i>
                    <p>Suporte</p>
                </span>
                <!-- BOTÃO LOGOUT -->
                <span>
                    <form action="../data/DB_Logout.php" method="post">
                        <i class="material-icons" id="iconLogout">logout</i>
                        <p>Sair</p>
                    </form>
                </span>
            </div>
        </aside>
    </main>
</body>
</html>
