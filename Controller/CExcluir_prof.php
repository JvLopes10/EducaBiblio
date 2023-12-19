<?php
// Verifica se o ID do professor foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $idProfessor = $_GET['id'];

    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Desativa a verificação de chave estrangeira temporariamente para poder deletar as referências
        $conn->exec("SET FOREIGN_KEY_CHECKS=0");

        // Deleta as referências na tabela empréstimo
        $stmtDeletarEmprestimo = $conn->prepare("DELETE FROM emprestimo WHERE prof_idProf = :idProfessor");
        $stmtDeletarEmprestimo->bindParam(':idProfessor', $idProfessor);
        $stmtDeletarEmprestimo->execute();

        // Agora, deleta o professor
        $stmtDeletarProfessor = $conn->prepare("DELETE FROM prof WHERE idProf = :idProfessor");
        $stmtDeletarProfessor->bindParam(':idProfessor', $idProfessor);
        $stmtDeletarProfessor->execute();

        // Reativa a verificação de chave estrangeira
        $conn->exec("SET FOREIGN_KEY_CHECKS=1");

        // Redireciona de volta para a página de professores após a exclusão
        header("Location: ../view/prof.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro na exclusão do professor: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro ou redireciona para outra página
    echo "ID do professor não fornecido.";
    // Ou redirecione para a página de professores ou outra página
    // header("Location: alguma_pagina.php");
    exit();
}
?>
