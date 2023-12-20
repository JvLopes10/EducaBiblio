<?php
// excluir_aluno.php

if (isset($_GET['id'])) {
    $IdTurma = $_GET['id'];

    // Incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Criar uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Desativar a verificação de chaves estrangeiras temporariamente
        $conn->exec('SET FOREIGN_KEY_CHECKS = 0;');

        // Excluir registros de devolução associados aos empréstimos dos alunos da turma específica
        $sqlExcluirDevolucoes = "DELETE devolucao FROM devolucao
                                INNER JOIN emprestimo ON devolucao.emprestimo_idEmprestimo = emprestimo.idEmprestimo
                                INNER JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
                                WHERE aluno.Turma_idTurma = :IdTurma";
        $stmtExcluirDevolucoes = $conn->prepare($sqlExcluirDevolucoes);
        $stmtExcluirDevolucoes->bindParam(':IdTurma', $IdTurma);
        $stmtExcluirDevolucoes->execute();

        // Excluir registros de empréstimo associados aos alunos da turma específica
        $sqlExcluirEmprestimos = "DELETE emprestimo FROM emprestimo
                                INNER JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
                                WHERE aluno.Turma_idTurma = :IdTurma";
        $stmtExcluirEmprestimos = $conn->prepare($sqlExcluirEmprestimos);
        $stmtExcluirEmprestimos->bindParam(':IdTurma', $IdTurma);
        $stmtExcluirEmprestimos->execute();

        // Excluir os alunos associados à turma
        $sqlExcluirAlunos = "DELETE FROM aluno WHERE Turma_idTurma = :IdTurma";
        $stmtExcluirAlunos = $conn->prepare($sqlExcluirAlunos);
        $stmtExcluirAlunos->bindParam(':IdTurma', $IdTurma);
        $stmtExcluirAlunos->execute();

        // Excluir a turma
        $sqlExcluirTurma = "DELETE FROM turma WHERE IdTurma = :IdTurma";
        $stmtExcluirTurma = $conn->prepare($sqlExcluirTurma);
        $stmtExcluirTurma->bindParam(':IdTurma', $IdTurma);
        $stmtExcluirTurma->execute();

        // Reativar a verificação de chaves estrangeiras
        $conn->exec('SET FOREIGN_KEY_CHECKS = 1;');

        // Verificar se a exclusão da turma foi realizada com sucesso
        if ($stmtExcluirTurma->rowCount() > 0) {
            // Redirecionar de volta para a página de turmas após a exclusão
            header("Location: ../view/turma.php");
            exit();
        } else {
            header("Location: ../view/turma.php");
            echo "Não foi possível excluir a turma.";
        }
    } catch (PDOException $e) {
        echo "Erro ao excluir turma e suas dependências: " . $e->getMessage();
    }
} else {
    echo "ID da turma não fornecido.";
    exit();
}
?>
