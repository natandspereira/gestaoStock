 

function logOut() {
  const btnLogout = document.getElementById('sair');

  btnLogout.addEventListener('click', () => {
    const confirmar = window.confirm('Deseja realmente sair?');

    if (confirmar) {
      // Redireciona para o logout (que destruirá a sessão e redirecionará para index.php)
      window.location.href = "../data/DB_Logout.php";
    }
    // Se cancelar, nada acontece
  });
}

logOut();
