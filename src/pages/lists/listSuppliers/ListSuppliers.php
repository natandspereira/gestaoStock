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

$suppliers = [];

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM cadastro_fornecedor ORDER BY nome_fantasia ASC");
    $stmt->execute();

    $suppliers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro ao buscar fornecedor: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fornecedores</title>
    <link rel="stylesheet" href="../assets/css/listSuppliers/listSuppliers.css">
</head>

<body>
    <h1>Fornecedores Cadastrados</h1>

    <?php if (!empty($mensagem)) : ?>
        <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <?php if (empty($suppliers )) : ?>
        <p>Nenhum equipamento cadastrado.</p>
    <?php else : ?>
         <div class="equips-container">
            <?php foreach ($suppliers  as $supplier) : ?>
                <div class="equip-card">
                    <?php if (!empty($supplier['imagem_url'])) : ?>
                        <img src="/gestaoStock/<?php echo htmlspecialchars($supplier['imagem_url']); ?>" alt="Imagem do fornecedor">
                    <?php else : ?>
                        <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                    <?php endif; ?>


                    <div class="equip-info">
                        <p><span>Razão Social:</span> <?php echo htmlspecialchars($supplier['razao_social']); ?></p>
                        <p><span>Nome Fantasia:</span> <?php echo htmlspecialchars($supplier['nome_fantasia']); ?></p>
                        <p><span>Cnpj:</span> <?php echo htmlspecialchars($supplier['cnpj']); ?></p>
                        <p><span>Inscrição Estadual:</span> <?php echo htmlspecialchars($supplier['inscricao_estadual']); ?></p>
                        <p><span>Telefone:</span> <?php echo htmlspecialchars($supplier['telefone']); ?></p>
                        <p><span>Email:</span> <?php echo htmlspecialchars($supplier['email']); ?></p>
                        <p><span>Cep:</span> <?php echo htmlspecialchars($supplier['cep']); ?></p>
                        <p><span>Endereço:</span> <?php echo htmlspecialchars($supplier['endereco']); ?></p>
                        <p><span>Bairro:</span> <?php echo htmlspecialchars($supplier['bairro']); ?></p>
                        <p><span>Cidade:</span> <?php echo htmlspecialchars($supplier['cidade']); ?></p>
                        <p><span>Estado:</span> <?php echo htmlspecialchars($supplier['estado']); ?></p>
                        <p><span>Numero:</span> <?php echo htmlspecialchars($supplier['numero']); ?></p>
                        <p><span>Complemento:</span> <?php echo htmlspecialchars($supplier['complemento']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>

</html>