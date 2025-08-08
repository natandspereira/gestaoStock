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

$clientes = [];

try {
    $db = new Database();
    $conn = $db->getConnection();

    // Pega todos os clientes, independente do usuário
    $stmt = $conn->prepare("SELECT * FROM cadastro_clientes ORDER BY nome ASC");
    $stmt->execute();

    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro ao buscar clientes: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Todos os Clientes Cadastrados</title>
    <link rel="stylesheet" href="../assets/css/listCustomers/ListCustomers.css">
</head>

<body>
    <main>
        <h1>Todos os Clientes</h1>

        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>

        <?php if (empty($clientes)) : ?>
            <p>Nenhum cliente cadastrado ainda.</p>
        <?php else : ?>
            <div class="clientes-container">
                <?php foreach ($clientes as $cliente) : ?>
                    <div class="cliente-card">
                         <?php if (!empty($cliente['imagem_url'])) : ?>
                                <img src="/gestaoStock/<?php echo htmlspecialchars($cliente['imagem_url']); ?>" alt="Imagem de <?php echo htmlspecialchars($cliente['nome']); ?>">
                            <?php else : ?>
                                <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                            <?php endif; ?>


                        <div class="cliente-info">
                            <p><span>Nome:</span> <?php echo htmlspecialchars($cliente['nome']); ?></p>
                            <p><span>CPF/CNPJ:</span> <?php echo htmlspecialchars($cliente['cpf_cnpj']); ?></p>
                            <p><span>Email:</span> <?php echo htmlspecialchars($cliente['email']); ?></p>
                            <p><span>Telefone:</span> <?php echo htmlspecialchars($cliente['telefone']); ?></p>
                            <p><span>Cidade:</span> <?php echo htmlspecialchars($cliente['cidade']); ?></p>
                            <p><span>Estado:</span> <?php echo htmlspecialchars($cliente['estado']); ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</body>

</html>