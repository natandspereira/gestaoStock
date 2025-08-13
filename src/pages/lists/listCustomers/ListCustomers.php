<?php
session_start();
require_once('../../../classes/Autoload.php');

// Se não autenticado, retorna JSON para o JS tratar
if (!isset($_SESSION['usuario']['usuario_id'])) {
    header("Content-Type: application/json");
    echo json_encode(["status" => "erro", "mensagem" => "Usuário não autenticado."]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM cadastro_clientes ORDER BY nome ASC");
    $stmt->execute();
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    header("Content-Type: application/json");
    echo json_encode(["status" => "erro", "mensagem" => "Erro ao buscar clientes: " . $e->getMessage()]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes Cadastrados</title>
    <link rel="stylesheet" href="../assets/css/listCustomers/ListCustomers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/gestaoStock/src/pages/delete/delete.css?v=<?php echo time(); ?>">
</head>

<body>
    <main>
        <h1>Clientes Cadastrados</h1>
        <div class="clientes-container">
            <?php if (empty($clientes)) : ?>
                <p id="msgNenhum">Nenhum cliente cadastrado.</p>
            <?php endif; ?>
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

                    <button onclick="excluirCliente(<?php echo $cliente['clientes_id']; ?>)" class="btn-excluir">Excluir</button>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>

</html>