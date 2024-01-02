<?php
// Verifica se o ID do usuário foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $idUsuario = $_GET['id'];

    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Desativa a verificação de chave estrangeira temporariamente para poder deletar as referências
        $conn->exec("SET FOREIGN_KEY_CHECKS=0");

        // Deleta as referências na tabela de devolução
        $stmtDeletarDevolucao = $conn->prepare("DELETE FROM devolucao WHERE emprestimo_idEmprestimo IN (SELECT idEmprestimo FROM emprestimo WHERE usuario_idUsuario = :idUsuario)");
        $stmtDeletarDevolucao->bindParam(':idUsuario', $idUsuario);
        $stmtDeletarDevolucao->execute();

        // Deleta as referências na tabela de empréstimo
        $stmtDeletarEmprestimo = $conn->prepare("DELETE FROM emprestimo WHERE usuario_idUsuario = :idUsuario");
        $stmtDeletarEmprestimo->bindParam(':idUsuario', $idUsuario);
        $stmtDeletarEmprestimo->execute();

        // Agora, deleta o usuário
        $stmtDeletarUsuario = $conn->prepare("DELETE FROM usuario WHERE idUsuario = :idUsuario");
        $stmtDeletarUsuario->bindParam(':idUsuario', $idUsuario);
        $stmtDeletarUsuario->execute();

        // Reativa a verificação de chave estrangeira
        $conn->exec("SET FOREIGN_KEY_CHECKS=1");

        // Redireciona de volta para a página de usuários após a exclusão
        header("Location: ../view/usuarios.php");
        exit();
    } catch (PDOException $e) {
        echo "Erro na exclusão do usuário: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro ou redireciona para outra página
    echo "ID do usuário não fornecido.";
    // Ou redirecione para a página de usuários ou outra página
    // header("Location: alguma_pagina.php");
    exit();
}
