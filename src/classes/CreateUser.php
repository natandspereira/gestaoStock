<?php

require_once 'Autoload.php';

class CreateUser extends Database
{
    private $pdo;
    private $dirPath;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->dirPath = realpath(__DIR__ . '/../assets/img/uploads_img_usuario');

        if (!is_dir($this->dirPath)) {
            mkdir($this->dirPath, 0777, true);
        }
    }

    public function newUser(array $dados, array $arquivoImagem)
    {
        $nome = trim($dados['nome'] ?? '');
        $senha = trim($dados['senha'] ?? '');
        $confirmar_senha = trim($dados['confirmar_senha'] ?? '');
        $email = trim($dados['email'] ?? '');
        $matricula = trim($dados['matricula'] ?? '');
        $imagem_url = '';

        if (!$this->validatePassword($senha, $confirmar_senha)) {
            $this->alertRedirect("Senha inválida. Deve conter ao menos: 8 caracteres, uma letra maiúscula, minúscula, número e símbolo.");
        }

        $imagem_url = $this->processImage($arquivoImagem);
        if (empty($imagem_url)) {
            $imagem_url = 'src/assets/img/uploads_img_usuario/profile_user.svg';
        }

        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        try {
            $stmt = $this->pdo->prepare("INSERT INTO usuarios (nome, senha, email, matricula, imagem_url) 
                                         VALUES (:nome, :senha, :email, :matricula, :imagem_url)");

            $stmt->execute([
                ':nome' => $nome,
                ':senha' => $senha_hash,
                ':email' => $email,
                ':matricula' => $matricula,
                ':imagem_url' => $imagem_url
            ]);
        } catch (PDOException $e) {
            error_log("[" . date('Y-m-d H:i:s') . "] Erro ao criar usuário: " . $e->getMessage(), 3, __DIR__ . '/../../logs/error.log');
            echo "<script>alert('Erro ao salvar usuário no banco.');</script>";
        }
    }

    private function validatePassword($senha, $confirmar_senha): bool
    {
        return $senha === $confirmar_senha &&
            strlen($senha) >= 8 &&
            preg_match('/[A-Z]/', $senha) &&
            preg_match('/[a-z]/', $senha) &&
            preg_match('/[0-9]/', $senha) &&
            preg_match('/[\W_]/', $senha);
    }

    private function alertRedirect(string $mensagem)
    {
        echo "<script>alert('$mensagem'); window.location.href = '../createUser/CreateUser.php';</script>";
        exit;
    }

    private function processImage(array $arquivo): ?string
    {
        if (isset($arquivo['image']) && $arquivo['image']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($arquivo['image']['name'], PATHINFO_EXTENSION));

            if (!in_array($ext, ['jpg', 'jpeg', 'png'])) {
                echo "<script>alert('Somente JPG, JPEG ou PNG são permitidos');</script>";
                exit;
            }

            $uniqueName = uniqid() . '.' . $ext;
            $fullPath = $this->dirPath . DIRECTORY_SEPARATOR . $uniqueName;

            if (move_uploaded_file($arquivo['image']['tmp_name'], $fullPath)) {
                // Retorna caminho relativo público
                return 'src/assets/img/uploads_img_usuario/' . $uniqueName;
            } else {
                echo "<script>alert('Erro ao mover a imagem. Verifique permissões da pasta.');</script>";
                exit;
            }
        }

        return null;
    }

    public function searchUserImage($usuario_id)
    {
        $stmt = $this->pdo->prepare("SELECT imagem_url FROM usuarios WHERE usuario_id = :id");
        $stmt->execute([':id' => $usuario_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
