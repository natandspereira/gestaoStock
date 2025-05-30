<?php 

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoStock</title>
    <!-- LINK CSS -->
     <link rel="stylesheet" href="./src/assets/css/index.css">
</head>
<body>
    <!-- LOGIN -->
    <div class="login">
        <div class="logo">
            <img src="./src/assets/img/logo.svg" alt="logo">
        </div>
       <div class="userAndPassword">
             <input type="text" placeholder="Usuário" required>
             <input type="password" placeholder="Senha" required>
       </div>
       <div class="btnLogin">
            <button id="toEnter">entrar</button>
            <button id="register">cadastrar</button>
       </div>
       <p>Esqueceu sua senha?<a href="#">Recupere sua senha aqui</a></p>
    </div>
</body>
</html>