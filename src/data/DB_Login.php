<?php 
session_start();
include __DIR__ . '/../data/DB.php';

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //DADOS PASSADOS PELO FORMULÁRIO
        $matricula = trim($_POST['matricula'] ?? '');
        $senha = trim($_POST['senha'] ?? '');

       try{
            //  INSTRUÇÃO SQL   
             $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE matricula = :matricula");
             $stmt->execute(['matricula'=>$matricula]);

            // RETORNA TODOS OS USUÁRIOS
             $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

             if ($usuario && password_verify($senha, $usuario['senha'])){
                $_SESSION['usuario']= $usuario['matricula'];
                header('Location: ../pages/Dashboard_User.php');
                exit();
             }else{
                echo "Matrícula ou senha inválidos.";
                exit();
             }
       }catch(PDOException $erro){
        //    ALERTA DE ERROR
            error_log("[" . date('Y-m-d H:i:s') . "] Erro ao tentar Logar: " . $erro->getMessage() . "\n", 3, __DIR__ . '/../../logs/error.log');

            echo "Erro interno no sistema. Tente novamente mais tarde.";
            exit();
    
       }
    }
?>