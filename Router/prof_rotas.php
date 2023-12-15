<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["NomeProf"]) && isset($_POST["EmailProf"]) && isset($_POST["MateriaProf"])) {
        require_once "../Controller/CCad_prof.php";
        $cadProfessor = new CCad_prof();
        $cadProfessor->cadastrarProfessor($_POST["NomeProf"], $_POST["EmailProf"], $_POST["MateriaProf"]);
        header("Location: ../view/prof.php"); // Redireciona para a página correta após o cadastro do professor
    } else {
        echo "Preencha todos os campos!";
    }
}
?>
