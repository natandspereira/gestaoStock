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

// Pega dados do POST
$id       = $_POST['id'] ?? '';
$nome     = $_POST['nome'] ?? '';
$cpf_cnpj = $_POST['cpf_cnpj'] ?? '';
$email    = $_POST['email'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$cidade   = $_POST['cidade'] ?? '';
$estado   = $_POST['estado'] ?? '';

// Validação básica
if (empty($id) || empty($nome) || empty($cpf_cnpj) || empty($email)) {
    echo json_encode(["status" => "erro", "mensagem" => "Preencha todos os campos obrigatórios."]);
    exit;
}

try {
    $db = new Database();
    $conn = $db->getConnection();

    $sql = "UPDATE cadastro_clientes 
            SET nome = :nome,
                cpf_cnpj = :cpf_cnpj,
                email = :email,
                telefone = :telefone,
                cidade = :cidade,
                estado = :estado
            WHERE clientes_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":cpf_cnpj", $cpf_cnpj);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":cidade", $cidade);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Cliente atualizado com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar cliente."]);
    }

} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro no banco de dados: " . $e->getMessage()]);
}
