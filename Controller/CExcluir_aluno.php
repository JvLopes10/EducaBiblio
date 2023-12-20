<?php
// Verifica se o ID do aluno foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $IdAluno = $_GET['id'];

    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Desativa a verificação de chave estrangeira temporariamente para poder deletar as referências
        $conn->exec("SET FOREIGN_KEY_CHECKS=0");

        // Deleta as referências na tabela de devolução
        $stmtDeletarDevolucao = $conn->prepare("DELETE FROM devolucao WHERE emprestimo_idEmprestimo IN (SELECT idEmprestimo FROM emprestimo WHERE aluno_idAluno = :IdAluno)");
        $stmtDeletarDevolucao->bindParam(':IdAluno', $IdAluno);
        $stmtDeletarDevolucao->execute();

        // Deleta as referências na tabela de empréstimo
        $stmtDeletarEmprestimo = $conn->prepare("DELETE FROM emprestimo WHERE aluno_idAluno = :IdAluno");
        $stmtDeletarEmprestimo->bindParam(':IdAluno', $IdAluno);
        $stmtDeletarEmprestimo->execute();

        // Agora, deleta o aluno
        $stmtDeletarAluno = $conn->prepare("DELETE FROM aluno WHERE IdAluno = :IdAluno");
        $stmtDeletarAluno->bindParam(':IdAluno', $IdAluno);
        $stmtDeletarAluno->execute();

        // Reativa a verificação de chave estrangeira
        $conn->exec("SET FOREIGN_KEY_CHECKS=1");

        // Redireciona de volta para a página de alunos após a exclusão
        header("Location: ../view/aluno.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro na exclusão do aluno: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro ou redireciona para outra página
    echo "ID do aluno não fornecido.";
    // Ou redirecione para a página de alunos ou outra página
    // header("Location: alguma_pagina.php");
    exit();
}
?>
