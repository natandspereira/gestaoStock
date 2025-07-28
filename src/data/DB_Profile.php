<?php 
include '../data/DB.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){


    try{
        $stmt = $pdo->prepare("SELECT * FROM usuarios");
        $stmt->execute();
        $usuarios = $stmt->fetchAll(); 
    }catch(PDOException $erro){
        
    }
};
?>

