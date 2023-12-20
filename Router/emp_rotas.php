<?php
include '../Controller/CEmp_livros.php';
include '../Controller/CEmp_livroprof.php'; // Inclua o controlador específico para professores

// Verifica o tipo de usuário (professor ou aluno)
$turmaId = $_POST['Turma_idTurma'];

if ($turmaId == '0') {
    // Se for professor
    $emprestimoControllerProf = new CEmprestimoControllerProf();
    $emprestimoControllerProf->emprestarLivro();
    header("Location: ../View/emprestimos.php");
} else {
    // Se for aluno
    $emprestimoController = new CEmprestimoController();
    $emprestimoController->emprestarLivro();
    header("Location: ../View/emprestimos.php");
}
?>
