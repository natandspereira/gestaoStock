 

function logOut(){
    const btnLogout = document.getElementById('sair');
    btnLogout.addEventListener('click', ()=>{
        window.location.href = "../data/DB_Logout.php";
    });
}

logOut();