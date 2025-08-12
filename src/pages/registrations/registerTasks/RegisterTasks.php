<?php
session_start();
require_once('../../../classes/Autoload.php');

$usuario_id = $_SESSION['usuario']['usuario_id'] ?? null;

if (!$usuario_id) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}

// MENSAGEM
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

// CONEXÃO COM BANCO
try {
    $db = new Database();
    $conn = $db->getConnection();
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

// CARREGA VALORES DO ENUM DE STATUS
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

// CARREGA CATEGORIAS
try {
    $categorias = $conn->query("SELECT categoria_id, nome FROM cadastro_categoria ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $categorias = [];
}

// CARREGA EQUIPAMENTOS
try {
    $equipamentos = $conn->query("SELECT equipamentos_id, nome FROM cadastro_equipamento ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $equipamentos = [];
}

// INSERÇÃO DE NOVA TAREFA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $prazo = $_POST['prazo'] ?? null;
    $quantidade_reparos = $_POST['quantidade_reparos'] ?? null;
    $status = $_POST['status'] ?? '';
    $data_conclusao = $_POST['data_conclusao'] ?? null;
    $observacoes = $_POST['observacoes'] ?? '';
    $categoria_id = $_POST['categoria_id'] ?? null;
    $equipamentos_id = $_POST['equipamentos_id'] ?? null;

    //VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    if ($nome === '' || $prazo === '' || $status === '' || $equipamentos_id  === '') {
        $_SESSION['mensagem'] = "Os campos nome, prazo, status e equipamento são obrigatórios.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    try {
        $sql = "INSERT INTO cadastro_tarefas 
            (nome, prazo, quantidade_reparos, status, data_conclusao, observacoes, data_criacao, categoria_id, equipamentos_id, usuario_id) 
            VALUES 
            (:nome, :prazo, :quantidade_reparos, :status, :data_conclusao, :observacoes, NOW(), :categoria_id, :equipamentos_id, :usuario_id)";

        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nome' => $nome,
            ':prazo' => $prazo,
            ':quantidade_reparos' => $quantidade_reparos,
            ':status' => $status,
            ':data_conclusao' => $data_conclusao,
            ':observacoes' => $observacoes,
            ':categoria_id' => $categoria_id,
            ':equipamentos_id' => $equipamentos_id,
            ':usuario_id' => $usuario_id
        ]);

        $_SESSION['mensagem'] = "Tarefa cadastrada com sucesso!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro ao cadastrar tarefa: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Tarefas</title>
    <link rel="stylesheet" href="../../../assets/css/registerTasks/RegisterTasks.css?=1.2">
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <?php if (!empty($mensagem)) : ?>
            <div class="mensagem <?php echo (stripos($mensagem, 'sucesso') !== false ? 'sucesso' : 'error') ?>">
                <?php echo htmlspecialchars($mensagem); ?>
            </div>
            <script>
                setTimeout(() => {
                    const msg = document.querySelector('.mensagem');
                    if (msg) msg.remove();
                }, 3000);
            </script>
    <?php endif; ?>

    <form method="POST">
        <h1>Cadastrar Nova Tarefa</h1>
        <input type="text" name="nome" placeholder="Nome da Tarefa">
        <input type="date" name="prazo" placeholder="Prazo">
        <input type="number" name="quantidade_reparos" min="0" placeholder="Quantidade de Reparos">

        <select name="status" required>
            <option value="">-- Status --</option>
            <?php foreach ($especialidades as $status): ?>
                <option value="<?= htmlspecialchars($status) ?>"><?= ucfirst($status) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="date" name="data_conclusao" placeholder="Data de Conclusão">


        <select name="categoria_id" required>
            <option value="">-- Categoria --</option>
            <?php foreach ($categorias as $cat): ?>
                <option value="<?= $cat['categoria_id'] ?>"><?= htmlspecialchars($cat['nome']) ?></option>
            <?php endforeach; ?>
        </select>

        <select name="equipamentos_id" required>
            <option value="">-- Equipamento --</option>
            <?php foreach ($equipamentos as $equip): ?>
                <option value="<?= $equip['equipamentos_id'] ?>"><?= htmlspecialchars($equip['nome']) ?></option>
            <?php endforeach; ?>
        </select>
        <textarea name="observacoes" placeholder="Observações"></textarea>
        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>