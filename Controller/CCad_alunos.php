<?php
include('../Controller/CConexao.php');

class CCad_aluno {
    public function cadastrarAluno($nome, $email, $idTurma) {
        // Conecte-se ao banco de dados
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        try {
            // Verifica se a turma fornecida realmente existe na tabela 'turma'
            $verificarTurma = $conn->prepare("SELECT IdTurma FROM turma WHERE IdTurma = ?");
            $verificarTurma->bindParam(1, $idTurma);
            $verificarTurma->execute();

            if ($verificarTurma->rowCount() > 0) {
                // A turma existe, então podemos prosseguir com a inserção do aluno
                $stmt = $conn->prepare("INSERT INTO aluno (NomeAluno, EmailAluno, Turma_idTurma) VALUES (?, ?, ?)");
                $stmt->bindParam(1, $nome);
                $stmt->bindParam(2, $email);
                $stmt->bindParam(3, $idTurma);

                if ($stmt->execute()) {
                    echo "Aluno cadastrado com sucesso!";
                } else {
                    echo "Erro ao cadastrar o aluno.";
                }
            } else {
                echo "A turma fornecida não existe na base de dados.";
            }
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o aluno: " . $e->getMessage();
        }
    }
}

?>
