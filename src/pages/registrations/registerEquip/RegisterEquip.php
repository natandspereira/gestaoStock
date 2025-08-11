<?php
session_start();
require_once('../../../classes/Autoload.php');

$usuario_id = $_SESSION['usuario']['usuario_id'] ?? null;

if (!$usuario_id) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}

//MENSAGEM
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

// VARIÁVEIS PARA PRESERVAR VALORES DO FORMULÁRIO
$nome = $codigo = $patrimonio = $qt_atual = $qt_minima = $valor_custo = $valor_venda = $valor_aluguel = $valor_manutencao = $imagem_url  = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = trim($_POST['nome'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');
    $patrimonio = trim($_POST['patrimonio'] ?? '');
    $qt_atual = trim($_POST['qt_atual'] ?? '');
    $qt_minima = trim($_POST['qt_minima'] ?? '');
    $valor_custo = trim($_POST['valor_custo'] ?? '');
    $valor_venda = trim($_POST['valor_venda'] ?? '');
    $valor_aluguel = trim($_POST['valor_aluguel'] ?? '');
    $valor_manutencao = trim($_POST['valor_manutencao'] ?? '');
    $imagem_url = null;

    //VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    if ($nome === '' || $codigo === '' || $patrimonio === '') {
        $_SESSION['mensagem'] = "Preencha os campos nome, codigo e patrimonio; eles são obrigatórios.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

     // UPLOAD DA IMAGEM
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = dirname(__DIR__, 4) . '/uploads/equipamentos/';
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('cliente_') . '.' . $ext;
        $filePath = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['imagem']['type'], $allowedTypes)) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $filePath)) {
                // Ajuste o caminho relativo conforme a estrutura do seu projeto
                $imagem_url = 'uploads/equipamentos/' . $fileName;
            }
        }
    }

    try{
         $db = new Database();
        $conn = $db->getConnection();

        $check = $conn->prepare("SELECT COUNT(*) FROM cadastro_equipamento WHERE nome = :nome");
        $check->bindValue(':nome', $nome, PDO::PARAM_STR);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            $_SESSION['mensagem'] = "Este equipamento já está cadastrado!";
        }else{
            $stmt = $conn->prepare("INSERT INTO cadastro_equipamento (
                nome, codigo, patrimonio, qt_atual, qt_minima, valor_custo, valor_venda, valor_aluguel, valor_manutencao ,imagem_url
            ) VALUES (
                :nome, :codigo, :patrimonio, :qt_atual, :qt_minima, :valor_custo, :valor_venda, :valor_aluguel, :valor_manutencao ,:imagem_url
            )");

             $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':codigo', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':patrimonio', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':qt_atual', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':qt_minima', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':valor_custo', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':valor_venda', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':valor_aluguel', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':valor_manutencao', $nome, PDO::PARAM_STR);
             $stmt->bindValue(':imagem_url', $nome, PDO::PARAM_STR);

             if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Equipamento cadastrado com sucesso!";

                // LIMPA VALORES PARA NÃO REPASSAR PARA O FORMULARIO
                $nome = $codigo = $patrimonio = $qt_atual = $qt_minima = $valor_custo = $valor_venda = $valor_aluguel = $valor_manutencao = $imagem_url  = '';
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar o técnico.";
            }
        }
    }catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro: " . $e->getMessage();
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Equipamentos</title>
    <link rel="stylesheet" href="../../../assets/css/RegisterEquip/RegisterEquip.css">
</head>
<!-- cadastro_equipamento => nome | codigo | patrimonio | qt_atual | qt_minima | valor_custo | valor_venda | valor_aluguel | valor_manutencao | imagem_url | categoria_id | fornecedor_id  -->

<body>
    <h2>Cadastro de Equipamentos</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <span>
            <input type="text" id="nome" name="nome" placeholder="Nome">
            <input type="text" id="codigo"  name="codigo" placeholder="Codigo">
            <input type="text" id="patrimonio"  name="patrimonio" placeholder="Patrimonio">
            <input type="text" id="qt_atual" name="qt_atual" placeholder="Quantidade Atual">
            <input type="text" id="qt_minima"  name="qt_minima" placeholder="Quantidade Minima">
            <input type="text" id="valor_custo"  name="valor_custo" placeholder="Valor de Custo">
            <input type="text" id="valor_venda"  name="valor_venda" placeholder="Valor de Venda">
            <input type="text" id="valor_aluguel"  name="valor_aluguel" placeholder="Valor do Aluugel">
            <input type="text" id="valor_manutencao"  name="valor_manutencao" placeholder="Valor da Manutencao">
            <input type="file" name="imagem" accept="image/*">
        </span>
        <div>
            <button type="submit" id="register">Cadastrar</button>
            <button type="button" id="toGoOut" onclick="window.location.href='logout.php'">Sair</button>
        </div>
    </form>
</body>

</html>