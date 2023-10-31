<?php
include 'CConexao.php';

class CEmprestimoController {
    public function emprestarLivro() {
        if (isset($_POST['emprestar'])) {
            // Obtenha os dados do formulário
            $dataEmprestimo = $_POST['DataEmprestimo'];
            $livroId = $_POST['livro_idLivro'];
            $usuarioId = $_POST['usuario_idUsuario'];
            $profId = 1; // Substitua pelo ID do professor, se aplicável.
            $alunoId = $_POST['aluno_idAluno'];
            $quantidade = $_POST['quantidade'];

            // Valide os dados, se necessário

            // Conecte-se ao banco de dados
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Execute a inserção no banco de dados
            $query = "INSERT INTO empestimo (DataEmprestimo, livro_idLivro, usuario_idUsuario, prof_idProf, aluno_idAluno, Quantidade_emp) VALUES (:dataEmprestimo, :livroId, :usuarioId, :profId, :alunoId, :quantidade)";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':dataEmprestimo', $dataEmprestimo);
            $stmt->bindParam(':livroId', $livroId);
            $stmt->bindParam(':usuarioId', $usuarioId);
            $stmt->bindParam(':profId', $profId);
            $stmt->bindParam(':alunoId', $alunoId);
            $stmt->bindParam(':quantidade', $quantidade);

            if ($stmt->execute()) {
                echo "Empréstimo cadastrado com sucesso!";
            } else {
                echo "Erro ao cadastrar o empréstimo.";
            }
        }
    }
}

// Crie uma instância do controlador e chame a função emprestarLivro
$emprestimoController = new CEmprestimoController();
$emprestimoController->emprestarLivro();
?>
