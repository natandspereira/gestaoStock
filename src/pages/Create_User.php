<?php 
include __DIR__ . '/../data/DB.php';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <!-- LINK CSS -->
     <link rel="stylesheet" href="../assets/css/Create_User.css">
    <!-- LINK FAVICON -->
     <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../assets/img/logo.svg" alt="logo">
        </div>
    </header>
    <!-- FORMULÁRIO -->
    <form action="" method="post">
        <div class="container">
            <h3>Criar conta</h3>
            <p>Preencha o formulário abaixo para criar sua conta</p>
            <input type="text" name="nome" placeholder="seu nome completo" required>
            <input type="password" name="senha" placeholder="nova senha" required>
            <input type="password" name="confirmar_senha" placeholder="confirmar a nova senha" required>
            <input type="email" name="email" placeholder="informe o seu email" required>
            <input type="text" name="matricula" placeholder="matricula" required>
            <input type="file" name="imagem_url">
            <span>
                <input type="checkbox" id="inputCheckBox" required>
                <p>Li e concordo com os Termos de uso</p>
            </span>
            <button id="btnCadastrar">cadastrar</button>
            <button id="btnSair">sair</button>
        </div>
    </form>
</body>
</html>