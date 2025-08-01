<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GestãoStock</title>
    <!-- LINK CSS  -->
    <link rel="stylesheet" href="./src/assets/css/index/Index.css">
    <!-- LINK FAVICON -->
    <link rel="shortcut icon" href="./src/assets/img/favicon_logo.ico" type="image/x-icon">
    <!-- LINK ICONS GOOGLE -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- LINK SCRIP LOGIN -->
     <script src="./src/scripts/Login.js" defer></script>
     <!-- LINK SCRIP FORM -->
     <script src="./src/scripts/Form.js" defer></script>
</head>

<body>
    <!-- HEADER -->
    <header>
        <nav>
            <!-- IMG LOGO -->
            <div id="imgLogo">
                <img src="./src/assets/img/logo.png" alt="Logo">
            </div>
            <span></span>
            <!-- BTN ENTRAR -->
            <div id="btnHeader">
                <button class="btnForm">quero conhecer</button>
                <a href="#" id="btnLogin">entrar</a>
            </div>
        </nav>
        <!-- MODAL LOGIN -->
             <div id="loginModal" class="modalLogin">
                <div class="modalContent">
                    <i class="material-icons" id="iconCancel">cancel</i>
                    <iframe src="./src/pages/login/Login.php" id='loginIframe' frameborder="0"></iframe>
                </div>
             </div>
        <!-- MODAL FORM CONTATO -->
            <div class="contactModalForm modalContac">
                <div class="modalContentForm">
                    <i class="material-icons" id="iconCancelForm">cancel</i>
                    <iframe src="./src/pages/form/Form.php" frameborder="0"></iframe>
                </div>
            </div>
    </header>
    <!-- MAIN -->
    <main>
        <section id="txtGestao">
            <h1>GestãoStock – O Controle Total da Sua Obra Começa Aqui</h1>
            <p>O sistema de gestão de estoque feito sob medida para a construção civil. Evite prejuízos, mantenha o controle dos seus equipamentos e tenha uma visão completa das suas finanças tudo em um só lugar.</p>
            <button class="btnForm">quero conhecer</button>
        </section>
        <!-- TXT CONTROLE -->
        <section id="txtControle">
            <h2> Controle absoluto dos seus equipamentos e técnicos</h2>
            <div id="container">
                <p>
                    Com o nosso sistema, você cadastra e acompanha os equipamentos mais utilizados na sua obra, mantendo um histórico completo. Evite paradas inesperadas com a criação e o gerenciamento de tarefas de manutenção. Além disso, tenha controle total sobre sua equipe com uma gestão de técnicos totalmente integrada. Tudo em um só lugar, de forma prática, eficiente e pensada para a construção civil.
                </p>
                <img src="./src/assets/img/img_controle.jpg" alt="Controle Estoque">
            </div>
        </section>
        <!-- TXT RELACIONAMENTO -->
        <section id="txtRelacionamento">
            <h2>Relacionamentos organizados, sem complicação</h2>
            <div id="container">
                <img src="./src/assets/img/img_fornecedores.jpg" alt="Fornecedores">
                <p>Gestão de fornecedores com dados sempre atualizados e fácil acesso. Cadastre e acompanhe clientes com histórico de serviços, pagamentos e equipamentos utilizados</p>
            </div>
            <button class="btnForm">quero conhecer</button>
        </section>
        <!-- TXT FINANCEIRO -->
        <section id="txtFinanceiro">
            <h2>Gestão financeira completa, com poucos cliques</h2>
            <div id="container">
                <div>
                    <i class="material-icons" class="iconVerified">verified</i>
                    <p>Visualize em tempo real suas contas a pagar e a receber</p>
                </div>
                <div>
                    <i class="material-icons" class="iconVerified">verified</i>
                    <p>Tenha controle detalhado das despesas e receitas totais</p>
                </div>
                <div>
                    <i class="material-icons" class="iconVerified">verified</i>
                    <p>Relatórios que ajudam na tomada de decisão estratégica</p>
                </div>
            </div>
        </section>
        <!-- TXT EFICIÊNCIA -->
        <section id="txtEficiencia">
            <h2>Eficiência, economia e organização para sua obra</h2>
            <div id="container">
                <p>
                    O GestãoStock centraliza tudo da sua obra em um painel simples, intuitivo e acessível de qualquer lugar.
                    Tenha controle total de estoque, equipamentos e tarefas, evitando desperdícios e melhorando a tomada de decisão.
                    Organize sua operação com eficiência, profissionalismo e mobilidade — tudo em um só sistema.
                </p>
                <img src="./src/assets/img/img_eficiencia.jpg" alt="Eficiência">
            </div>
        </section>
        <!-- TXT VALORES -->
        <section id="txtValores">
            <div id="container">
                <p>A partir de</p>
                <p id="valorMes">R$ 99,00 por mês</p>
                <span>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p>Sistema 100% online, sem instalações</p>
                    </label>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p>Acesso seguro de qualquer lugar e dispositivo</p>
                    </label>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p>Suporte ágil e especializado</p>
                    </label>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p>Atendimento humanizado sempre que precisar</p>
                    </label>
                </span>
                <button class="btnForm">quero conhecer</button>
            </div>
        </section>
        <!-- TXT PRONTO -->
        <section id="txtPronto">
            <h2>Pronto para levar sua gestão de estoque para o próximo nível?</h2>
            <div id="container">
                <p>Experimente agora o GestãoStock e transforme a maneira como você controla sua obra.</p>
                <span>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p> Mais controle</p>
                    </label>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p> Menos desperdício</p>
                    </label>
                    <label>
                        <i class="material-icons" class="iconCircle">check_circle</i>
                        <p> Resultados reais</p>
                    </label>
                </span>
                <p id="linkDemonstracao"><a href="https://www.figma.com/proto/tdMHyCaT8Eyc8Bj4Csouu1/Untitled?node-id=1-2&t=GPNio2uDfAR1Gr8W-0&scaling=scale-down&content-scaling=fixed&page-id=0%3A1&starting-point-node-id=25%3A11&show-proto-sidebar=1" target="_blank">👉 Acesse demonstração gratuita</a></p>
            </div>
        </section>
    </main>
    <!-- FOOTER -->
    <footer>
        <div id="logoFooter">
            <img src="./src/assets/img/logo_footer.png" alt="logo">
        </div>
        <p>Av.Sem Rua,400-Maceió-AL 0800 000 0000</p>
        <div id="redesSociais">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6C2 3.79086 3.79086 2 6 2H18C20.2091 2 22 3.79086 22 6V18C22 20.2091 20.2091 22 18 22H6C3.79086 22 2 20.2091 2 18V6ZM6 4C4.89543 4 4 4.89543 4 6V18C4 19.1046 4.89543 20 6 20H12V13H11C10.4477 13 10 12.5523 10 12C10 11.4477 10.4477 11 11 11H12V9.5C12 7.567 13.567 6 15.5 6H16.1C16.6523 6 17.1 6.44772 17.1 7C17.1 7.55228 16.6523 8 16.1 8H15.5C14.6716 8 14 8.67157 14 9.5V11H16.1C16.6523 11 17.1 11.4477 17.1 12C17.1 12.5523 16.6523 13 16.1 13H14V20H18C19.1046 20 20 19.1046 20 18V6C20 4.89543 19.1046 4 18 4H6Z" fill="#000000"></path>
                </g>
            </svg>
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M2 6C2 3.79086 3.79086 2 6 2H18C20.2091 2 22 3.79086 22 6V18C22 20.2091 20.2091 22 18 22H6C3.79086 22 2 20.2091 2 18V6ZM6 4C4.89543 4 4 4.89543 4 6V18C4 19.1046 4.89543 20 6 20H18C19.1046 20 20 19.1046 20 18V6C20 4.89543 19.1046 4 18 4H6ZM12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9ZM7 12C7 9.23858 9.23858 7 12 7C14.7614 7 17 9.23858 17 12C17 14.7614 14.7614 17 12 17C9.23858 17 7 14.7614 7 12ZM17.5 8C18.3284 8 19 7.32843 19 6.5C19 5.67157 18.3284 5 17.5 5C16.6716 5 16 5.67157 16 6.5C16 7.32843 16.6716 8 17.5 8Z" fill="#000000"></path>
                </g>
            </svg>
            <svg viewBox="0 0 76 76" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" baseProfile="full" enable-background="new 0 0 76.00 76.00" xml:space="preserve" fill="#000000">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path fill="#000000" fill-opacity="1" stroke-width="0.2" stroke-linejoin="round" d="M 52.6345,35.4799L 52.651,35.4806L 53.0632,35.4806C 55.9679,35.4806 58.3308,37.8127 58.3308,40.6788L 58.3308,40.7092L 58.3334,40.7392C 58.5256,43.2474 58.619,45.8695 58.6112,48.5327C 58.619,51.2007 58.5256,53.8228 58.3334,56.331L 58.3308,56.3611L 58.3308,56.3914C 58.3308,59.2579 55.5721,61.5898 52.6674,61.5898L 53.0304,61.5903C 48.391,61.784 43.081,61.8775 38.0293,61.8682C 32.9745,61.8775 27.6648,61.784 23.0254,61.5903L 23.3883,61.5898C 20.4836,61.5898 17.7247,59.2579 17.7247,56.3914L 17.7247,56.3611L 17.7224,56.331C 17.5301,53.8241 17.4366,51.202 17.4445,48.5372C 17.4366,45.8691 17.53,43.247 17.7224,40.7392L 17.7247,40.7092L 17.7247,40.6788C 17.7247,37.8127 20.4836,35.4806 23.3882,35.4806L 23.0253,35.4799C 27.664,35.2862 32.974,35.1928 38.0263,35.202C 43.0818,35.1928 47.9959,35.2862 52.6345,35.4799 Z M 50.6688,47.5132C 50.6688,46.9401 50.7567,46.5294 50.9337,46.281C 51.1102,46.0331 51.4009,45.9087 51.806,45.9087C 52.1936,45.9087 52.4759,46.0331 52.6528,46.281C 52.8293,46.5294 52.9176,46.9401 52.9176,47.5132L 52.9176,48.8991L 50.6688,48.8991L 50.6688,47.5132 Z M 55.5374,51.0244L 55.5374,47.5387C 55.5374,46.2393 55.2245,45.2434 54.5997,44.5507C 53.9744,43.8579 53.0797,43.5115 51.9152,43.5115C 50.7761,43.5115 49.847,43.8857 49.1281,44.6337C 48.4085,45.3821 48.0489,46.3501 48.0489,47.5387L 48.0489,53.684C 48.0489,55.0019 48.3764,56.0373 49.0313,56.7904C 49.6864,57.5432 50.5835,57.9197 51.7226,57.9197C 52.9898,57.9197 53.9426,57.5644 54.5806,56.8543C 55.2184,56.1441 55.5374,55.0873 55.5374,53.684L 55.5374,52.6557L 52.9176,52.6557L 52.9176,53.6072C 52.9176,54.4127 52.8335,54.9338 52.6656,55.1691C 52.4976,55.4047 52.2024,55.5224 51.7805,55.5224C 51.3749,55.5224 51.0885,55.3835 50.9205,55.1047C 50.7526,54.8262 50.6688,54.3269 50.6688,53.6072L 50.6688,51.0244L 55.5374,51.0244 Z M 43.5091,54.34C 43.5091,54.7764 43.4353,55.0911 43.2887,55.2835C 43.1419,55.4757 42.9128,55.5719 42.602,55.5719L 41.9862,55.4245L 41.3837,54.9434L 41.3837,46.4112L 41.9085,45.9941L 42.4464,45.8593C 42.7916,45.8593 43.0555,45.9794 43.2368,46.2188C 43.4185,46.4582 43.5091,46.8089 43.5091,47.2708L 43.5091,54.34 Z M 43.647,43.6845C 43.2522,43.6845 42.8624,43.7934 42.4764,44.0107C 42.0908,44.2286 41.7267,44.546 41.3837,44.9638L 41.3837,38.9888L 38.8134,38.9888L 38.8134,57.549L 41.3837,57.549L 41.3837,56.4965C 41.7181,56.9133 42.0805,57.222 42.4705,57.422C 42.8603,57.622 43.3041,57.722 43.8016,57.722C 44.5557,57.722 45.1322,57.4642 45.5307,56.9475C 45.9292,56.4308 46.129,55.6858 46.129,54.7123L 46.129,47.1166C 46.129,45.9983 45.9165,45.1465 45.4921,44.5618C 45.0677,43.9771 44.4526,43.6845 43.647,43.6845 Z M 33.7844,54.2502L 32.9975,54.9873C 32.7116,55.1797 32.4753,55.2754 32.2877,55.2754C 32.0487,55.2754 31.876,55.2027 31.7694,55.0575C 31.6629,54.9123 31.6096,54.6776 31.6096,54.353L 31.6096,43.8575L 29.064,43.8575L 29.064,55.3012C 29.064,56.1163 29.2132,56.7278 29.5117,57.1356C 29.8103,57.5432 30.2539,57.7468 30.8424,57.7468C 31.3196,57.7468 31.8124,57.6008 32.3197,57.3102C 32.8274,57.019 33.3152,56.5944 33.7844,56.0376L 33.7844,57.549L 36.3299,57.549L 36.3299,43.8575L 33.7844,43.8575L 33.7844,54.2502 Z M 29.0989,38.9888L 20.3006,38.9888L 20.3006,41.6826L 23.2664,41.6826L 23.2664,57.549L 26.133,57.549L 26.133,41.6826L 29.0989,41.6826L 29.0989,38.9888 Z M 24.4274,14.4817L 27.3146,14.4817L 29.1747,21.9004L 29.3547,21.9004L 31.1283,14.4817L 34.0411,14.4817L 30.7047,25.3403L 30.7047,33.0419L 27.8379,33.0419L 27.8379,25.6871L 24.4274,14.4817 Z M 36.5309,29.8344C 36.5309,30.2114 36.6213,30.5021 36.8028,30.7076C 36.9839,30.913 37.2426,31.0152 37.5793,31.0152C 37.9245,31.0152 38.1984,30.9106 38.4015,30.701C 38.6042,30.4912 38.7057,30.2026 38.7057,29.8344L 38.7057,22.3777C 38.7057,22.0785 38.6019,21.8367 38.3949,21.653C 38.1879,21.4691 37.9161,21.3768 37.5793,21.3768C 37.2688,21.3768 37.0163,21.4691 36.8221,21.653C 36.6279,21.8367 36.5309,22.0785 36.5309,22.3777L 36.5309,29.8344 Z M 33.9112,22.4805C 33.9112,21.4201 34.2537,20.5759 34.9391,19.9473C 35.6247,19.3186 36.5455,19.0043 37.7025,19.0043C 38.756,19.0043 39.619,19.3359 40.2917,19.9986C 40.9645,20.6612 41.3008,21.5142 41.3008,22.5577L 41.3008,29.6293C 41.3008,30.8011 40.9705,31.7203 40.311,32.3872C 39.6514,33.0542 38.7432,33.3877 37.5866,33.3877C 36.473,33.3877 35.5817,33.0433 34.9137,32.3552C 34.2453,31.667 33.9112,30.7413 33.9112,29.5781L 33.9112,22.4805 Z M 50.7274,19.3503L 50.7274,33.0419L 48.1819,33.0419L 48.1819,31.5304C 47.7127,32.0873 47.2246,32.5117 46.7172,32.8029C 46.2097,33.0936 45.717,33.2396 45.2397,33.2396C 44.6513,33.2396 44.2075,33.0361 43.9091,32.6281C 43.6105,32.2206 43.4615,31.6092 43.4615,30.794L 43.4615,19.3503L 46.0071,19.3503L 46.0071,29.8457C 46.0071,30.1705 46.0604,30.4051 46.1669,30.5503C 46.2735,30.6955 46.4461,30.7683 46.6852,30.7683C 46.8728,30.7683 47.1091,30.6723 47.3949,30.4801L 48.1819,29.7429L 48.1819,19.3503L 50.7274,19.3503 Z "></path>
                </g>
            </svg>
        </div>
    </footer>
    <script>
window.addEventListener('message', function(event) {
    if (event.data && event.data.action === 'reload-login-iframe') {
        const iframe = document.getElementById('loginIframe');
        const modal = document.getElementById('loginModal');

        if (iframe && modal) {
            // Recarrega o iframe
            iframe.src = './src/pages/login/Login.php?reload=' + new Date().getTime();

            // Garante que o modal esteja visível novamente (caso tenha sido afetado)
            modal.style.display = 'block';
        }
    }
});
</script>


</body>

</html>