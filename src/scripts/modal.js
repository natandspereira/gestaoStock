document.addEventListener("DOMContentLoaded", function () {
    const abrirBtns = document.querySelectorAll(".abrirModal");
    const fecharBtn = document.getElementById("fecharModal");
    const modal = document.getElementById("modal");

    abrirBtns.forEach(function (btn) {
        btn.addEventListener("click", function () {
            modal.style.display = "flex";
        });
    });

    fecharBtn.addEventListener("click", function () {
        modal.style.display = "none";
    });

    window.addEventListener("click", function (event) {
        if (event.target === modal) {
            modal.style.display = "none";
        }
    });
});
