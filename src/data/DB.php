<?php 
require __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

$host = $_ENV['DB_HOST'];   
$user = $_ENV['DB_USER'];
$pwd  = $_ENV['DB_PASSWORD'];
$db   = $_ENV['DB_NAME'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pwd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $erro) {
   
    error_log("[" . date('Y-m-d H:i:s') . "] Erro ao conectar ao banco de dados: " . $erro->getMessage() . "\n", 3, __DIR__ . '/../../logs/error.log');
    
   
    echo "Ocorreu um erro. Por favor, tente novamente mais tarde.";
}
?>
