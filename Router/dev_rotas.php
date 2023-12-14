<?php
include '../Controller/CConexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: ../View/login.php"); // Redirecionar para a página de login se não estiver logado
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alunoId = $_POST['aluno_idAluno'];

    $conexao = new CConexao();
    $conn = $conexao->getConnection();

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
        usuario.EmailUsuario
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

    echo json_encode($result);
}
?>
