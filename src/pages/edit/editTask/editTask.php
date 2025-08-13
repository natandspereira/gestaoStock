<?php
session_start();
require_once('../../../classes/Autoload.php');

header("Content-Type: application/json");

// Verifica autenticação
if (!isset($_SESSION['usuario']['usuario_id'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Usuário não autenticado."]);
    exit;
}

// Aceita apenas POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["status" => "erro", "mensagem" => "Método inválido."]);
    exit;
}

// Pega dados do POST e garante valores inteiros para ids
$id                 = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$nome               = trim($_POST['nome'] ?? '');
$prazo              = trim($_POST['prazo'] ?? '');
$quantidade_reparos = trim($_POST['quantidade_reparos'] ?? '');
$status             = trim($_POST['status'] ?? '');
$data_conclusao     = trim($_POST['data_conclusao'] ?? '');
$categoria_id       = isset($_POST['categoria_id']) ? (int)$_POST['categoria_id'] : null;
$equipamentos_id    = isset($_POST['equipamentos_id']) ? (int)$_POST['equipamentos_id'] : null;
$observacoes        = trim($_POST['observacoes'] ?? '');

// Valida ID da tarefa
if ($id <= 0) {
    echo json_encode(["status" => "erro", "mensagem" => "ID da tarefa inválido."]);
    exit;
}

// Valida categoria e equipamento antes de atualizar
try {
    $db = new Database();
    $conn = $db->getConnection();

    // Checa se categoria existe
    if ($categoria_id) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cadastro_categoria WHERE categoria_id = :id");
        $stmt->bindParam(":id", $categoria_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(["status" => "erro", "mensagem" => "Categoria inválida."]);
            exit;
        }
    }

    // Checa se equipamento existe
    if ($equipamentos_id) {
        $stmt = $conn->prepare("SELECT COUNT(*) FROM cadastro_equipamento WHERE equipamentos_id = :id");
        $stmt->bindParam(":id", $equipamentos_id, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->fetchColumn() == 0) {
            echo json_encode(["status" => "erro", "mensagem" => "Equipamento inválido."]);
            exit;
        }
    }

    // Prepara a query
    $sql = "UPDATE cadastro_tarefas 
            SET nome = :nome,
                prazo = :prazo,
                quantidade_reparos = :quantidade_reparos,
                status = :status,
                data_conclusao = :data_conclusao,
                categoria_id = :categoria_id,
                equipamentos_id = :equipamentos_id,
                observacoes = :observacoes
            WHERE tarefas_id = :id";

    $stmt = $conn->prepare($sql);

    // Faz o bind dos parâmetros
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":prazo", $prazo);
    $stmt->bindParam(":quantidade_reparos", $quantidade_reparos);
    $stmt->bindParam(":status", $status);
    $stmt->bindParam(":data_conclusao", $data_conclusao);
    $stmt->bindParam(":categoria_id", $categoria_id, PDO::PARAM_INT);
    $stmt->bindParam(":equipamentos_id", $equipamentos_id, PDO::PARAM_INT);
    $stmt->bindParam(":observacoes", $observacoes);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Tarefa atualizada com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar tarefa."]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro no banco de dados: " . $e->getMessage()]);
}
