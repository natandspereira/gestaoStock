<?php

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato</title>
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/Form.css">
</head>

<body>
    <div class="logo">
        <img src="../assets/img/logo.png" alt="Logo">
    </div>
    <form action="" method="POST">
        <h1>Entre em contato</h1>
        <div class="inputsContact">
            <label for="nome">
                <i class="material-icons" id="iconName">account_circle</i>
                <input type="text" id="nome" name="nome" placeholder="Nome" required>
            </label>
            <label for="email">
                <i class="material-icons" id="iconEmail">alternate_email</i>
                <input type="email" id="email" name="email" placeholder="E-mail" required>
            </label>
            <label for="telefone">
                <i class="material-icons" id="iconTelephone">contact_phone</i>
                <input type="tel" id="telefone" name="telefone" placeholder="Telefone">
            </label>
            <label for="mensagem">
                <textarea id="mensagem" name="mensagem" rows="10" placeholder="Mensagem" required></textarea>
            </label>
            <button type="submit">Enviar</button>
        </div>
    </form>
</body>

</html>