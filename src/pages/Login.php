<?php 
include '../data/DB_Login.php';
?>



<!DOCTYPE html>
<html lang="">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/Login.css">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>
<body>
    <!-- FORM LOGIN -->
    <form action="" method="post">
        <div class="container">
            <img src="../assets/img/logo.svg" alt="logo">
            <p>Bem-vindo! Faça login para gerenciar seu estoque</p>
            <!-- INPUT USUÁRIO -->
              <div class="inputUsuario">
                <label id="matricula">
                    <i class="material-icons" id="iconAccount">account_circle</i>
                    <input type="text" name="matricula" id="matricula" placeholder="Usuário">
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
                <a href="Create_User.php">
                    <button type="button" id="btnCadastro">cadastro</button>
                </a>
            </div>
            <p>Esqueceu sua senha? <a href="#">Recupera sua senha aqui.</a></p>
        </div>
    </form>
</body>
</html>