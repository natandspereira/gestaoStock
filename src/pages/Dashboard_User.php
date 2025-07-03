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
            <!-- PERFIL -->
            <label for="">
                <i class="material-icons" id="iconPerfil">account_box</i>
                <p>Perfil</p>
            </label>
            <!-- CLIENTES -->
            <label for="">
                <i class="material-icons" id="iconClientes">group</i>
                <p>Clientes</p>
            </label>
            <!-- FORNECEDORES -->
            <label for="">
                <i class="material-icons" id="iconClientes">box</i>
                <p>Fornecedores</p>
            </label>
            <!-- TECNICOS -->
            <label for="">
                <i class="material-icons" id="iconClientes">groups_2</i>
                <p>Tecnicos</p>
            </label>
            <!-- EQUIPAMENTOS -->
            <label for="">
                <i class="material-icons" id="iconClientes">construction</i>
                <p>Equipamentos</p>
            </label>
            <!-- SUPORTE -->
            <label for="">
                <i class="material-icons" id="iconClientes">support_agent</i>
                <p>Suporte</p>
            </label>
            <!-- BOTÃO LOGOUT -->
            <label for="">
                <form action="../data/DB_Logout.php" method="post">
                    <i class="material-icons" id="iconClientes">logout</i>
                    <p>Sair</p>
                </form>
            </label>
        </aside>
    </main>
</body>
</html>
