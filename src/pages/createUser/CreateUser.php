<?php 
require_once '../../classes/Autoload.php';

// Instancia o banco de dados
$db = new Database();

// Obtém a conexão PDO
$pdo = $db->getConnection();

// Instancia a classe de criação de usuário com o PDO
$createUser = new CreateUser($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $createUser = new CreateUser($pdo);
        $createUser->newUser($_POST, $_FILES);

        echo "<script>
            alert('Usuário criado com sucesso!');
            window.location.href = 'User.php';
        </script>";
        exit;

    } catch (Exception $e) {
        echo "<script>alert('" . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <!-- LINK CSS -->
     <link rel="stylesheet" href="../../assets/css/createUser/CreateUser.css">
    <!-- LINK FAVICON -->
     <link rel="shortcut icon" href="../../assets/img/favicon_logo.ico" type="image/x-icon">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../../assets/img/logo.png" alt="logo">
        </div>
    </header>
    <!-- FORMULÁRIO -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container">
            <h3>Criar conta</h3>
            <p>Preencha o formulário abaixo para criar sua conta</p>
            <input type="text" name="nome" placeholder="seu nome" required>
            <input type="password" name="senha" placeholder="nova senha" required>
            <input type="password" name="confirmar_senha" placeholder="confirmar senha" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="text" name="matricula" placeholder="matricula" required>
            <input type="file" name="image" accept="image/*">
            <span>
                <input type="checkbox" id="inputCheckBox" required>
                <p>Li e concordo com os Termos de uso</p>
            </span>
            <button id="btnCadastrar">cadastrar</button>
            <button id="btnSair" formaction="../../../index.php" formnovalidate>sair</button>
        </div>
    </form>
</body>
</html>