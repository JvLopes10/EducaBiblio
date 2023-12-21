<?php
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['emprestar'])) {
    // Importe a classe responsável pela atualização do empréstimo
    require_once('CAtualizarEmprestimo.php'); // Verifique o nome correto do arquivo

    // Recupere os dados do formulário
    $idEmprestimo = $_POST['idEmprestimo'];
    $Genero_idGenero = $_POST['Genero_idGenero'];
    $livro_idLivro = $_POST['livro_idLivro'];
    $Turma_idTurma = $_POST['Turma_idTurma'];
    $aluno_idAluno = $_POST['aluno_idAluno'];
    $prof_idProf = $_POST['prof_idProf'];
    $DataEmprestimo = $_POST['DataEmprestimo'];
    $quantidade = $_POST['quantidade'];
    $data = $_POST['data'];
    $usuario_idUsuario = $_POST['usuario_idUsuario'];

    // Crie uma instância da classe para atualizar o empréstimo
    $atualizacaoEmprestimo = new CAtualizarEmprestimo();

    // Chame o método para atualizar o empréstimo
    $resultadoAtualizacao = $atualizacaoEmprestimo->atualizarEmprestimo(
        $idEmprestimo,
        $Genero_idGenero,
        $livro_idLivro,
        $Turma_idTurma,
        $aluno_idAluno,
        $prof_idProf,
        $DataEmprestimo,
        $quantidade,
        $data,
        $usuario_idUsuario
    );

    if ($resultadoAtualizacao) {
        // Redirecione para alguma página de sucesso após a atualização
        header("Location: ../view/emprestimos.php");
        exit();
    } else {
        // Se houver um erro na atualização, redirecione para uma página de erro ou faça alguma outra gestão
        header("Location: ../view/emprestimos.php");
        exit();
    }
} else {
    // Redirecione para alguma página de erro, pois parece que o envio do formulário não foi corretamente tratado
    header("Location: ../view/emprestimos.php");
    exit();
}
?>
