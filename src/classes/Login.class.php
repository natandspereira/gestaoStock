<?php
require_once 'Autoload.php'; // Garante o carregamento das classes automaticamente

class Login
{

    private $pdo;

    // Construtor que inicializa a conexão com o banco de dados
    public function __construct()
    {
        // Instancia a classe Database e obtém a conexão PDO
        $db = new Database();
        $this->pdo = $db->getConnection();
    }

    // Função para realizar o login
    public function autenticar($matricula, $senha)
    {
        // Sanitiza as entradas
        $matricula = trim($matricula);
        $senha = trim($senha);

        if (empty($matricula) || empty($senha)) {
            return ['erro' => 'Por favor, preencha todos os campos.'];
        }

        try {
            // Prepara a consulta SQL para buscar o usuário pelo matrícula
            $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE matricula = :matricula");
            $stmt->execute(['matricula' => $matricula]);

            // Verifica se o usuário foi encontrado
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($usuario && password_verify($senha, $usuario['senha'])) {
                // Se o login for bem-sucedido, salva a matrícula do usuário na sessão
                $_SESSION['usuario'] = [
                    'id' => $usuario['id'],
                    'matricula' => $usuario['matricula'],
                    'nome' => $usuario['nome'] ?? '' 
                ];

                // Retorna o sucesso do login
                return ['sucesso' => true];
            } else {
                return ['erro' => 'Credenciais inválidas.'];
            }
        } catch (PDOException $erro) {
            // Em caso de erro na conexão com o banco
            error_log("[" . date('Y-m-d H:i:s') . "] Erro ao tentar logar: " . $erro->getMessage() . "\n", 3, __DIR__ . '/../../logs/error.log');
            return ['erro' => 'Erro interno no sistema. Tente novamente mais tarde.'];
        }
    }
}
