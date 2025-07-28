console.log('teste perfil');

function exibirPerfil(){
    document.addEventListener('DOMContentLoaded', function () {
    const btnPerfil = document.getElementById('perfil');
    const conteudoPerfil = document.getElementById('conteudoPerfil');
    

    btnPerfil.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        

        fetch('Profile.php')
            .then(response => {
                if (!response.ok) throw new Error('Erro ao carregar o conteúdo.');
                return response.text();
            })
            .then(data => {
                conteudoPerfil.innerHTML = data;
                conteudoPerfil.style.display = 'flex'; // Mostra conteúdo de evento
            })
            .catch(error => {
                conteudoPerfil.innerHTML = '<p>Erro ao carregar a página de eventos.</p>';
                conteudoPerfil.style.display = 'flex';
                console.error(error);
            });
    });
});
}

exibirPerfil();