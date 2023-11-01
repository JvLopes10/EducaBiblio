<?php
require_once('CConexao.php');

class EmpréstimoController {
    public function listarAlunosDaTurma($turma) {
        // Crie uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Consulta para obter os alunos da turma selecionada
        $sql = "SELECT NomeAluno FROM aluno WHERE Turma_idTurma = :turma";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':turma', $turma, PDO::PARAM_INT);
        $stmt->execute();

        // Retorne a lista de alunos
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listarEmpréstimosDoAluno($aluno) {
        // Crie uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Consulta para obter os empréstimos do aluno selecionado
        $sql = "SELECT * FROM emprestimo WHERE aluno_idAluno = :aluno";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':aluno', $aluno, PDO::PARAM_INT);
        $stmt->execute();

        // Retorne a lista de empréstimos
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
