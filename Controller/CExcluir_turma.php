<?php
// excluir_aluno.php

if (isset($_GET['id'])) {
    $IdAluno = $_GET['id'];

    // Incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Criar uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Desativar temporariamente a verificação de chaves estrangeiras
        $conn->exec('SET FOREIGN_KEY_CHECKS = 0;');

        // Excluir registros de devolução associados aos empréstimos do aluno específico
        $sqlExcluirDevolucoes = "DELETE devolucao FROM devolucao
                                INNER JOIN emprestimo ON devolucao.emprestimo_idEmprestimo = emprestimo.idEmprestimo
                                WHERE emprestimo.aluno_idAluno = :IdAluno";
        $stmtExcluirDevolucoes = $conn->prepare($sqlExcluirDevolucoes);
        $stmtExcluirDevolucoes->bindParam(':IdAluno', $IdAluno);
        $stmtExcluirDevolucoes->execute();

        // Excluir registros de empréstimo associados ao aluno específico
        $sqlExcluirEmprestimos = "DELETE FROM emprestimo WHERE aluno_idAluno = :IdAluno";
        $stmtExcluirEmprestimos = $conn->prepare($sqlExcluirEmprestimos);
        $stmtExcluirEmprestimos->bindParam(':IdAluno', $IdAluno);
        $stmtExcluirEmprestimos->execute();

        // Excluir o aluno
        $sqlExcluirAluno = "DELETE FROM aluno WHERE idAluno = :IdAluno";
        $stmtExcluirAluno = $conn->prepare($sqlExcluirAluno);
        $stmtExcluirAluno->bindParam(':IdAluno', $IdAluno);
        $stmtExcluirAluno->execute();

        // Reativar a verificação de chaves estrangeiras
        $conn->exec('SET FOREIGN_KEY_CHECKS = 1;');

        // Verificar se a exclusão do aluno foi realizada com sucesso
        if ($stmtExcluirAluno->rowCount() > 0) {
            // Redirecionar de volta para a página de alunos após a exclusão
            header("Location: ../view/alunos.php");
            exit();
        } else {
            echo "Falha ao excluir o aluno.";
        }
    } catch (PDOException $e) {
        echo "Erro ao excluir aluno e suas dependências: " . $e->getMessage();
    }
} else {
    echo "ID do aluno não fornecido.";
    exit();
}
?>
