<?php 

include '../data/DB_Profile.php'; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../assets/css/Btn_Data.css">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body id="bodyProfile">
    <div class="data">
        <h1>dados cadastrados</h1>
        <?php if (!empty($usuario)): ?>
           <div class="dataUl">
                <ul>
                    <label for="">
                        <li>Nome: <?php echo htmlspecialchars($usuario['nome']); ?></li>
                        <i class="material-icons" id="iconAccount">edit</i>
                    </label>
                    <label for="">
                        <li>Email: <?php echo htmlspecialchars($usuario['email']); ?></li>
                        <i class="material-icons" id="iconAccount">edit</i>
                    </label>
                    <label for="">
                        <li>Matrícula: <?php echo htmlspecialchars($usuario['matricula']); ?></li>
                        <i class="material-icons" id="iconAccount">edit</i>
                    </label>
                </ul>
           </div>
        <?php else: ?>
            <p>Usuário não encontrado ou não logado.</p>
        <?php endif; ?>
    </div>
</body>
</html>


<!-- BODY -->


