<?php 
session_start();
// REDIRECIONA O USUÁRIO PARA PÁGINA DE LOGIN, CASSO ELE NÃO TENHA FEITO
if(!isset($_SESSION['usuario'])){
  header('Location: Login.php');
  exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Usuário</title>
    <!-- LINK CSS -->
     <link rel="stylesheet" href="../assets/css/Dashboard_User.css">
     <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <header>
        <nav>
            <div class="btnMenu">
                <i class="material-icons" id="iconMenu">menu</i>
            </div>
           <div class="logo">
                <img src="../assets//img/logo.svg" alt="logo">
           </div>
        </nav>
    </header>
</body>
</html>