document.addEventListener('DOMContentLoaded', function () {
  const menu = document.getElementById('menuUsuario');
  const iconMenu = document.getElementById('iconMenu');

  // Abrir menu
  iconMenu.addEventListener('click', function () {
    menu.classList.add('ativo');
    document.body.classList.add('menu-aberto');
  });

  // Fechar menu ao clicar fora
  document.addEventListener('click', function (e) {
    const isClickInside = menu.contains(e.target) || iconMenu.contains(e.target);
    if (!isClickInside) {
      menu.classList.remove('ativo');
      document.body.classList.remove('menu-aberto');
    }
  });

  // Mapeamento dos botões e seus conteúdos
  const botoes = [
    { id: 'perfil', div: 'conteudoPerfil', url: 'Profile.php' },
    { id: 'clientes', div: 'conteudoClientes', url: 'Customers.php' },
    { id: 'tecnicos', div: 'conteudoTecnicos', url: 'Technicians.php' },
    { id: 'equipamentos', div: 'conteudoEquipamentos', url: 'Equipment.php' },
    { id: 'fornecedores', div: 'conteudoFornecedores', url: 'Suppliers.php' },
    { id: 'suporte', div: 'conteudoSuporte', url: 'Support.php' }
  ];

  botoes.forEach(botao => {
    const btn = document.getElementById(botao.id);
    const div = document.getElementById(botao.div);

    if (btn && div) {
      btn.addEventListener('click', function (e) {
        e.stopPropagation();

        // Fecha o menu após clicar
        menu.classList.remove('ativo');
        document.body.classList.remove('menu-aberto');

        // Esconde todos os conteúdos
        document.querySelectorAll('.conteudo').forEach(c => c.classList.remove('ativo'));

        // Carrega conteúdo
        fetch(botao.url)
          .then(res => {
            if (!res.ok) throw new Error('Erro ao carregar conteúdo');
            return res.text();
          })
          .then(html => {
            div.innerHTML = html;
            div.classList.add('ativo');
          })
          .catch(err => {
            div.innerHTML = '<p>Erro ao carregar o conteúdo.</p>';
            div.classList.add('ativo');
          });
      });
    }
  });
});
