<?php
require_once '../../classes/Autoload.php';
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['usuario']['usuario_id'])) {
    header('Location: login.php');
    exit;
}

// Obtém o ID do usuário logado
$usuarioId = $_SESSION['usuario']['usuario_id'];

// Conexão com o banco de dados
$db = new Database();
$pdo = $db->getConnection();

// Consulta apenas o usuário logado
$sql = "SELECT * FROM usuarios WHERE usuario_id = :usuario_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':usuario_id', $usuarioId, PDO::PARAM_INT);
$stmt->execute();

$usuario = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <!-- LINK CSS -->
     <link rel="stylesheet" href="../assets/css/profile/Profile.css?=1.1">
     <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>

<?php if ($usuario): ?>
    <div id="containerProfile">
        <div id="dataUser">
            <div id="imgUser">
                <img src="<?= htmlspecialchars($usuario['imagem_url']); ?>" alt="Imagem do usuário" />
            </div>
            <p><strong>Nome:</strong> <?= htmlspecialchars($usuario['nome']); ?></p>
            <p><strong>Email:</strong> <?= htmlspecialchars($usuario['email']); ?></p>
            <p><strong>Senha:</strong> <?= str_repeat('*', min(strlen($usuario['senha']), 10)); ?></p>
        </div>

        <!-- FORMULÁRIO DE ATUALIZAÇÃO (exemplo) -->
        <form action="">
            <input type="text" placeholder="nome">
            <input type="password" placeholder="senha">
            <input type="password" placeholder="confirmar senha">
            <input type="email" placeholder="email">
        </form>
        <button>update</button>
    </div>
<?php else: ?>
    <p>Usuário não encontrado.</p>
<?php endif; ?>

</body>
</html>
