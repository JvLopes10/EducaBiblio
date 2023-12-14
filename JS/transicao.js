// Função para redirecionar após a animação
function redirect() {
    setTimeout(function() {
        window.location.href = "View/login.php";
    }, 1000); // Tempo de espera de 1 segundo após o término da animação
}

// Aguarde até que a página seja carregada
window.addEventListener("load", function() {
    // Inicie a animação
    const transitionContainer = document.querySelector(".transition-container");
    const logo = document.querySelector(".logo");

    transitionContainer.style.animationPlayState = "running";
    logo.style.animationPlayState = "running";

    // Adicione um evento de término de animação para iniciar o redirecionamento suave
    logo.addEventListener("animationend", redirect);
});