<?php 
include "../data/DB.php";

$stmt = $pdo->query("SELECT imagem_url FROM usuarios WHERE usuario_id = 1");
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

// Caminho físico para salvar o arquivo (no disco)
$dirPath = realpath(__DIR__ . '/../assets/img/uploads_img_usuario');

// Caminho que será salvo no banco (relativo ao site)
$urlBase = 'src/assets/img/uploads_img_usuario';

if (!is_dir($dirPath)) {
    mkdir($dirPath, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $senha = trim($_POST['senha'] ?? '');
    $confirmar_senha = trim($_POST['confirmar_senha'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $matricula = trim($_POST['matricula'] ?? '');
    $imagem_url = '';

    // ✅ Validações da senha
    if (
        $senha !== $confirmar_senha ||
        strlen($senha) < 8 ||
        !preg_match('/[A-Z]/', $senha) ||
        !preg_match('/[a-z]/', $senha) ||
        !preg_match('/[0-9]/', $senha) ||
        !preg_match('/[\W_]/', $senha)
    ) {
        echo "<script>alert('Senha inválida. Deve conter ao menos: 8 caracteres, uma letra maiúscula, minúscula, número e símbolo.');
        window.location.href = '../pages/Create_User.php';</script>";
        exit;
    }

    // ✅ Upload da imagem
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png'])) {
            $uniqueName = uniqid() . '.' . $ext;
            $fullPath = $dirPath . DIRECTORY_SEPARATOR . $uniqueName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $fullPath)) {
                // ✅ Caminho salvo no banco de dados (relativo)
                $imagem_url = $urlBase . '/' . $uniqueName;
            } else {
                echo "<script>alert('Erro ao mover a imagem. Verifique permissões da pasta.');</script>";
                exit;
            }
        } else {
            echo "<script>alert('Somente JPG, JPEG ou PNG são permitidos');</script>";
            exit;
        }
    }

    // ✅ Salva no banco
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, senha, email, matricula, imagem_url) 
                               VALUES (:nome, :senha, :email, :matricula, :imagem_url)");
        $stmt->execute([
            ':nome' => $nome,
            ':senha' => $senha_hash,
            ':email' => $email,
            ':matricula' => $matricula,
            ':imagem_url' => $imagem_url
        ]);

        header("Location: ../pages/Dashboard_User.php");
        exit;
    } catch (PDOException $e) {
        error_log("[" . date('Y-m-d H:i:s') . "] Erro ao criar usuário: " . $e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
        echo "<script>alert('Erro ao salvar usuário no banco.');</script>";
    }
}
?>
