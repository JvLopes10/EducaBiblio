document.addEventListener("DOMContentLoaded", function() {
    const escolhaSelect = document.getElementById("escolha");
    const nomeAlunoInput = document.getElementById("NomeAluno");
    const emailAlunoInput = document.getElementById("EmailAluno");
    const nomeProfInput = document.getElementById("NomeProf");
    const emailProfInput = document.getElementById("EmailProf");
    const turmaInput = document.getElementById("Turma_idTurma");
    const materiaProfInput = document.getElementById("MateriaProf");

    function mostrarCamposAluno() {
        nomeAlunoInput.removeAttribute("hidden");
        emailAlunoInput.removeAttribute("hidden");
        turmaInput.removeAttribute("hidden");
        materiaProfInput.setAttribute("hidden", "hidden");
        nomeProfInput.setAttribute("hidden", "hidden");
        emailProfInput.setAttribute("hidden", "hidden");
        materiaProfInput.removeAttribute("required");
    }

    function mostrarCamposProfessor() {
        nomeAlunoInput.setAttribute("hidden", "hidden");
        emailAlunoInput.setAttribute("hidden", "hidden");
        turmaInput.setAttribute("hidden", "hidden");
        materiaProfInput.removeAttribute("hidden");
        nomeProfInput.removeAttribute("hidden");
        emailProfInput.removeAttribute("hidden");
        materiaProfInput.setAttribute("required", "required");
    }

    function atualizarCamposComEscolha() {
        if (escolhaSelect.value === "Aluno") {
            mostrarCamposAluno();
        } else if (escolhaSelect.value === "Professor") {
            mostrarCamposProfessor();
        }
    }

    escolhaSelect.addEventListener("change", atualizarCamposComEscolha);
    atualizarCamposComEscolha(); // Chama a função para garantir que os campos estejam corretos no carregamento da página.
});