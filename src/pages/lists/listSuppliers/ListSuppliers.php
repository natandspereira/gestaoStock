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
    <link rel="stylesheet" href="../assets/css/listSuppliers/listSuppliers.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/gestaoStock/src/pages/delete/delete.css?v=<?php echo time(); ?>">
</head>

<body>
    <h1>Fornecedores Cadastrados</h1>

    <?php if (!empty($mensagem)) : ?>
        <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <?php if (empty($suppliers)) : ?>
        <p>Nenhum equipamento cadastrado.</p>
    <?php else : ?>
        <div class="suppliers-container">
            <?php foreach ($suppliers  as $supplier) : ?>
                <div class="supplier-card">
                    <?php if (!empty($supplier['imagem_url'])) : ?>
                        <img src="/gestaoStock/<?php echo htmlspecialchars($supplier['imagem_url']); ?>" alt="Imagem do fornecedor">
                    <?php else : ?>
                        <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                    <?php endif; ?>


                    <div class="supplier-info">
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
                        <p><span>observacoes:</span> <?php echo htmlspecialchars($supplier['observacoes']); ?></p>
                    </div>

                    <!-- Botão Editar com IDs -->
                    <button class="btn-editar"
                        data-id="<?= (int)$supplier['fornecedor_id'] ?>"
                        data-razao_social="<?= htmlspecialchars($supplier['razao_social']); ?>"
                        data-nome_fantasia="<?= htmlspecialchars($supplier['nome_fantasia']); ?>"
                        data-cnpj="<?= htmlspecialchars($supplier['cnpj']); ?>"
                        data-inscricao_estadual="<?= htmlspecialchars($supplier['inscricao_estadual']); ?>"
                        data-telefone="<?= htmlspecialchars($supplier['telefone']); ?>"
                        data-email="<?= htmlspecialchars($supplier['email']); ?>"
                        data-cep="<?= htmlspecialchars($supplier['cep']); ?>"
                        data-endereco="<?= htmlspecialchars($supplier['endereco']); ?>"
                        data-bairro="<?= htmlspecialchars($supplier['bairro']); ?>"
                        data-cidade="<?= htmlspecialchars($supplier['cidade']); ?>"
                        data-estado="<?= htmlspecialchars($supplier['estado']); ?>"
                        data-numero="<?= htmlspecialchars($supplier['numero']); ?>"
                        data-complemento="<?= htmlspecialchars($supplier['complemento']); ?>"
                        data-observacoes="<?= htmlspecialchars($supplier['observacoes']); ?>">
                        Editar
                    </button>
                    <button onclick=" excluirFornecedor(<?php echo $supplier['fornecedor_id']; ?>)" class="btn-excluir">Excluir</button>
                </div>
            <?php endforeach; ?>
        </div>


        <!-- Modal -->
        <div id="modalEditarSuppliers">
            <div class="modal-contentSuppliers">
                <h2>Editar Fornecedor</h2>
                <input type="hidden" id="edit_id">
                <span><label>Razao Social:</label><input type="text" id="edit_razao_social"></span>
                <span><label>Nome Fantasia:</label><input type="text" id="edit_nome_fantasia"></span>
                <span><label>Cnpj:</label><input type="text" id="edit_cnpj"></span>
                <span><label>Inscricao Estadual:</label><input type="text" id="edit_inscricao_estadual"></span>
                <span><label>Telefone:</label><input type="text" id="edit_telefone"></span>
                <span><label>Email:</label><input type="text" id="edit_email"></span>
                <span><label>Cep:</label><input type="text" id="edit_cep"></span>
                <span><label>Endereco:</label><input type="text" id="edit_endereco"></span>
                <span><label>Bairro:</label><input type="text" id="edit_bairro"></span>
                <span><label>Cidade:</label><input type="text" id="edit_cidade"></span>
                <span><label>Estado:</label><input type="text" id="edit_estado"></span>
                <span><label>Numero:</label><input type="text" id="edit_numero"></span>
                <span><label>Complemento:</label><input type="text" id="edit_complemento"></span>
                <span><label>Observacoes:</label><input type="text" id="edit_observacoes"></span>

                <div class="btnModal">
                    <button onclick="salvarEdicaoFornecedor()">Salvar</button>
                    <button onclick="fecharModal()">Cancelar</button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</body>

</html>