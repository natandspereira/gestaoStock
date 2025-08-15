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
    $razao_social               = trim($_POST['razao_social'] ?? '');
    $nome_fantasia            = trim($_POST['nome_fantasia'] ?? '');
    $cnpj = trim($_POST['cnpj'] ?? '');
    $inscricao_estadual             = trim($_POST['inscricao_estadual'] ?? '');
    $telefone     = trim($_POST['telefone'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $endereco    = trim($_POST['endereco'] ?? '');
    $numero        = trim($_POST['numero'] ?? '');
    $complemento        = trim($_POST['complemento'] ?? '');
    $bairro        = trim($_POST['bairro'] ?? '');
    $cidade        = trim($_POST['cidade'] ?? '');
    $estado        = trim($_POST['estado'] ?? '');
    $cep        = trim($_POST['cep'] ?? '');
    $observacoes        = trim($_POST['observacoes'] ?? '');

    // Valida ID da tarefa
    if ($id <= 0) {
        echo json_encode(["status" => "erro", "mensagem" => "ID do fornecedor inválido."]);
        exit;
    }

    $db = new Database();
    $conn = $db->getConnection();

    // Prepara a query
    $sql = "UPDATE cadastro_fornecedor 
            SET razao_social = :razao_social,
                nome_fantasia = :nome_fantasia,
                cnpj = :cnpj,
                inscricao_estadual = :inscricao_estadual,
                telefone = :telefone,
                email = :email,
                endereco = :endereco,
                numero = :numero,
                complemento = :complemento,
                bairro = :bairro,
                cidade = :cidade,
                estado = :estado,
                cep = :cep,
                observacoes = :observacoes
            WHERE fornecedor_id = :id";

    $stmt = $conn->prepare($sql);

    // Faz o bind dos parâmetros
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->bindParam(":razao_social", $razao_social);
    $stmt->bindParam(":nome_fantasia", $nome_fantasia);
    $stmt->bindParam(":cnpj", $cnpj);
    $stmt->bindParam(":inscricao_estadual", $inscricao_estadual);
    $stmt->bindParam(":telefone", $telefone);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":endereco", $endereco);
    $stmt->bindParam(":numero", $numero);
    $stmt->bindParam(":complemento", $complemento);
    $stmt->bindParam(":bairro", $bairro);
    $stmt->bindParam(":cidade", $cidade);
    $stmt->bindParam(":estado", $estado);
    $stmt->bindParam(":cep", $cep);
    $stmt->bindParam(":observacoes", $observacoes);
  

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Fornecedor atualizada com sucesso."]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao atualizar fornecedor."]);
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "erro", "mensagem" => "Erro no banco de dados: " . $e->getMessage()]);
}
