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

// Carrega valores do ENUM dinamicamente
$especialidades = [];
try {
    $db = new Database();
    $conn = $db->getConnection();
    $sql = "
        SELECT COLUMN_TYPE
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = DATABASE()
          AND TABLE_NAME = 'cadastro_tecnico'
          AND COLUMN_NAME = 'tp_tecnico'
    ";
    $row = $conn->query($sql)->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $str = $row['COLUMN_TYPE']; // ex: enum('Eletricista','Hidráulico','Mecânico','TI')
        $str = str_replace(["enum(", ")", "'"], "", $str);
        $especialidades = explode(",", $str);
    }
} catch (PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao carregar especialidades: " . $e->getMessage();
}

// VARIÁVEIS PARA PRESERVAR VALORES DO FORMULÁRIO
$nome = $email = $telefone = $rua = $numero = $bairro = $cidade = $estado = $cep = $especialidade = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $confirmarSenha = trim($_POST['confirmarSenha'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $rua = trim($_POST['rua'] ?? '');
    $numero = trim($_POST['numero'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');
    $cep = trim($_POST['cep'] ?? '');
    $especialidade = trim($_POST['especialidade'] ?? '');
    $imagem_url = null;

    //VALIDAÇÃO DE E-MAIL
    $emailPattern = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';
    if (!preg_match($emailPattern, $email)) {
        $_SESSION['mensagem'] = "E-mail inválido. Verifique o formato: exemplo@dominio.com";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    //VALIDAÇÃO DE TELEFONE
    $telefonePattern = '/^\d{11}$/';
    if (!preg_match($telefonePattern, $telefone)) {
        $_SESSION['mensagem'] = "Telefone inválido. Use o formato XXXXXXXXXXX (11 dígitos).";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    //VALIDAÇÃO DE CAMPOS OBRIGATÓRIOS
    if ($nome === '' || $senha === '' || $confirmarSenha === '') {
        $_SESSION['mensagem'] = "Preencha os campos nome, senha e confirmar senha; eles são obrigatórios.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // VERIFICAR SE AS SENHAS COINCIDEM
    if ($senha !== $confirmarSenha) {
        $_SESSION['mensagem'] = "As senhas não coincidem.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    //VALIDAÇÃO DE ESPECIALIDADE
    // Usar as especialidades carregadas do banco para validação, não array fixo
    if (!in_array($especialidade, $especialidades)) {
        $_SESSION['mensagem'] = "Especialidade inválida selecionada.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    //VALIDAÇÃO DA SENHA
    if (
        strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[a-z]/', $senha) ||
        !preg_match('/[0-9]/', $senha) ||
        !preg_match('/[\W_]/', $senha)
    ) {
        $_SESSION['mensagem'] = "A senha deve ter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um caractere especial.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    // HASH DA SENHA
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // UPLOAD DA IMAGEM
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = dirname(__DIR__, 4) . '/uploads/tecnicos/';
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
                $imagem_url = 'uploads/tecnicos/' . $fileName;
            }
        }
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        $check = $conn->prepare("SELECT COUNT(*) FROM cadastro_tecnico WHERE nome = :nome");
        $check->bindValue(':nome', $nome, PDO::PARAM_STR);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            $_SESSION['mensagem'] = "Este cliente já está cadastrado!";
        } else {
            $stmt = $conn->prepare("INSERT INTO cadastro_tecnico (
                nome, senha, email, telefone, rua, numero, bairro, cidade, estado, cep, imagem_url, tp_tecnico
            ) VALUES (
                :nome, :senha, :email, :telefone, :rua, :numero, :bairro, :cidade, :estado, :cep, :imagem_url, :tp_tecnico
            )");

            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':senha', $senhaHash, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindValue(':rua', $rua, PDO::PARAM_STR);
            $stmt->bindValue(':numero', $numero, PDO::PARAM_STR);
            $stmt->bindValue(':bairro', $bairro, PDO::PARAM_STR);
            $stmt->bindValue(':cidade', $cidade, PDO::PARAM_STR);
            $stmt->bindValue(':estado', $estado, PDO::PARAM_STR);
            $stmt->bindValue(':cep', $cep, PDO::PARAM_STR);
            $stmt->bindValue(':imagem_url', $imagem_url, PDO::PARAM_STR);
            $stmt->bindValue(':tp_tecnico', $especialidade, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Técnico cadastrado com sucesso!";

                // LIMPA VALORES PARA NÃO REPASSAR PARA O FORMULARIO
                $nome = $email = $telefone = $rua = $numero = $bairro = $cidade = $estado = $cep = $especialidade = '';
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar o técnico.";
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
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastrar Técnico</title>
    <link rel="stylesheet" href="../../../assets/css/registerTechnicians/registerTechnicians.css" />
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon" />
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
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
                <h2>Cadastro de Técnicos</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <h2>Dados Pessoais</h2>
            <span>
                <i class="material-icons">account_circle</i>
                <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($nome) ?>">
            </span>

            <span id="senha">
                <span>
                    <i class="material-icons">lock</i>
                    <input type="password" name="senha" placeholder="Senha">
                </span>
                <span>
                    <i class="material-icons">lock</i>
                    <input type="password" name="confirmarSenha" placeholder="Confirmar Senha">
                </span>
            </span>

            <span>
                <i class="material-icons">call</i>
                <input type="text" name="telefone" placeholder="Telefone" value="<?= htmlspecialchars($telefone) ?>">
            </span>

            <span>
                <i class="material-icons">alternate_email</i>
                <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>">
            </span>

            <!-- Especialidade -->
            <span>
                <label for="especialidade">Especialidade:</label>
                <select name="especialidade" id="especialidade" required>
                    <option value="">Selecione a especialidade</option>
                    <?php foreach ($especialidades as $esp): ?>
                        <option value="<?= htmlspecialchars($esp); ?>" <?= ($especialidade === $esp) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($esp); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </span>

            <div id="address">
                <h2>Endereço</h2>

                <span id="spanEstado">
                    <input type="text" name="estado" id="estado" placeholder="Estado" value="<?= htmlspecialchars($estado) ?>">
                    <input type="text" name="cep" id="cep" placeholder="CEP" value="<?= htmlspecialchars($cep) ?>">
                </span>

                <span>
                    <input type="text" name="rua" id="rua" placeholder="Rua" value="<?= htmlspecialchars($rua) ?>">
                    <input type="text" name="bairro" id="bairro" placeholder="Bairro" value="<?= htmlspecialchars($bairro) ?>">
                </span>

                <span>
                    <input type="text" name="numero" id="numero" placeholder="Número" value="<?= htmlspecialchars($numero) ?>">
                    <input type="text" name="cidade" id="cidade" placeholder="Cidade" value="<?= htmlspecialchars($cidade) ?>">
                </span>
            </div>

            <!-- UPLOAD IMAGEM -->
            <span>
                <input type="file" name="imagem" accept="image/*">
            </span>

            <button type="submit" id="register">Cadastrar</button>
        </form>
    </main>
</body>

</html>

