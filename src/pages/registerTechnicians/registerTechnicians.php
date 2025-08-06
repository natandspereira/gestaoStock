<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Técnico</title>
    <!-- LINK CSS -->
    <link rel="stylesheet" href="../../assets/css/registerTechnicians/registerTechnicians.css">
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- GOOGLE ICONS -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body>
    <form id="registerTechniciansForm" method="POST" enctype="multipart/form-data">
        <section class="title">
            <h1>Cadastro de Técnico</h1>
            <p>Preencha os dados para registar um novo técnico no sistema</p>
        </section>
        <section class="data">
            <div id="personalData">
                <h3>Dados Pessoais</h3>
                <label for="">
                    <input type="text" placeholder="nome completo" required>
                </label>
                <label for="">
                    <input type="email" placeholder="email">
                </label>
                <label for="">
                    <input type="text" placeholder="telefone" required>
                </label>
            </div>

            <div id="address">
                <h3>Endereço</h3>
                <label for="">
                    <input type="text" placeholder="rua">
                </label>
                <label for="">
                    <input type="text" placeholder="cep">
                </label>
                <label for="">
                    <input type="text" placeholder="bairro">
                </label>
                <label for="">
                    <input type="text" placeholder="cidade">
                </label>
                <label for="">
                    <input type="text" placeholder="estado">
                </label>

            </div>

            <div id="technicianDetails">
                <h3>Dados do Técnico</h3>
                <label for="">
                    <input type="text" placeholder="tipo de técnico">
                </label>
                <label for="">
                    <input type="text" placeholder="número de matrícula">
                </label>
                <label for="">
                    <input type="text" placeholder="senha">
                </label>
            </div>
            <div id="imgProfile">
                <input type="file" id="file" class="teste" name="imagem" accept="image/*">
            </div>
            <div id="btn">
                <button>registrar técnico</button>
            </div>
        </section>
    </form>
</body>

</html>