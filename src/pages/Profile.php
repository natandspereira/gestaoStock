<?php
require_once '../classes/Autoload.php';

//INSTANCIA O BANCO DE DADOS
$db = new Database();

//OBTÉM A CONEXÃO PDO
$pdo = $db->getConnection();

// PREPARA A CONSULTA SQL
$sql = "SELECT * FROM usuarios";
$stmt = $pdo->prepare($sql);

// EXECUTA A CONSULTA
$stmt->execute();

// OBTÉM OS RESULTADOS
$usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <!-- LINK CSS  -->
    <link rel="stylesheet" href="../assets/css/Profile.css">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>

    <?php foreach ($usuarios as $usuario): ?>
         $temImagem = !empty($usuario['imagem_url']) && file_exists('uploads/' . $usuario['imagem_url']);
         $imagem = $temImagem ? 'uploads/' . htmlspecialchars($usuario['imagem_url']) : 'img/default.png';
        <div id="container">
            <div id="dataUser">
                <div id="imgUser">
                    <img src="<?= htmlspecialchars($usuario['imagem_url']); ?>" alt="Imagem do usuário" />
                </div>
                <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']); ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
                <p><strong>Senha:</strong> <?= str_repeat('*', min(strlen($usuario['senha']), 10)); ?></p>
            </div>
            <!-- FORMULARIO    -->
            <form action="">
                <input type="text" placeholder="Nome">
                <input type="password" placeholder="Senha">
                <input type="password" placeholder="Confirmar senha">
            </form>
            <button>update</button>
        <?php endforeach; ?>


</body>

</html>