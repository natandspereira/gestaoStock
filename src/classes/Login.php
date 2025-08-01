<?php
require_once 'Autoload.php'; //CARREGAMENTO DAS CLASSES DE FORMA AUTOMATICA

class Login
{

    private $pdo;

    //INICIA A CONEXÃO COM O DB
    public function __construct()
    {
        //INSTANCIA A CLASSE DATABASE E OBTÉM A CONEXÃO COM O PDO
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    //FUNÇÃO PARA FAZER O LOGIN
    public function autenticar($matricula, $senha)
    {
        //SANITIZA AS ENTRADAS
        $matricula = trim($matricula);
        $senha = trim($senha);

        if (empty($matricula) || empty($senha)) {
            return ['erro' => 'Por favor, preencha todos os campos.'];
        }

        try {
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE matricula = :matricula");
            $stmt->execute(['matricula' => $matricula]);

            //VERIFICA SE O USUÁRIO FOI ENCONTRADO
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                //SALVA A MATRÍCULA DO USUÁRIO NA SESSÃO SE O LOGIN FOR BEM-SUCEDIDO
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'matricula' => $usuario['matricula'],
                    'nome' => $usuario['nome'] ?? '' 
                ];
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Credenciais inválidas.'];
            }
        } catch (PDOException $erro) {
            //SE ACONTECER ERRO NA CONEXÃO COM O BANCO
            error_log("[" . date('Y-m-d H:i:s') . "] Erro ao tentar logar: " . $erro->getMessage() . "\n", 3, __DIR__ . '/../../logs/error.log');
            return ['erro' => 'Erro interno no sistema. Tente novamente mais tarde.'];
        }
    }
}
