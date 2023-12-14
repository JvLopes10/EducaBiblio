<?php
// excluir_usuario.php

// Verifica se o ID do usuário foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $idLivro = $_GET['id'];

    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Prepara a consulta SQL para excluir o usuário com o ID fornecido
        $sql = "DELETE FROM livro WHERE idLivro  = :idLivro";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':idLivro', $idLivro);

        // Executa a consulta para excluir o usuário
        $stmt->execute();

        // Verifica se a exclusão foi realizada com sucesso
        if ($stmt->rowCount() > 0) {
            // Redireciona de volta para a página de usuários após a exclusão
            header("Location: ../view/livros.php");
            exit();
        } else {
            echo "Falha ao excluir o livro.";
            header("Location: ../view/livros.php");
        }
    } catch (PDOException $e) {
        echo "Erro na exclusão do livro: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro ou redireciona para outra página
    echo "ID do usuário não fornecido.";
    // Ou redirecione para a página de usuários ou outra página
    // header("Location: alguma_pagina.php");
    exit();
}
