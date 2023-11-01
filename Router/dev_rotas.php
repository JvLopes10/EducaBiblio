<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $turma = $_POST['turma'];
    $aluno = $_POST['aluno'];

    // Aqui você pode incluir o arquivo do controlador e chamar as funções do controlador
    require_once('../Controller/CDev_livros.php');

    $controller = new EmpréstimoController();

    $alunosDaTurma = $controller->listarAlunosDaTurma($turma);
    $empréstimosDoAluno = $controller->listarEmpréstimosDoAluno($aluno);

    // Agora, você pode redirecionar de volta para o arquivo de formulário e incluir os resultados
    header('Location: index.php?turma=' . $turma . '&aluno=' . $aluno);
    exit;
}
?>
