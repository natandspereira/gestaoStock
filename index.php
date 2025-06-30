<?php 
// include __DIR__ . '/src/pages/Create_User.php';
?>



<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoStock</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="./src/assets/css/Index.css">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="./src/assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    <!-- FORM LOGIN -->
    <form action="" method="post">
        <div class="container">
            <img src="./src/assets/img/logo.svg" alt="logo">
            <p>Bem-vindo! Faça login para gerenciar seu estoque</p>
            <!-- INPUT USUÁRIO -->
              <div class="inputUsuario">
                <label id="nome">
                    <i class="material-icons" id="iconAccount">account_circle</i>
                    <input type="text" name="nome" id="nome" placeholder="Usuário">
                </label>
              </div>
            <!-- INPUT SENHA   -->
              <div class="inputSenha">
                <label id="senha">
                    <i class="material-icons" id="iconLock">lock</i>
                    <input type="password" name="senha" id="senha" placeholder="Senha">
                </label>
              </div>  
            <!-- BOTÃO -->
            <div class="btnLogin">
                <button type="submit" id="btnEntrar">entrar</button>
                <a href="./src/pages/Create_User.php">
                    <button type="button" id="btnCadastro">cadastro</button>
                </a>
            </div>
            <p>Esqueceu sua senha? <a href="#">Recupera sua senha aqui.</a></p>
        </div>
    </form>
</body>
</html>