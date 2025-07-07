<?php 

include "../data/DB.php";

if($_SERVER['REQUEST_METHOD']=== 'POST'){
     $nome = trim($_POST['nome'] ?? '');
     $senha = trim($_POST['senha'] ?? '');
     $confirmar_senha = trim($_POST['confirmar_senha'] ?? '');
     $email = trim($_POST['email'] ?? '');
     $matricula = trim($_POST['matricula'] ?? '');
     $imagem_url = '';

    // Processa o upload da imagem
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $pasta = '.src/uploads/';
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true); 
        }

        $extensao = pathinfo($_FILES['imagem']['name'], PATHINFO_EXTENSION);
        $nomeImagem = uniqid('img_', true) . '.' . $extensao;
        $caminhoFinal = $pasta . $nomeImagem;

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoFinal)) {
            $imagem_url = $caminhoFinal;
        } else {
            die("Erro ao salvar imagem.");
        }
    }

     //VERIFICA SE AS SENHAS SÃO IGUAIS
     if($senha !== $confirmar_senha){
        echo"<script>
        alert('As senhas não são iguais');
        window.location.href = '../pages/Create_User.php';
        </script>";
        exit;
     }

     //VALIDA SE A SENHA SEGUE ESSAS REGRAS
     if(strlen($senha) < 8){
        echo"<script>
        alert('A senha deve ter no minimo 8 caracteres'); 
         window.location.href = '../pages/Create_User.php';
        </script>";
        exit;
     } 

     if(!preg_match('/[A-Z]/', $senha)){
        echo"<script>
        alert('A senha deve ter pelo menos uma letra maiúscula');
         window.location.href = '../pages/Create_User.php';
        </script>";
        exit;
     }

    if(!preg_match('/[a-z]/', $senha)){
        echo"<script>
        alert('A senha deve ter pelo menos uma letra minúscula');
         window.location.href = '../pages/Create_User.php';
        </script>";
        exit;
     }

    if(!preg_match('/[0-9]/', $senha)){
        echo"<script>
        alert('A senha deve ter pelo menos um número');
         window.location.href = '../pages/Create_User.php';
        </script>";
        exit;
    }

     if(!preg_match('/[\W_]/', $senha)){
        echo"<script>
        alert('A senha deve ter pelo menos um caractere especial');
         window.location.href = '../pages/Create_User.php';
        </script>";
        exit;
     }

    // CONVERTE A SENHA PARA HASH
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

     try{
        $stmt = $pdo->prepare("INSERT INTO  usuarios (nome, senha, email, matricula, imagem_url) VALUES (:nome, :senha, :email, :matricula, :imagem_url) ");

        $stmt->execute([
            'nome'=>$nome,
            'senha'=>$senha_hash,
            'email'=>$email,
            'matricula'=>$matricula,
            'imagem_url'=>$imagem_url
        ]);

        header('Location:../pages/Dashboard_User.php');
        exit;
     }catch(PDOException $erro){
        error_log("[" . date('Y-m-d H:i:s') . "] Erro ao tentar criar usuário: " . $erro->getMessage() . "\n", 3, __DIR__ . '/../../logs/error.log');
    
   
    echo"<script>alert('Erro ao tentar criar usuário');</script>";
     }
     
}
?>