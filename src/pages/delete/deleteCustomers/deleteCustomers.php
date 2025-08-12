<?php
session_start();
require_once('../../../classes/Autoload.php');

header("Content-Type: application/json");

if (!isset($_SESSION['usuario']['usuario_id'])) {
    echo json_encode(["status" => "erro", "mensagem" => "Usuário não autenticado."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clientes_id'])) {
    try {
        $db = new Database();
        $conn = $db->getConnection();

        $stmt = $conn->prepare("DELETE FROM cadastro_clientes WHERE clientes_id = :id");
        $stmt->bindValue(':id', intval($_POST['clientes_id']), PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            echo json_encode(["status" => "sucesso", "mensagem" => "Cliente excluído com sucesso!"]);
        } else {
            echo json_encode(["status" => "erro", "mensagem" => "Cliente não encontrado."]);
        }
    } catch (PDOException $e) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro: " . $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "erro", "mensagem" => "Requisição inválida."]);
}
