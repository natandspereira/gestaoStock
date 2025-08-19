<?php
session_start();

// Se houver um POST confirmando logout via fetch
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout_confirm'])) {
    session_unset();
    session_destroy();
    
    // Redirecionamento absoluto para raiz
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $redirect = $protocol . $host . '/gestaoStock/index.php';

    echo json_encode(['status' => 'success', 'redirect' => $redirect]);
    exit;
}

// Apenas retorna o modal se for solicitado via AJAX
if (isset($_GET['modal_only']) && $_GET['modal_only'] == 1): ?>
    <div id="modalSair" class="modal">
        <div class="modal-content">
            <p>Tem certeza que deseja sair?</p>
            <div class="modal-buttons">
                <button id="btnConfirmarSair" class="btn btn-confirm">Sim</button>
                <button id="cancelarSair" class="btn btn-cancel">Não</button>
            </div>
        </div>
    </div>

    <script>
        const modalSair = document.getElementById('modalSair');
        const btnConfirmarSair = document.getElementById('btnConfirmarSair');
        const cancelarSair = document.getElementById('cancelarSair');

        // Confirma logout via fetch
        btnConfirmarSair.addEventListener('click', () => {
            fetch(window.location.href.split('?')[0], { // Usa a URL do próprio Logout.php
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'logout_confirm=1'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    window.location.href = data.redirect; // Redireciona para index.php
                }
            });
        });

        // Cancela logout
        cancelarSair.addEventListener('click', () => {
            modalSair.style.display = 'none';
        });

        // Fecha modal ao clicar fora
        window.addEventListener('click', (e) => {
            if (e.target === modalSair) {
                modalSair.style.display = 'none';
            }
        });
    </script>
<?php
endif;
?>
