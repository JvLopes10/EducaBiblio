<?php
include '../Controller/CConexao.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica se os campos do formulário estão configurados e não estão vazios
    if (isset($_POST['aluno_idAluno']) && !empty($_POST['aluno_idAluno'])) {
        $alunoId = $_POST['aluno_idAluno'];

        try {
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Consulta para obter os detalhes dos livros emprestados pelo aluno que ainda não foram devolvidos
            $query = "SELECT 
                livro.NomeLivro AS TituloLivro,
                genero.NomeGenero,
                emprestimo.idEmprestimo,
                turma.NomeTurma,
                aluno.NomeAluno,
                emprestimo.DataEmprestimo,
                devolucao.DataDevolucao,
                emprestimo.Quantidade_emp,
                usuario.UserUsuario,
                usuario.EmailUsuario,
                devolucao.StatusDevolucao
            FROM emprestimo
            INNER JOIN livro ON emprestimo.livro_idLivro = livro.idLivro
            INNER JOIN genero ON livro.Genero_idGenero = genero.idGenero
            INNER JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
            INNER JOIN turma ON aluno.Turma_idTurma = turma.IdTurma
            INNER JOIN usuario ON emprestimo.usuario_idUsuario = usuario.idUsuario
            LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo
            WHERE aluno.idAluno = :alunoId 
            AND (devolucao.StatusDevolucao IS NULL OR devolucao.StatusDevolucao = 2)";

            $stmt = $conn->prepare($query);
            $stmt->bindParam(':alunoId', $alunoId, PDO::PARAM_INT);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Envia os resultados como resposta em formato JSON
            echo json_encode($result);
        } catch (PDOException $e) {
            // Em caso de erro na execução da consulta ou conexão com o banco de dados
            echo json_encode(['error' => 'Erro ao processar a solicitação.']);
        } finally {
            // Fecha a conexão com o banco de dados
            $conn = null;
        }
    } else {
        // Se os campos do formulário estiverem vazios ou não configurados
        echo json_encode(['error' => 'Campos do formulário ausentes ou vazios.']);
    }
}
