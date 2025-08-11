<?php
session_start();
require_once('../../../classes/Autoload.php');

$usuario_id = $_SESSION['usuario']['usuario_id'] ?? null;

if (!$usuario_id) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}
// FUNÇÃO PARA VALIDAR CPF
function validarCPF($cpf) {
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    if (strlen($cpf) !== 11 || preg_match('/(\d)\1{10}/', $cpf)) {
        return false;
    }

    for ($t = 9; $t < 11; $t++) {
        $d = 0;
        for ($c = 0; $c < $t; $c++) {
            $d += $cpf[$c] * (($t + 1) - $c);
        }
        $d = ((10 * $d) % 11) % 10;
        if ($cpf[$c] != $d) {
            return false;
        }
    }
    return true;
}
// FUNÇÃO PARA VALIDAR CNPJ
function validarCNPJ($cnpj) {
    $cnpj = preg_replace('/[^0-9]/', '', $cnpj);

    if (strlen($cnpj) != 14 || preg_match('/(\d)\1{13}/', $cnpj)) {
        return false;
    }

    $soma1 = 0;
    $soma2 = 0;
    $peso1 = [5,4,3,2,9,8,7,6,5,4,3,2];
    $peso2 = [6,5,4,3,2,9,8,7,6,5,4,3,2];

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

//MENSAGEM
$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

// DADOS DO FORMULARIO
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

    //VALIDAÇÃO DE E-MAIL
    $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    if (!preg_match($emailPattern, $email)) {
        $_SESSION['mensagem'] = "E-mail inválido. Verifique o formato: exemplo@dominio.com";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }


    // SÓ É PERMITIDO O FORMATO  11912345678.
    $telefonePattern = '/^\d{11}$/';

    if (!preg_match($telefonePattern, $telefone)) {
        $_SESSION['mensagem'] = "Telefone inválido. Use o formato XXXXXXXXX.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // VALIDAÇÃO CAMPOS NOME/CPF-CNPJ/TELEFONE
    if ($nome === '' || $cpf_cnpj === '' || $telefone === '') {
        $_SESSION['mensagem'] = "Preencha os campos nome, cnpj/cpf e telefone eles são obrigatórios.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }
    
    // VALIDAÇÃO CPF/CNPJ
    $cpf_cnpj_limpo = preg_replace('/[^0-9]/', '', $cpf_cnpj);

    if (strlen($cpf_cnpj_limpo) === 11) {
        if (!validarCPF($cpf_cnpj_limpo)) {
            $_SESSION['mensagem'] = "CPF inválido.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } elseif (strlen($cpf_cnpj_limpo) === 14) {
        if (!validarCNPJ($cpf_cnpj_limpo)) {
            $_SESSION['mensagem'] = "CNPJ inválido.";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        }
    } else {
        $_SESSION['mensagem'] = "CPF ou CNPJ com tamanho inválido.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // UPLOAD DA IMAGEM
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = dirname(__DIR__, 4) . '/uploads/';

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

            $stmt->bindValue(':usuario_id', $usuario_id, PDO::PARAM_INT);
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
    <!-- SCRIPT -->
    <script src="../../../scripts/ApiCep.js" defer></script>
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
                <input type="text" name="nome" placeholder="Nome da empresa">
            </span>

            <span>
                <i class="material-icons">article</i>
                <input type="text" name="cpf_cnpj" placeholder="CPF/CNPJ">
            </span>

            <span>
                <i class="material-icons">alternate_email</i>
                <input type="email" name="email" placeholder="Email">
            </span>

            <span>
                <i class="material-icons">call</i>
                <input type="text" name="telefone" placeholder="Telefone">
            </span>

            <div id="address">
                <h2>Endereço</h2>

                <span>
                    <input type="text" name="estado" id="estado" placeholder="Estado">
                    <input type="text" name="cep" id="cep" placeholder="CEP">
                </span>

                <span>
                    <input type="text" name="rua" id="rua" placeholder="Rua">
                    <input type="text" name="bairro" id="bairro" placeholder="Bairro">
                </span>

                <span>
                    <input type="text" name="numero" id="numero" placeholder="Número">
                    <input type="text" name="cidade" id="cidade" placeholder="Cidade">
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