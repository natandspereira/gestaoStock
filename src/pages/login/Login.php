<?php
require_once '../../classes/Autoload.php';
session_start();

$mensagem = '';
$matriculaValue = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = $_POST['matricula'] ?? '';
    $senha = $_POST['senha'] ?? '';

    // mantém o valor digitado no campo em caso de erro
    $matriculaValue = $matricula;

    // INSTANCIA A CLASSE LOGIN
    $login = new Login();

    // CHAMA O MÉTODO DE AUTENTICAÇÃO E PASSA OS DADOS DO FORMULÁRIO
    $resultado = $login->autenticar($matricula, $senha);

    // CAPTURA A MENSAGEM RETORNADA
    $mensagem = $resultado['mensagem'] ?? '';

    if (stripos($mensagem, 'sucesso') !== false) {
        // SUCESSO: ABRE A PÁGINA EM OUTRA ABA E FECHA O MODAL
        echo "<script>
                window.open('../../pages/User.php', '_blank');
                var modal = window.parent.document.getElementById('loginModal');
                if (modal) {
                    modal.style.display = 'none';
                }
              </script>";
        exit();
    }
    // ERRO: não faz alert nem recarrega iframe; apenas deixa seguir para renderizar a mensagem no HTML
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../../assets/css/login/Login.css">
    <!-- SCRIPT BTN CADASTRO -->
    <script src="../../scripts/BtnCadastro.js" defer></script>
</head>

<body>
    <?php if (!empty($mensagem)): ?>
        <div class="alert <?php echo (stripos($mensagem, 'sucesso') !== false ? 'sucesso' : 'error') ?>">
            <?php echo htmlspecialchars($mensagem); ?>
        </div>
        <script>
            // REMOVE O ALERTA VISUAL DEPOIS DE 3 SEGUNDOS (sem popup)
            setTimeout(() => {
                const alertBox = document.querySelector('.alert');
                if (alertBox) alertBox.remove();
            }, 3000);
        </script>
    <?php endif; ?>

    <div class="logo">
        <img src="../../assets/img/logo.png" alt="Logo">
    </div>
    <form action="" method="POST" autocomplete="on">
        <h1>Acessar Conta</h1>
        <p>Bem vindo! Faça login para gerenciar seu estoque</p>
        <div class="inputsLogin">
            <label for="matricula">
                <i class="material-icons" id="iconCircle">account_circle</i>
                <input
                    type="text"
                    id="matricula"
                    name="matricula"
                    placeholder="Matricula"
                    value="<?php echo htmlspecialchars($matriculaValue); ?>"
                    autocomplete="username">
            </label>
            <label for="senha">
                <i class="material-icons" id="iconCircle">lock</i>
                <input
                    type="password"
                    id="senha"
                    name="senha"
                    placeholder="Senha"
                    autocomplete="current-password">
            </label>
            <button type="submit" id="entrar">entrar</button>
            <button type="button" id="btnCadastro">cadastro</button>
            <p>Esqueceu sua senha? <a href="../recoverPassword/recoverPassword.php" target="_blank">Recupere a sua senha aqui</a></p>
        </div>
    </form>
</body>

</html>
