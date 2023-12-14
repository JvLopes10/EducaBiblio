<?php
// Arquivo seu_arquivo_php.php

// Incluir arquivo de conexão ao banco de dados
include '../Controller/CConexao.php';

// Verificar se o método de requisição é POST e se foi enviado o ID do aluno
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['aluno_idAluno'])) {
    $alunoId = $_POST['aluno_idAluno'];

    // Inicializar a conexão com o banco de dados
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    // Consulta SQL para obter os dados do aluno e seus livros emprestados não devolvidos
    $query = "SELECT 
        aluno.NomeAluno AS Leitor,
        turma.NomeTurma AS Turma,
        livro.NomeLivro AS Livro,
        'Pendente' AS Estado
        -- Você pode incluir mais campos conforme necessário
    FROM emprestimo
    INNER JOIN livro ON emprestimo.livro_idLivro = livro.idLivro
    INNER JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
    INNER JOIN turma ON aluno.Turma_idTurma = turma.IdTurma
    LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo
    WHERE aluno.idAluno = :alunoId
    AND (devolucao.StatusDevolucao IS NULL OR devolucao.StatusDevolucao = 2)";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':alunoId', $alunoId);
    $stmt->execute();

    // Obter os resultados da consulta como um array associativo
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar os dados como JSON
    header('Content-Type: application/json');
    echo json_encode($result);
} else {
    // Se não receber o ID do aluno na requisição, retornar erro
    echo json_encode(array('error' => 'ID do aluno não fornecido.'));
}
