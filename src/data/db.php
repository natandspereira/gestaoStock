<?php 
require __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pwd = $_ENV['DB_PASSWORD'];
$db = $_ENV['DB_NAME'];

try{
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $erro){
    echo "Erro ao conectar com o banco de dados. Por favor, tente novamente mais tarde.";

    error_log(date('[Y-m-d H:i:s]') . $error->getMessage() . "\n", 3, __DIR__ . '/log.txt');
}

?>