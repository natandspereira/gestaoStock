<?php 
require_once __DIR__ . '/../../vendor/autoload.php';

use Dotenv\Dotenv;

// CARREGA AS VARIÁVEIS DE AMBIENTE
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

class Database{
private $db_host='';
private $db_name='';
private $db_user='';
private $db_passwd='';
private $pdo;

function __construct()
{
    $this->db_host = $_ENV['DB_HOST'] ?? '';
    $this->db_name = $_ENV['DB_NAME'] ?? '';
    $this->db_user = $_ENV['DB_USER'] ?? '';
    $this->db_passwd = $_ENV['DB_PASSWD'] ?? '';
    
    $this->connect();
}

function connect(){
    try{
        $this->pdo = new PDO("mysql:host={$this->db_host};dbname={$this->db_name};charset=utf8", $this->db_user, $this->db_passwd);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }catch (PDOException $erro){
        echo "Erro ao tentar conectar com o banco de dados" . $erro->getMessage();
    }

}

function getConnection(){
    return $this->pdo;
}

}
?>