<?php
// excluir_usuario.php

// Verifica se o ID do turma foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $IdTurma = $_GET['id'];

    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Prepara a consulta SQL para excluir o turma com o ID fornecido
        $sql = "DELETE FROM turma WHERE IdTurma  = :IdTurma";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':IdTurma', $IdTurma);

        // Executa a consulta para excluir o turma
        $stmt->execute();

        // Verifica se a exclusão foi realizada com sucesso
        if ($stmt->rowCount() > 0) {
            // Redireciona de volta para a página de turmas após a exclusão
            header("Location: ../view/turma.php");
            exit();
        } else {
            echo "Falha ao excluir o turma.";
            header("Location: ../view/turma.php");
        }
    } catch (PDOException $e) {
        echo "Erro na exclusão do turma: " . $e->getMessage();
    }
} else {
    // Se o ID não foi fornecido, exibe uma mensagem de erro ou redireciona para outra página
    echo "ID do turma não fornecido.";
    // Ou redirecione para a página de turmas ou outra página
    // header("Location: alguma_pagina.php");
    exit();
}
