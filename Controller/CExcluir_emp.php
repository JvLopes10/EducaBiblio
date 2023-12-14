<?php
// excluir_emprestimo.php

// Verifica se o ID do emprestimo foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $Idemprestimo = $_GET['id'];


    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Prepara a consulta SQL para excluir o emprestimo com o ID fornecido
        $sql = "DELETE FROM emprestimo WHERE Idemprestimo  = :Idemprestimo";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':Idemprestimo', $Idemprestimo);

        // Executa a consulta para excluir o emprestimo
        $stmt->execute();

        // Verifica se a exclusão foi realizada com sucesso
        if ($stmt->rowCount() > 0) {
            // Redireciona de volta para a página de emprestimos após a exclusão
            header("Location: ../view/emprestimo.php");
            exit();
        } else {
            echo "Falha ao excluir o emprestimo.";
            header("Location: ../view/emprestimo.php");
        }
    } catch (PDOException $e) {
        echo "Erro na exclusão do emprestimo: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro ou redireciona para outra página
    echo "ID do emprestimo não fornecido.";
    // Ou redirecione para a página de emprestimos ou outra página
    // header("Location: alguma_pagina.php");
    exit();
}
