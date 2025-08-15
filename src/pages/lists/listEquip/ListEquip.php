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

$equips = [];

try {
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM cadastro_equipamento ORDER BY nome ASC");
    $stmt->execute();

    $equips = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro ao buscar técnicos: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/listEquip/ListEquip.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/gestaoStock/src/pages/delete/delete.css?v=<?php echo time(); ?>">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</head>

<body>
    <h1>Equipamentos Cadastrados</h1>

    <?php if (!empty($mensagem)) : ?>
        <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <?php if (empty($equips)) : ?>
        <p>Nenhum equipamento cadastrado.</p>
    <?php else : ?>
        <div class="equips-container">
            <?php foreach ($equips as $equip) : ?>
                <div class="equip-card">
                    <?php if (!empty($equip['imagem_url'])) : ?>
                        <img src="/gestaoStock/<?php echo htmlspecialchars($equip['imagem_url']); ?>" alt="Imagem de <?php echo htmlspecialchars($equip['nome']); ?>">
                    <?php else : ?>
                        <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                    <?php endif; ?>


                    <div class="equip-info">
                        <p><span>Nome:</span> <?php echo htmlspecialchars($equip['nome']); ?></p>
                        <p><span>Código:</span> <?php echo htmlspecialchars($equip['codigo']); ?></p>
                        <p><span>Patrimonio:</span> <?php echo htmlspecialchars($equip['patrimonio']); ?></p>
                        <p><span>Quantidade Atual:</span> <?php echo htmlspecialchars($equip['qt_atual']); ?></p>
                        <p><span>Quantidade Minima:</span> <?php echo htmlspecialchars($equip['qt_minima']); ?></p>
                        <p><span>Valor de Custo:</span> <?php echo htmlspecialchars($equip['valor_custo']); ?></p>
                        <p><span>Valor de Venda:</span> <?php echo htmlspecialchars($equip['valor_venda']); ?></p>
                        <p><span>Valor de Aluguel:</span> <?php echo htmlspecialchars($equip['valor_aluguel']); ?></p>
                        <p><span>Valor de Manuntenção:</span> <?php echo htmlspecialchars($equip['valor_manutencao']); ?></p>
                    </div>

                     <!-- Botão Editar com IDs -->
                <button class="btn-editar"
                    data-id="<?= (int)$equip['equipamentos_id'] ?>"
                    data-nome="<?= htmlspecialchars($equip['nome']); ?>"
                    data-codigo="<?= htmlspecialchars($equip['codigo']); ?>"
                    data-patrimonio="<?= htmlspecialchars($equip['patrimonio']); ?>"
                    data-qt_atual="<?= htmlspecialchars($equip['qt_atual']); ?>"
                    data-qt_minima="<?= htmlspecialchars($equip['qt_minima']); ?>"
                    data-valor_custo="<?= htmlspecialchars($equip['valor_custo']); ?>"
                    data-valor_venda="<?= htmlspecialchars($equip['valor_venda']); ?>"
                    data-valor_aluguel="<?= htmlspecialchars($equip['valor_aluguel']); ?>"
                    data-valor_manutencao="<?= htmlspecialchars($equip['valor_manutencao']); ?>">
                    Editar
                </button>        

                    <button onclick="excluirEquip(<?php echo $equip['equipamentos_id']; ?>)" class="btn-excluir">Excluir</button>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Modal -->
    <div id="modalEditar">
        <div class="modal-content">
            <h2>Editar Equipamento</h2>
            <input type="hidden" id="edit_id">
            <span><label>Nome:</label><input type="text" id="edit_nome"></span>
            <span><label>Codigo:</label><input type="text" id="edit_codigo"></span>
            <span><label>Patrimonio:</label><input type="text" id="edit_patrimonio"></span>
            <span><label>Quantidade Atual:</label><input type="text" id="edit_qt_atual"></span>
            <span><label>Quantidade Minima:</label><input type="text" id="edit_qt_minima"></span>
            <span><label>Valor de Custo:</label><input type="text" id="edit_valor_custo"></span>
            <span><label>Valor de Venda:</label><input type="text" id="edit_valor_venda"></span>
            <span><label>Valor de Aluguel:</label><input type="text" id="edit_valor_aluguel"></span>
            <span><label>Valor de Manuntenção:</label><input type="text" id="edit_valor_manutencao"></span>
            <button onclick="salvarEdicaoEquip()">Salvar</button>
            <button onclick="fecharModal()">Cancelar</button>
        </div>
    </div>
    <?php endif; ?>
</body>

</html>