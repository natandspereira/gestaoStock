
document.addEventListener('DOMContentLoaded', function () {
    const cepInput = document.getElementById('cep');

    // Dispara busca de CEP ao sair do campo
    cepInput.addEventListener('blur', function () {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length !== 8) return;

        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then(response => response.json())
            .then(data => {
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                } else {
                    exibirMensagem("CEP não encontrado.", "error");
                }
            })
            .catch(() => {
                exibirMensagem("Erro ao buscar o CEP.", "error");
            });
    });

    // Função para exibir mensagens estilizadas
    function exibirMensagem(texto, tipo = 'info') {
        const msg = document.createElement('div');
        msg.classList.add('mensagem', tipo);
        msg.textContent = texto;
        document.body.appendChild(msg);

        setTimeout(() => {
            msg.remove();
        }, 3000);
    }
});

