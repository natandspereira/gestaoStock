<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de clientes</title>
    <!-- LINK CSS  -->
    <link rel="stylesheet" href="../../../assets/css/registerCustomers/RegisterCustomers.css?=1.1">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="./src/assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<!-- cadastro_clientes => nome | cpf_cnpj | email | telefone | rua | numero | bairro | cidade | estado | cep | imagem_url -->
<body>
    <main>
        <form action="">
            <h2>cadastro de clientes</h2>
            <span>
                <i class="material-icons" id="iconNameForm">domain</i>
                <input type="text" name="nome" placeholder="nome da empresa">
            </span>
            <span>
                <i class="material-icons" id="iconCpfForm">article</i>
                <input type="text" name="cpf_cnpj" placeholder="CPF/CNPJ">
            </span>
            <span>
                <i class="material-icons" id="iconEmailForm">alternate_email</i>
                <input type="text" name="email" placeholder="email">
            </span>
            <span>
                <i class="material-icons" id="iconTelephoneForm">call</i>
                <input type="text" name="telefone" placeholder="telefone">
            </span>
            <div id="address">
                <h2>endereço</h2>
                <span>
                    <input type="text" name="estado" placeholder="estado">
                    <input type="text" name="cep" placeholder="cep">
                </span>
                <span>
                    <input type="text" name="rua" placeholder="rua">
                    <input type="text" name="bairro" placeholder="bairro">
                </span>
                <span>
                    <input type="text" name="numero" placeholder="numero">
                    <input type="text" name="cidade" placeholder="cidade">
                </span>
            </div>
            <button id="register">cadastrar</button>
            <button id="toGoOut">sair</button>
        </form>
    </main>
</body>

</html>