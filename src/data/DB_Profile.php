<?php
session_start();
include 'DB.php';  

$usuario = null;

if (isset($_SESSION['usuario'])) {
    $matricula = $_SESSION['usuario'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE matricula = :matricula");
        $stmt->bindParam(':matricula', $matricula);
        $stmt->execute();

        
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
           
            error_log("Usuário não encontrado para matrícula: $matricula");
        }

    } catch (PDOException $erro) {
        error_log("Erro ao buscar usuário: " . $erro->getMessage());
    }

} else {
    error_log("Matrícula não encontrada na sessão.");
    $usuario = null;
}
?>
