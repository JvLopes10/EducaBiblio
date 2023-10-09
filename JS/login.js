// Seleciona os elementos do HTML pelos seus IDs ou classes e atribui-os a variáveis
const sign_in_btn = document.querySelector("#sign-in-btn"); // Botão de login
const sign_up_btn = document.querySelector("#sign-up-btn"); // Botão de cadastro
const container = document.querySelector(".container"); // Contêiner que envolve os formulários de login e cadastro

// Adiciona um ouvinte de evento ao botão de cadastro
sign_up_btn.addEventListener("click", () => {
  container.classList.add("sign-up-mode"); // Adiciona a classe "sign-up-mode" ao contêiner para alternar para o modo de cadastro
});

// Adiciona um ouvinte de evento ao botão de login
sign_in_btn.addEventListener("click", () => {
  container.classList.remove("sign-up-mode"); // Remove a classe "sign-up-mode" do contêiner para alternar de volta para o modo de login
});

// Função para alternar a visibilidade da senha
function togglePasswordVisibility() {
  const passwordInput = document.getElementById("SenhaUsuario"); // Seleciona o elemento de entrada de senha pelo seu ID
  const togglePassword = document.getElementById("togglePassword"); // Seleciona o ícone de alternar senha pelo seu ID

  if (passwordInput.type === "password") {
    passwordInput.type = "text"; // Muda o tipo de entrada de senha para texto, tornando-a visível
    togglePassword.classList.add("visible"); // Adicione a classe "visible" ao ícone do olho para indicar que a senha está visível
  } else {
    passwordInput.type = "password"; // Muda o tipo de entrada de senha de volta para senha, ocultando-a
    togglePassword.classList.remove("visible"); // Remove a classe "visible" do ícone do olho para indicar que a senha está oculta
  }
}

// Adiciona um ouvinte de evento ao ícone do olho para alternar a visibilidade da senha
document.getElementById("togglePassword").addEventListener("click", togglePasswordVisibility);