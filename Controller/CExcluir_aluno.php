<?php
// excluir_usuario.php

// Verifica se o ID do aluno foi enviado via parâmetro GET
if (isset($_GET['id'])) {
    $Idaluno = $_GET['id'];
    

    // Aqui você deve incluir o arquivo que contém a classe de conexão
    require_once('CConexao.php');

    try {
        // Cria uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Prepara a consulta SQL para excluir o aluno com o ID fornecido
        $sql = "DELETE FROM aluno WHERE IdAluno  = :IdAluno";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':IdAluno', $IdAluno);
        
        // Executa a consulta para excluir o aluno
        $stmt->execute();

        // Verifica se a exclusão foi realizada com sucesso
        if ($stmt->rowCount() > 0) {
            // Redireciona de volta para a página de alunos após a exclusão
            header("Location: ../view/aluno.php");
            exit();
        } else {
            echo "Falha ao excluir o aluno.";
            header("Location: ../view/aluno.php");
        }
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
