<?php
session_start();
include 'DB.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = trim($_POST['matricula'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE matricula = :matricula');
    $stmt->execute(['matricula' => $matricula]);

    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['usuario'] = $usuario['matricula'];
        header('Location: ../pages/Dashboard_User.php');
        exit;
    } 
}
?>
