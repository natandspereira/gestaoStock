<?php 
session_start();
require_once ('../../../classes/Autoload.php');

$mensagem = '';
$usuarios_id = $_SESSION['usuario']['usuario_id'] ?? null; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = isset($_POST['nome']) ? trim((string)$_POST['nome']) : '';
    $descricao = isset($_POST['descricao']) ? trim((string)$_POST['descricao']) : '';

    if ($nome === '' || $descricao === '' || !$usuarios_id) {
        $_SESSION['mensagem'] = "Preencha todos os campos corretamente.";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
    }

    try {
        $db = new Database();
        $conn = $db->getConnection();

        
        $check = $conn->prepare("
            SELECT COUNT(*) 
            FROM cadastro_categoria 
            WHERE nome = :nome 
              AND usuario_id = :usuario_id
        ");
        $check->bindValue(':nome', $nome, PDO::PARAM_STR);
        $check->bindValue(':usuario_id', $usuarios_id, PDO::PARAM_INT);
        $check->execute();

        if ($check->fetchColumn() > 0) {
            $_SESSION['mensagem'] = "Esta categoria já existe!";
        } else {
           
            $stmt = $conn->prepare("
                INSERT INTO cadastro_categoria (nome, descricao, usuario_id) 
                VALUES (:nome, :descricao, :usuario_id)
            ");
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindValue(':usuario_id', $usuarios_id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Categoria cadastrada com sucesso!";
            } else {
                $_SESSION['mensagem'] = "Erro ao cadastrar a categoria.";
            }
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro: " . $e->getMessage();
    }

    
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}


if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro Categoria</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../../../assets/css/category/Category.css">
</head>
<!-- cadastro_categoria => nome | descrição -->

<body>
    <?php if (!empty($mensagem)): ?>
        <div class="alert <?php echo (stripos($mensagem, 'sucesso') !== false ? 'sucesso' : 'error') ?>">
            <?php echo htmlspecialchars($mensagem); ?>
        </div>
        <script>
            // REMOVE O ALERTA DEPOIS DE 3 SEGUNDOS
            setTimeout(() => {
                document.querySelector('.alert').remove();
            }, 3000);
        </script>
    <?php endif; ?>

    <form method="POST">
        <h4>Cadastro Categoria</h4>
        <input type="text" name="nome" placeholder="Nome da Categoria">
        <textarea name="descricao" id=""></textarea>
        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>