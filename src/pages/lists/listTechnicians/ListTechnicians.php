<?php
session_start();
require_once('../../../classes/Autoload.php');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario']['usuario_id'])) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

$tecnicos = [];

try {
    $db = new Database();
    $conn = $db->getConnection();

   
    $stmt = $conn->prepare("SELECT * FROM cadastro_tecnico ORDER BY nome ASC");
    $stmt->execute();

    $tecnicos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro ao buscar técnicos: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Técnicos</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/listTechnicians/ListTechnicians.css?=1.2">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <main>
        <h1>Técnicos Cadastrados</h1>
        <?php if (!empty($mensagem)) : ?>
        <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>
    
    <?php if (empty($tecnicos)) : ?>
        <p>Nenhum técnico cadastrado.</p>
    <?php else : ?>
        <div class="tecnicos-container">
            <?php foreach ($tecnicos as $tecnico) : ?>
                <div class="tecnico-card">
                    <?php if (!empty($tecnico['imagem_url'])) : ?>
                        <img src="/gestaoStock/<?php echo htmlspecialchars($tecnico['imagem_url']); ?>" alt="Imagem de <?php echo htmlspecialchars($tecnico['nome']); ?>">
                    <?php else : ?>
                        <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                    <?php endif; ?>


                    <div class="tecnico-info">
                        <p><span>Nome:</span> <?php echo htmlspecialchars($tecnico['nome']); ?></p>
                        <p><span>Email:</span> <?php echo htmlspecialchars($tecnico['email']); ?></p>
                        <p><span>Telefone:</span> <?php echo htmlspecialchars($tecnico['telefone']); ?></p>
                        <p><span>Cidade:</span> <?php echo htmlspecialchars($tecnico['cidade']); ?></p>
                        <p><span>Estado:</span> <?php echo htmlspecialchars($tecnico['estado']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    </main>
</body>
</html>