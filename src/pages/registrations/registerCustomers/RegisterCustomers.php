<?php
session_start();
require_once('../../../classes/Autoload.php');

$usuario_id = $_SESSION['usuario']['usuario_id'] ?? null;

if (!$usuario_id) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf_cnpj = trim($_POST['cpf_cnpj'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $rua = trim($_POST['rua'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $imagem_url = null;

    if ($nome === '' || $cpf_cnpj === '' || $telefone === '') {
        $_SESSION['mensagem'] = "Preencha todos os campos obrigatórios.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // Upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../../uploads/';
        $ext = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('cliente_') . '.' . $ext;
        $filePath = $uploadDir . $fileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['imagem']['type'], $allowedTypes)) {
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $filePath)) {
                $imagem_url = 'uploads/' . $fileName;
            }
        }
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $check = $conn->prepare("
            SELECT COUNT(*) 
            FROM cadastro_clientes 
            WHERE nome = :nome
        ");
        $check->bindValue(':nome', $nome, PDO::PARAM_STR);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            $_SESSION['mensagem'] = "Este cliente já está cadastrado!";
        } else {
            $stmt = $conn->prepare("
                INSERT INTO cadastro_clientes 
                (usuario_id, nome, cpf_cnpj, email, telefone, rua, numero, bairro, cidade, estado, cep, imagem_url) 
                VALUES 
                (:usuario_id, :nome, :cpf_cnpj, :email, :telefone, :rua, :numero, :bairro, :cidade, :estado, :cep, :imagem_url)
            ");

            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT); // CORRIGIDO
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':cpf_cnpj', $cpf_cnpj, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindValue(':rua', $rua, PDO::PARAM_STR);
            $stmt->bindValue(':numero', $numero, PDO::PARAM_STR);
            $stmt->bindValue(':bairro', $bairro, PDO::PARAM_STR);
            $stmt->bindValue(':cidade', $cidade, PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
            $stmt->bindValue(':imagem_url', $imagem_url, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Cliente cadastrado com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar o cliente.";
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
    <title>Cadastro de clientes</title>
    <link rel="stylesheet" href="../../../assets/css/registerCustomers/RegisterCustomers.css?=1.1">
    <link rel="shortcut icon" href="./src/assets/img/favicon_logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <main>
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
            <h2>Cadastro de Clientes</h2>

            <span>
                <i class="material-icons">domain</i>
                <input type="text" name="nome" placeholder="Nome da empresa" required>
            </span>

            <span>
                <i class="material-icons">article</i>
                <input type="text" name="cpf_cnpj" placeholder="CPF/CNPJ" required>
            </span>

            <span>
                <i class="material-icons">alternate_email</i>
                <input type="email" name="email" placeholder="Email">
            </span>

            <span>
                <i class="material-icons">call</i>
                <input type="text" name="telefone" placeholder="Telefone" required>
            </span>

            <div id="address">
                <h2>Endereço</h2>

                <span>
                    <input type="text" name="estado" placeholder="Estado">
                    <input type="text" name="cep" placeholder="CEP">
                </span>

                <span>
                    <input type="text" name="rua" placeholder="Rua">
                    <input type="text" name="bairro" placeholder="Bairro">
                </span>

                <span>
                    <input type="text" name="numero" placeholder="Número">
                    <input type="text" name="cidade" placeholder="Cidade">
                </span>
            </div>

            <span>
                <input type="file" name="imagem" accept="image/*">
            </span>

            <button type="submit" id="register">Cadastrar</button>
            <button type="button" id="toGoOut" onclick="window.location.href='logout.php'">Sair</button>
        </form>
    </main>
</body>

</html>
