<?php
session_start();
require_once('../../../classes/Autoload.php');

$usuario_id = $_SESSION['usuario']['usuario_id'] ?? null;

if (!$usuario_id) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}

// FUNÇÃO PARA VALIDAR CNPJ
function validarCNPJ($cnpj)
{
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    $soma1 = 0;
    $soma2 = 0;
    $peso1 = [5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];
    $peso2 = [6, 5, 4, 3, 2, 9, 8, 7, 6, 5, 4, 3, 2];

    for ($i = 0; $i < 12; $i++) {
        $soma1 += $cnpj[$i] * $peso1[$i];
    }

    $resto = $soma1 % 11;
    $dig1 = ($resto < 2) ? 0 : 11 - $resto;

    if ($cnpj[12] != $dig1) return false;

    for ($i = 0; $i < 13; $i++) {
        $soma2 += $cnpj[$i] * $peso2[$i];
    }

    $resto = $soma2 % 11;
    $dig2 = ($resto < 2) ? 0 : 11 - $resto;

    return $cnpj[13] == $dig2;
}

// MENSAGEM
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $razao_social       = trim($_POST['razao_social'] ?? '');
    $nome_fantasia      = trim($_POST['nome_fantasia'] ?? '');
    $cnpj               = trim($_POST['cnpj'] ?? '');
    $inscricao_estadual = trim($_POST['inscricao_estadual'] ?? '');
    $telefone           = trim($_POST['telefone'] ?? '');
    $email              = trim($_POST['email'] ?? '');
    $cep                = trim($_POST['cep'] ?? '');
    $endereco           = trim($_POST['endereco'] ?? '');
    $bairro             = trim($_POST['bairro'] ?? '');
    $cidade             = trim($_POST['cidade'] ?? '');
    $estado             = trim($_POST['estado'] ?? '');
    $numero             = trim($_POST['numero'] ?? '');
    $complemento        = trim($_POST['complemento'] ?? '');
    $imagem_url         = null;

    // Validação de e-mail
    $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if (!preg_match($emailPattern, $email)) {
        $_SESSION['mensagem'] = "E-mail inválido.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Validação telefone (somente números, 11 dígitos)
    $telefonePattern = '/^\d{11}$/';
    if (!preg_match($telefonePattern, $telefone)) {
        $_SESSION['mensagem'] = "Telefone inválido. Use apenas números, ex: 11912345678.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Campos obrigatórios
    if ($nome_fantasia === '' || $cnpj === '') {
        $_SESSION['mensagem'] = "Preencha os campos Nome Fantasia e CNPJ.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Validação CNPJ
    $cnpj_limpo = preg_replace('/[^0-9]/', '', $cnpj);
    if (!validarCNPJ($cnpj_limpo)) {
        $_SESSION['mensagem'] = "CNPJ inválido.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Upload da imagem
    if (isset($_FILES['imagem_url']) && $_FILES['imagem_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = dirname(__DIR__, 4) . '/uploads/';
        $ext = pathinfo($_FILES['imagem_url']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('cliente_') . '.' . $ext;
        $filePath = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['imagem_url']['type'], $allowedTypes)) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            if (move_uploaded_file($_FILES['imagem_url']['tmp_name'], $filePath)) {
                $imagem_url = 'uploads/' . $fileName;
            }
        }
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        // Verifica duplicidade
        $check = $conn->prepare("
            SELECT COUNT(*) 
            FROM cadastro_fornecedor
            WHERE nome_fantasia = :nome_fantasia
        ");
        $check->bindValue(':nome_fantasia', $nome_fantasia, PDO::PARAM_STR);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            $_SESSION['mensagem'] = "Este fornecedor já está cadastrado!";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO cadastro_fornecedor 
                (razao_social, nome_fantasia, cnpj, inscricao_estadual, telefone, email, cep, endereco, bairro, cidade, estado, numero, complemento, usuario_id, imagem_url) 
                VALUES 
                (:razao_social, :nome_fantasia, :cnpj, :inscricao_estadual, :telefone, :email, :cep, :endereco, :bairro, :cidade, :estado, :numero, :complemento, :usuario_id, :imagem_url)
            ");

            $stmt->bindValue(':razao_social', $razao_social, PDO::PARAM_STR);
            $stmt->bindValue(':nome_fantasia', $nome_fantasia, PDO::PARAM_STR);
            $stmt->bindValue(':cnpj', $cnpj, PDO::PARAM_STR);
            $stmt->bindValue(':inscricao_estadual', $inscricao_estadual, PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
            $stmt->bindValue(':endereco', $endereco, PDO::PARAM_STR);
            $stmt->bindValue(':bairro', $bairro, PDO::PARAM_STR);
            $stmt->bindValue(':cidade', $cidade, PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindValue(':numero', $numero, PDO::PARAM_STR);
            $stmt->bindValue(':complemento', $complemento, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
            $stmt->bindValue(':imagem_url', $imagem_url, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Fornecedor cadastrado com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar o fornecedor.";
            }
        }
    } catch (PDOException $e) {
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
    <title>Cadastro Fornecedores</title>
    <link rel="stylesheet" href="../../../assets/css/registerSuppliers/registerSuppliers.css">
    <!-- SCRIPT -->
    <script src="../../../scripts/ApiCep.js" defer></script>
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

    <form action="" method="POST" enctype="multipart/form-data">
        <h1>Cadastro Fornecedores</h1>
        <span id="dadosEmpresa">
            <div>
                <input type="text" name="razao_social" placeholder="Razão Social">
                <input type="text" name="nome_fantasia" placeholder="Nome Fantasia">
            </div>
            <div>
                <input type="text" name="cnpj" placeholder="CNPJ">
                <input type="text" name="inscricao_estadual" placeholder="Inscrição Estadual">
            </div>
            <div>
                <input type="text" name="telefone" placeholder="Telefone">
                <input type="text" name="email" placeholder="Email">
            </div>
        </span>
        <span id="endereço">
            <h2>Endereço</h2>
            <div id="cepRua">
                <input type="text" name="cep" id="cep" placeholder="CEP">
                <input type="text" name="endereco" id="rua" placeholder="Rua">
            </div>
            <div id="bairroCidadeEstado">
                <input type="text" name="bairro" id="bairro" placeholder="Bairro">
                <input type="text" name="cidade" id="cidade" placeholder="Cidade">
                <input type="text" name="estado" id="estado" placeholder="Estado">
            </div>
            <div id="numeroComplemento">
                <input type="text" name="numero" id="numero" placeholder="Numero">
                <input type="text" name="complemento" placeholder="Complemento">
            </div>
        </span>
        <input type="file" name="imagem_url" id="imagem" accept="image/*">

        <button type="submit" id="register">Cadastrar</button>
    </form>
</body>

</html>