<?php
// Inclua a classe de conexão
include('../Controller/CConexao.php');

class CCad_aluno {
    public function cadastrarAluno($nome, $email, $turma) {
        // Conecte-se ao banco de dados
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Certifique-se de que os parâmetros estejam devidamente filtrados e seguros contra SQL injection
        // Substitua as informações abaixo pelos campos da tabela do seu banco de dados
        $stmt = $conn->prepare("INSERT INTO aluno (NomeAluno, EmailAluno, Turma_idTurma) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $turma);

        if ($stmt->execute()) {
            echo "Aluno cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o aluno: " . $stmt->errorInfo()[2];
        }
    }
}
?>
