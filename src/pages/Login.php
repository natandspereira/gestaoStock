<?php
require_once '../classes/Autoload.php';
session_start();

// Verifica se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $matricula = $_POST['matricula'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // Instancia a classe Login
    $login = new Login();

    // Chama o método de autenticação e passa os dados do formulário
    $resultado = $login->autenticar($matricula, $senha);

    // Verifica o resultado do login
    if (isset($resultado['sucesso']) && $resultado['sucesso'] === true) {
        // Redireciona para a página após o login bem-sucedido
        echo "<script>
                window.open('../pages/User.php', '_blank'); // ABRE A PÁGINA EM OUTRA ABA
                var modal = window.parent.document.getElementById('loginModal'); // ACESSA O MODAL DA PÁGINA PRINCIPAL
                if (modal) {
                    modal.style.display = 'none'; // FECHA O MODAL
                }
              </script>";
        exit();
    } else {
        // Caso haja erro, redireciona para a página de login com a mensagem de erro
        header('Location: ../pages/Login.php?erro=1');
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/Login.css">
    <!-- SCRIPT BTN CADASTRO -->
     <script src="../scripts/BtnCadastro.js" defer></script>
    
</head>

<body>
    <div class="logo">
        <img src="../assets/img/logo.png" alt="Logo">
    </div>
    <form action="" method="POST">
        <h1>Acessar Conta</h1>
        <p>Bem vindo! Faça login para gerenciar seu estoque</p>
        <div class="inputsLogin">
            <label for="matricula">
                <i class="material-icons" id="iconCircle">account_circle</i>
                <input type="text" id="matricula" name="matricula" placeholder="Matricula" required>
            </label>
            <label for="senha">
                <i class="material-icons" id="iconCircle">lock</i>
                <input type="password" id="senha" name="senha" placeholder="Senha" required>
            </label>
            <button type="submit" id="entrar">entrar</button>
            <button type="button" id="btnCadastro">cadastro</button>
            <p>Esqueceu sua senha?<span>Recupere a sua senha aqui</span></p>
        </div>
    </form>
</body>

</html>