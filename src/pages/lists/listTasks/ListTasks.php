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

$tasks = [];
try {
    $db = new Database();
    $conn = $db->getConnection();

    // JOIN para pegar informações do equipamento e categoria
    $sql = "
        SELECT t.*, e.imagem_url, c.nome AS categoria_nome, e.nome AS equipamento_nome
        FROM cadastro_tarefas t
        LEFT JOIN cadastro_categoria c ON c.categoria_id = t.categoria_id
        LEFT JOIN cadastro_equipamento e ON e.equipamentos_id = t.equipamentos_id
        ORDER BY t.nome ASC
    ";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $mensagem = "Erro ao buscar tarefas: " . $e->getMessage();
}

// ENUM status
$especialidades = [];
try {
    $sql = "
        SELECT COLUMN_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'cadastro_tarefas'
          AND COLUMN_NAME = 'status'
    ";
    $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $str = str_replace(["enum(", ")", "'"], "", $row['COLUMN_TYPE']);
        $especialidades = explode(",", $str);
    }
} catch (PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao carregar status: " . $e->getMessage();
}

// Categorias
try {
    $categorias = $conn->query("SELECT categoria_id, nome FROM cadastro_categoria ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categorias = [];
}

// Equipamentos
try {
    $equipamentos = $conn->query("SELECT equipamentos_id, nome FROM cadastro_equipamento ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $equipamentos = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas</title>
    <link rel="stylesheet" href="../assets/css/listTask/listTask.css">
    <link rel="stylesheet" href="/gestaoStock/src/pages/delete/delete.css?v=<?php echo time(); ?>">
</head>
<body>
<h1>Tarefas Cadastradas</h1>

<?php if (!empty($mensagem)) : ?>
    <div class="mensagem"><?= htmlspecialchars($mensagem); ?></div>
<?php endif; ?>

<?php if (empty($tasks)) : ?>
    <p>Nenhuma tarefa cadastrada.</p>
<?php else : ?>
    <div class="tasks-container">
        <?php foreach ($tasks as $task) : ?>
            <div class="task-card">
                <img src="/gestaoStock/<?= !empty($task['imagem_url']) ? htmlspecialchars($task['imagem_url']) : 'assets/img/default-user.png' ?>" alt="Imagem do equipamento">

                <div class="task-info">
                    <p><span>Nome:</span> <?= htmlspecialchars($task['nome']); ?></p>
                    <p><span>Prazo:</span> <?= htmlspecialchars($task['prazo']); ?></p>
                    <p><span>Quantidade de Reparos:</span> <?= htmlspecialchars($task['quantidade_reparos']); ?></p>
                    <p><span>Status:</span> <?= htmlspecialchars($task['status']); ?></p>
                    <p><span>Data de Conclusão:</span> <?= htmlspecialchars($task['data_conclusao']); ?></p>
                    <p><span>Categoria:</span> <?= htmlspecialchars($task['categoria_nome'] ?? ''); ?></p>
                    <p><span>Equipamento:</span> <?= htmlspecialchars($task['equipamento_nome'] ?? ''); ?></p>
                    <p><span>Observações:</span> <?= htmlspecialchars($task['observacoes']); ?></p>
                </div>

                <!-- Botão Editar com IDs -->
                <button class="btn-editar"
                    data-id="<?= (int)$task['tarefas_id'] ?>"
                    data-nome="<?= htmlspecialchars($task['nome']); ?>"
                    data-prazo="<?= htmlspecialchars($task['prazo']); ?>"
                    data-quantidade_reparos="<?= htmlspecialchars($task['quantidade_reparos']); ?>"
                    data-status="<?= htmlspecialchars($task['status']); ?>"
                    data-data_conclusao="<?= htmlspecialchars($task['data_conclusao']); ?>"
                    data-categoria_id="<?= htmlspecialchars($task['categoria_id']); ?>"
                    data-equipamentos_id="<?= htmlspecialchars($task['equipamentos_id']); ?>"
                    data-observacoes="<?= htmlspecialchars($task['observacoes']); ?>">
                    Editar
                </button>

                <button id="btnDelete" onclick="excluirTarefa(<?= $task['tarefas_id'] ?>)" class="btn-excluir">Excluir</button>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Modal -->
    <div id="modalEditar">
        <div class="modal-content">
            <h2>Editar Tarefas</h2>
            <input type="hidden" id="edit_id">

            <span><label>Nome:</label><input type="text" id="edit_nome"></span>
            <span><label>Prazo:</label><input type="text" id="edit_prazo"></span>
            <span><label>Quantidade de Reparos:</label><input type="text" id="edit_quantidade_reparos"></span>
            <span><label>Data de Conclusão:</label><input type="text" id="edit_data_conclusao"></span>
            <span><label>Observação:</label><input type="text" id="edit_observacoes"></span>

            <select id="edit_status" required>
                <option value="">-- Status --</option>
                <?php foreach ($especialidades as $status): ?>
                    <option value="<?= htmlspecialchars($status) ?>"><?= ucfirst($status) ?></option>
                <?php endforeach; ?>
            </select>

            <select id="edit_categoria_id" required>
                <option value="">-- Categoria --</option>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['categoria_id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
                <?php endforeach; ?>
            </select>

            <select id="edit_equipamentos_id" required>
                <option value="">-- Equipamento --</option>
                <?php foreach ($equipamentos as $equip): ?>
                    <option value="<?= $equip['equipamentos_id'] ?>"><?= htmlspecialchars($equip['nome']) ?></option>
                <?php endforeach; ?>
            </select>

            <button onclick="salvarEdicaoTarefa()">Salvar</button>
            <button onclick="fecharModal()">Cancelar</button>
        </div>
    </div>
<?php endif; ?>
</body>
</html>
