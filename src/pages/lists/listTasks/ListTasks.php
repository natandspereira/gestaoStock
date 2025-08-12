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

    // JOIN para pegar as informações do equipamento (incluindo imagem_url)
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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas</title>
    <link rel="stylesheet" href="../assets/css/listTask/listTask.css">
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
                    <?php if (!empty($task['imagem_url'])) : ?>
                        <img src="/gestaoStock/<?= htmlspecialchars($task['imagem_url']); ?>" alt="Imagem do equipamento">
                    <?php else : ?>
                        <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                    <?php endif; ?>

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
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>
</html>
