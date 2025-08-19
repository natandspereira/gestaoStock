<?php
require_once '../../classes/Autoload.php';
header('Content-Type: application/json');  // Retorno em JSON

session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['usuario_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não logado.']);
    exit;
}

$usuarioId = $_SESSION['usuario']['usuario_id'];
$db = new Database();
$pdo = $db->getConnection();

// Puxa dados do usuário
$sql = "SELECT * FROM usuarios WHERE usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    echo json_encode(['status' => 'error', 'message' => 'Usuário não encontrado.']);
    exit;
}

// Função para verificar e retornar URL correta da imagem
function getImagemUrl(string $imagem_url): string {
    $caminhoImagemFisico = __DIR__ . '/../../' . ltrim($imagem_url, '/');
    if (!empty($imagem_url) && file_exists($caminhoImagemFisico)) {
        return '/gestaoStock/' . ltrim($imagem_url, '/');
    } else {
        return '/gestaoStock/src/assets/img/uploads_img_usuario/profile_user.svg';
    }
}

// Processa atualização via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['senha'] ?? '';
    $confirmarSenha = $_POST['confirmar_senha'] ?? '';
    $novaImagemUrl = '';

    // Verifica campos obrigatórios
    if (empty($nome) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Todos os campos obrigatórios devem ser preenchidos.']);
        exit;
    }

    // Valida senha, se fornecida
    if (!empty($senha)) {
        if ($senha !== $confirmarSenha) {
            echo json_encode(['status' => 'error', 'message' => 'As senhas não coincidem.']);
            exit;
        }

        if (
            strlen($senha) < 8 ||
            !preg_match('/[A-Z]/', $senha) ||
            !preg_match('/[a-z]/', $senha) ||
            !preg_match('/[0-9]/', $senha) ||
            !preg_match('/[\W]/', $senha)
        ) {
            echo json_encode(['status' => 'error', 'message' => 'A senha deve ter no mínimo 8 caracteres, contendo pelo menos uma letra maiúscula, uma minúscula, um número e um caractere especial.']);
            exit;
        }
    }

    // Upload da nova imagem, se enviada
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $extensoesPermitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $arquivoTmp = $_FILES['imagem']['tmp_name'];
        $nomeOriginal = $_FILES['imagem']['name'];
        $ext = strtolower(pathinfo($nomeOriginal, PATHINFO_EXTENSION));

        if (in_array($ext, $extensoesPermitidas)) {
            $nomeArquivo = uniqid('img_') . '.' . $ext;
            $diretorioDestino = __DIR__ . '/../../assets/img/uploads_img_usuario';

            if (!is_dir($diretorioDestino)) {
                mkdir($diretorioDestino, 0755, true);
            }

            $caminhoFisico = $diretorioDestino . '/' . $nomeArquivo;
            if (move_uploaded_file($arquivoTmp, $caminhoFisico)) {
                $novaImagemUrl = 'src/assets/img/uploads_img_usuario/' . $nomeArquivo;

                // Deleta imagem antiga se existir e for diferente da padrão
                if (!empty($usuario['imagem_url'])) {
                    $imagemAntigaFisica = __DIR__ . '/../../' . ltrim($usuario['imagem_url'], '/');
                    if (file_exists($imagemAntigaFisica) && strpos($usuario['imagem_url'], 'profile_user.svg') === false) {
                        @unlink($imagemAntigaFisica);
                    }
                }
            }
        }
    }

    // Monta query de atualização
    $sql = "UPDATE usuarios SET nome = :nome, email = :email";
    if (!empty($senha)) {
        $sql .= ", senha = :senha";
    }
    if ($novaImagemUrl) {
        $sql .= ", imagem_url = :imagem_url";
    }
    $sql .= " WHERE usuario_id = :usuario_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':email', $email);
    if (!empty($senha)) {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
        $stmt->bindParam(':senha', $senhaHash);
    }
    if ($novaImagemUrl) {
        $stmt->bindParam(':imagem_url', $novaImagemUrl);
    }
    $stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
    $stmt->execute();

    // Atualiza sessão
    $_SESSION['usuario']['nome'] = $nome;
    $_SESSION['usuario']['email'] = $email;
    if ($novaImagemUrl) {
        $_SESSION['usuario']['imagem_url'] = $novaImagemUrl;
    }

    // URL da imagem para resposta JSON
    $imagemParaRetorno = getImagemUrl($novaImagemUrl ?? ($_SESSION['usuario']['imagem_url'] ?? ''));

    echo json_encode([
        'status' => 'success',
        'nome' => $nome,
        'email' => $email,
        'imagem_url' => $imagemParaRetorno
    ]);
    exit;
}

// Para GET, retorna dados do usuário
$imagemParaRetorno = getImagemUrl($usuario['imagem_url'] ?? '');

echo json_encode([
    'status' => 'success',
    'nome' => $usuario['nome'],
    'email' => $usuario['email'],
    'imagem_url' => $imagemParaRetorno
]);
exit;
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
    <link rel="stylesheet" href="../../../assets/css/profile/Profile.css?v=<?php echo time(); ?>">
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- SCRIPT -->
     <script src="../../scripts/btnOptionMenu.js" defer></script>
</head>
<body>


    <div id="containerProfile">
        <div id="dataUser">
            <div id="imgUser">
                <img src="<?= htmlspecialchars($imagem); ?>" alt="Imagem do usuário" width="150">
            </div>
            <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
        </div>

        <form id="profileForm" method="POST" enctype="multipart/form-data">
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']); ?>" required>
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']); ?>" required>
            <input type="password" name="senha" placeholder="Nova senha">
            <input type="password" name="confirmar_senha" placeholder="Confirmar nova senha">
            <input type="file" name="imagem" accept="image/*">
            <button type="submit">Atualizar</button>
        </form>
    </div>

</body>
</html>
