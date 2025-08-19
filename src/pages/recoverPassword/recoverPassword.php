<?php
session_start();
require_once('../../classes/Autoload.php');

// CONEXÃO COM A DB
$db = new Database();
$pdo = $db->getConnection();

$mensagem = '';
$matricula = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = isset($_POST['matricula']) ? trim($_POST['matricula']) : '';
    $senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';
    $confirmarSenha = isset($_POST['confirmarSenha']) ? trim($_POST['confirmarSenha']) : '';

    // Validação
    if (empty($matricula) || empty($senha) || empty($confirmarSenha)) {
        $mensagem = "Todos os campos são obrigatórios.";
    } elseif ($senha !== $confirmarSenha) {
        $mensagem = "As senhas não coincidem.";
    } elseif (
        strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[a-z]/', $senha) ||
        !preg_match('/[0-9]/', $senha) ||
        !preg_match('/[\W_]/', $senha)
    ) {
        $mensagem = "A senha deve ter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma minúscula, um número e um caractere especial.";
    } else {
        try {
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE matricula = :matricula");
            $stmt->execute(['matricula' => $matricula]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario) {
                $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("UPDATE usuarios SET senha = :senha WHERE matricula = :matricula");
                $stmt->execute([
                    'senha' => $senhaHash,
                    'matricula' => $matricula
                ]);

                $mensagem = "Senha atualizada com sucesso!";
            } else {
                $mensagem = "Matrícula não encontrada.";
            }
        } catch (PDOException $e) {
            error_log("Erro ao recuperar senha: " . $e->getMessage());
            $mensagem = "Erro interno. Tente novamente.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Recuperar Senha</title>
    <!-- CSS -->
    <link rel="stylesheet" href="../../assets/css/recoverPassword/recoverPassword.css">
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

    <form method="POST">
        <div class="container">
            <h2>Recuperar Senha</h2>
            <input type="text" name="matricula" id="matricula" placeholder="Informe o seu login" value="<?php echo htmlspecialchars($matricula); ?>">
            <input type="password" name="senha" id="novaSenha" placeholder="Nova Senha">
            <input type="password" name="confirmarSenha" id="confirmarNovaSenha" placeholder="Confirmar Senha">
            <button type="submit">Cadastrar</button>
        </div>
    </form>
</body>

</html>
