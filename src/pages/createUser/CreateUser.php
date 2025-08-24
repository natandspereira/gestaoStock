<?php 
require_once '../../classes/Autoload.php';

// Instancia o banco de dados
$db = new Database();

// Obtém a conexão PDO
$pdo = $db->getConnection();

// Instancia a classe de criação de usuário com o PDO
$createUser = new CreateUser($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $createUser = new CreateUser($pdo);
        $createUser->newUser($_POST, $_FILES);

        echo "<script>
            alert('Usuário criado com sucesso!');
            window.location.href = '../../../index.php';
        </script>";
        exit;

    } catch (Exception $e) {
        echo "<script>alert('" . $e->getMessage() . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Usuário</title>
    <!-- LINK CSS -->
     <link rel="stylesheet" href="../../assets/css/createUser/CreateUser.css">
    <!-- LINK FAVICON -->
     <link rel="shortcut icon" href="../../assets/img/favicon_logo.ico" type="image/x-icon">
</head>
<body>
    <!-- HEADER -->
    <header>
        <div class="logo">
            <img src="../../assets/img/logo.png" alt="logo">
        </div>
    </header>
    <!-- FORMULÁRIO -->
    <form action="" method="post" enctype="multipart/form-data">
        <div class="container">
            <h3>Criar conta</h3>
            <p>Preencha o formulário abaixo para criar sua conta</p>
            <input type="text" name="nome" placeholder="seu nome" required>
            <input type="password" name="senha" placeholder="nova senha" required>
            <input type="password" name="confirmar_senha" placeholder="confirmar senha" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="text" name="matricula" placeholder="matricula" required>
            <input type="file" name="image" accept="image/*">
            <span>
                <input type="checkbox" id="inputCheckBox" required>
                <p id="termo-link">Li e concordo com os Termos de uso</p>
            </span>
            <button id="btnCadastrar">cadastrar</button>
            <button id="btnSair" formaction="../../../index.php" formnovalidate>sair</button>
        </div>
    </form>

     <!-- Modal -->
  <div id="termoModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>TERMO DE USO DO SOFTWARE DE GESTÃO DE ESTOQUE</h2>
      <p>Este Termo de Uso regula o uso do software de gestão de estoque ("Gestão Stock"). Ao acessar, instalar ou utilizar o Software, o usuário declara ter lido, compreendido e aceito todos os termos e condições aqui descritos.</p>
      
      <h3>1. Aceitação do Termo</h3>
      <p>O uso do Software está condicionado à aceitação plena deste Termo. Caso o usuário não concorde com qualquer condição aqui estabelecida, deverá abster-se de utilizar o Software.</p>
      
      <h3>2. Objeto</h3>
      <p>O presente Termo regula o uso do Software de gestão de estoque, destinado ao controle, organização e monitoramento de entradas, saídas e inventário de produtos em empresas ou comércios.</p>

      <h3>3. Licença de Uso</h3>
      <p>O desenvolvedor concede ao usuário uma licença limitada, revogável, não exclusiva e intransferível para uso do Software conforme contratado, exclusivamente para fins comerciais legítimos relacionados à gestão de estoque.</p>
      <p>É vedado:</p>
      <ul>
        <li>Copiar, modificar, adaptar, traduzir ou criar obras derivadas do Software;</li>
        <li>Realizar engenharia reversa, descompilação ou desmontagem do Software;</li>
        <li>Ceder, sublicenciar, alugar, vender ou distribuir o Software a terceiros.</li>
      </ul>

      <h3>4. Cadastro e Acesso</h3>
      <p>O acesso ao Software poderá requerer cadastro prévio com informações verdadeiras, completas e atualizadas. O usuário é responsável pela segurança de suas credenciais de acesso.</p>

      <h3>5. Obrigações do Usuário</h3>
      <p>O usuário compromete-se a:</p>
      <ul>
        <li>Utilizar o Software conforme este Termo e a legislação aplicável;</li>
        <li>Não utilizar o Software para fins ilícitos ou que infrinjam direitos de terceiros;</li>
        <li>Garantir a veracidade das informações inseridas no sistema.</li>
      </ul>

      <h3>6. Limitação de Responsabilidade</h3>
      <p>O desenvolvedor não se responsabiliza por:</p>
      <ul>
        <li>Danos diretos, indiretos, incidentais ou consequentes decorrentes do uso ou da impossibilidade de uso do Software;</li>
        <li>Perda de dados, lucros ou outras perdas resultantes de falhas no sistema, uso indevido ou mau uso do Software;</li>
        <li>Problemas causados por terceiros ou por indisponibilidade da internet.</li>
      </ul>

      <h3>7. Propriedade Intelectual</h3>
      <p>Todos os direitos relacionados ao Software, incluindo seu código-fonte, interface, design, nome comercial, logotipos e funcionalidades, pertencem exclusivamente ao desenvolvedor. O uso do Software não implica em qualquer cessão de direitos de propriedade intelectual.</p>

      <h3>8. Atualizações e Modificações</h3>
      <p>O desenvolvedor poderá, a qualquer momento, atualizar ou modificar o Software, suas funcionalidades ou este Termo. As alterações entrarão em vigor imediatamente após a publicação. O uso contínuo do Software implica aceitação das modificações.</p>

      <h3>9. Privacidade e Proteção de Dados</h3>
      <p>As informações fornecidas pelo usuário serão tratadas conforme a Política de Privacidade, em conformidade com a Lei Geral de Proteção de Dados (LGPD - Lei nº 13.709/2018).</p>

      <h3>10. Vigência e Rescisão</h3>
      <p>Este Termo vige por prazo indeterminado, podendo ser rescindido:</p>
      <ul>
        <li>Por qualquer das partes, a qualquer momento, mediante notificação;</li>
        <li>Pelo desenvolvedor, em caso de violação das disposições aqui descritas.</li>
      </ul>

      <h3>11. Disposições Gerais</h3>
      <p>Este Termo é regido pelas leis da República Federativa do Brasil. Fica eleito o foro da comarca de Maceió/Alagoas, com exclusão de qualquer outro, por mais privilegiado que seja, para dirimir quaisquer dúvidas oriundas deste Termo.</p>
    </div>
  </div>

   <script>
    // Abrir modal
    document.getElementById("termo-link").onclick = function() {
      document.getElementById("termoModal").style.display = "block";
    };

    // Fechar modal clicando no X
    document.querySelector(".close").onclick = function() {
      document.getElementById("termoModal").style.display = "none";
    };

    // Fechar modal clicando fora do conteúdo
    window.onclick = function(event) {
      let modal = document.getElementById("termoModal");
      if (event.target === modal) {
        modal.style.display = "none";
      }
    };
  </script>
</body>
</html>