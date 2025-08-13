<?php
session_start();
require_once('../../../classes/Autoload.php');

$especialidades = [];
try {
    $db = new Database();
    $conn = $db->getConnection();
    $sql = "
        SELECT COLUMN_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'cadastro_tecnico'
          AND COLUMN_NAME = 'tp_tecnico'
    ";
    $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $str = $row['COLUMN_TYPE']; // ex: enum('Eletricista','Hidráulico','Mecânico','TI')
        $str = str_replace(["enum(", ")", "'"], "", $str);
        $especialidades = explode(",", $str);
    }
} catch (PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao carregar especialidades: " . $e->getMessage();
}

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
    <link rel="stylesheet" href="../assets/css/listTechnicians/ListTechnicians.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="/gestaoStock/src/pages/delete/delete.css?v=<?php echo time(); ?>">
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
                            <p><span>Especialidade:</span> <?php echo htmlspecialchars($tecnico['tp_tecnico']); ?></p>
                        </div>
                        <button class="btn-editar"
                            data-id="<?= (int) $tecnico['tecnico_id'] ?>"
                            data-nome="<?= htmlspecialchars($tecnico['nome'] ?? '') ?>"
                            data-email="<?= htmlspecialchars($tecnico['email'] ?? '') ?>"
                            data-telefone="<?= htmlspecialchars($tecnico['telefone'] ?? '') ?>"
                            data-cidade="<?= htmlspecialchars($tecnico['cidade'] ?? '') ?>"
                            data-estado="<?= htmlspecialchars($tecnico['estado'] ?? '') ?>"
                            data-especialidade="<?= htmlspecialchars($tecnico['tp_tecnico'] ?? '') ?>">
                            Editar
                        </button>
                        <button onclick="excluirTecnico(<?php echo $tecnico['tecnico_id']; ?>)" class="btn-excluir">Excluir</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <!-- Modal de edição -->
        <div id="modalEditar">
            <div class="modal-content">
                <h2>Editar Cliente</h2>
                <input type="hidden" id="edit_id">
                <span>
                    <label>Nome:</label>
                    <input type="text" id="edit_nome">
                </span>
                <span>
                    <label>Email:</label>
                    <input type="text" id="edit_email">
                </span>
                <span>
                    <label>Telefone:</label>
                    <input type="text" id="edit_telefone">
                </span>
                <span>
                    <label>Cidade:</label>
                    <input type="text" id="edit_cidade">
                </span>
                <span>
                    <label>Estado:</label>
                    <input type="text" id="edit_estado">
                </span>

                <label for="edit_especialidade">Especialidade:</label>
                <select id="edit_especialidade" name="especialidade">
                    <option value="">Selecione</option>
                    <?php foreach ($especialidades as $esp): ?>
                        <option value="<?= htmlspecialchars($esp) ?>"><?= htmlspecialchars($esp) ?></option>
                    <?php endforeach; ?>
                </select>

                <button onclick="salvarEdicaoTecnico()">Salvar</button>
                <button onclick="fecharModal()">Cancelar</button>
            </div>
        </div>
    </main>
</body>

</html>