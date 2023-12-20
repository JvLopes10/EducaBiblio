<?php
// excluir_livro.php

// Verifica se o ID do livro foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $idLivro = $_GET['id'];

    // Inclui o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Exclui os registros de devolucao associados aos empréstimos relacionados ao livro
        $deleteDevolucaoQuery = "DELETE FROM devolucao WHERE emprestimo_idEmprestimo IN (SELECT idEmprestimo FROM emprestimo WHERE livro_idLivro = :idLivro)";
        $stmtDeleteDevolucao = $conn->prepare($deleteDevolucaoQuery);
        $stmtDeleteDevolucao->bindParam(':idLivro', $idLivro);
        $stmtDeleteDevolucao->execute();

        // Exclui os registros de emprestimo relacionados ao livro
        $deleteEmprestimoQuery = "DELETE FROM emprestimo WHERE livro_idLivro = :idLivro";
        $stmtDeleteEmprestimo = $conn->prepare($deleteEmprestimoQuery);
        $stmtDeleteEmprestimo->bindParam(':idLivro', $idLivro);
        $stmtDeleteEmprestimo->execute();

        // Exclui o livro
        $deleteLivroQuery = "DELETE FROM livro WHERE idLivro = :idLivro";
        $stmtDeleteLivro = $conn->prepare($deleteLivroQuery);
        $stmtDeleteLivro->bindParam(':idLivro', $idLivro);
        $stmtDeleteLivro->execute();

        // Verifica se a exclusão do livro foi bem-sucedida
        if ($stmtDeleteLivro->rowCount() > 0) {
            // Redireciona de volta para a página de livros após a exclusão
            header("Location: ../view/livros.php");
            exit();
        } else {
            // Se não houve exclusão, redireciona com mensagem de falha
            header("Location: ../view/livros.php?error=Falha ao excluir o livro.");
            exit();
        }
    } catch (PDOException $e) {
        // Em caso de erro na exclusão, exibe mensagem de erro
        echo "Erro na exclusão do livro: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro
    echo "ID do livro não fornecido.";
    exit();
}
?>
