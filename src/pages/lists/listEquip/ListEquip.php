<?php 
session_start();
require_once('../../../classes/Autoload.php');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario']['usuario_id'])) {
    $_SESSION['mensagem'] = "Usuário não autenticado.";
    header('Location: ../../../../index.php');
    exit;
}

$mensagem = $_SESSION['mensagem'] ?? '';
unset($_SESSION['mensagem']);

$equips = [];

try{
    $db = new Database();
    $conn = $db->getConnection();

    $stmt = $conn->prepare("SELECT * FROM cadastro_equipamento ORDER BY nome ASC");
    $stmt->execute();

    $equips = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (PDOException $e) {
    $mensagem = "Erro ao buscar técnicos: " . $e->getMessage();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipamentos</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/listEquip/ListEquip.css">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
</head>
<body>
    <h1>Equipamentos Cadastrados</h1>

    <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
    <?php endif; ?>

    <?php if (empty($equips)) : ?>
        <p>Nenhum equipamento cadastrado.</p>
    <?php else : ?>
         <div class="equips-container">
            <?php foreach ($equips as $equip) : ?>
                <div class="equip-card">
                    <?php if (!empty($equip['imagem_url'])) : ?>
                        <img src="/gestaoStock/<?php echo htmlspecialchars($equip['imagem_url']); ?>" alt="Imagem de <?php echo htmlspecialchars($equip['nome']); ?>">
                    <?php else : ?>
                        <img src="/gestaoStock/assets/img/default-user.png" alt="Sem imagem disponível">
                    <?php endif; ?>


                    <div class="equip-info">
                        <p><span>Nome:</span> <?php echo htmlspecialchars($equip['nome']); ?></p>
                        <p><span>Código:</span> <?php echo htmlspecialchars($equip['codigo']); ?></p>
                        <p><span>Patrimonio:</span> <?php echo htmlspecialchars($equip['patrimonio']); ?></p>
                        <p><span>Quantidade Atual:</span> <?php echo htmlspecialchars($equip['qt_atual']); ?></p>
                        <p><span>Quantidade Minima:</span> <?php echo htmlspecialchars($equip['qt_minima']); ?></p>
                        <p><span>Valor de Custo:</span> <?php echo htmlspecialchars($equip['valor_custo']); ?></p>
                        <p><span>Valor de Venda:</span> <?php echo htmlspecialchars($equip['valor_venda']); ?></p>
                        <p><span>Valor de Aluguel:</span> <?php echo htmlspecialchars($equip['valor_aluguel']); ?></p>
                        <p><span>Valor de Manuntenção:</span> <?php echo htmlspecialchars($equip['valor_manutencao']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</body>

</html>