<?php
session_start();
require_once('../../../classes/Autoload.php');

header("Content-Type: application/json");

try {
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
    $codigo            = trim($_POST['codigo'] ?? '');
    $patrimonio = trim($_POST['patrimonio'] ?? '');
    $qt_atual             = trim($_POST['qt_atual'] ?? '');
    $qt_minima     = trim($_POST['qt_minima'] ?? '');
    $valor_custo       = trim($_POST['valor_custo'] ?? '');
    $valor_venda    = trim($_POST['valor_venda'] ?? '');
    $valor_aluguel        = trim($_POST['valor_aluguel'] ?? '');
    $valor_manutencao        = trim($_POST['valor_manutencao'] ?? '');

    // Valida ID da tarefa
    if ($id <= 0) {
        echo json_encode(["status" => "erro", "mensagem" => "ID do equipamento inválido."]);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    // Prepara a query
    $sql = "UPDATE cadastro_equipamento 
            SET nome = :nome,
                codigo = :codigo,
                patrimonio = :patrimonio,
                qt_atual = :qt_atual,
                qt_minima = :qt_minima,
                valor_custo = :valor_custo,
                valor_venda = :valor_venda,
                valor_aluguel = :valor_aluguel,
                valor_manutencao = :valor_manutencao
            WHERE equipamentos_id = :id";

    $stmt = $conn->prepare($sql);

    // Faz o bind dos parâmetros
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":codigo", $codigo);
    $stmt->bindParam(":patrimonio", $patrimonio);
    $stmt->bindParam(":qt_atual", $qt_atual);
    $stmt->bindParam(":qt_minima", $qt_minima);
    $stmt->bindParam(":valor_custo", $valor_custo);
    $stmt->bindParam(":valor_venda", $valor_venda);
    $stmt->bindParam(":valor_aluguel", $valor_aluguel);
    $stmt->bindParam(":valor_manutencao", $valor_manutencao);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Equipamento atualizada com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar equipamento."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro no banco de dados: " . $e->getMessage()]);
}
