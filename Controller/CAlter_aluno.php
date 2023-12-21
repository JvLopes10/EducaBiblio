<?php
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    // Importe o arquivo que contém a classe responsável pelas operações com alunos
    require_once('CConexao.php'); // Inclua o arquivo que contém a classe de conexão

    class CAlter_aluno
    {
        public function atualizarAluno($idAluno, $NomeAluno, $EmailAluno, $Turma_idTurma)
        {
            try {
                // Crie uma instância da classe de conexão
                $conexao = new CConexao();
                $conn = $conexao->getConnection();

                // Construa a consulta SQL para atualizar o aluno
                $sql = "UPDATE aluno SET NomeAluno = :NomeAluno, EmailAluno = :EmailAluno, Turma_idTurma = :Turma_idTurma WHERE idAluno = :idAluno";

                // Prepare a consulta
                $stmt = $conn->prepare($sql);

                // Associe os valores aos parâmetros da consulta
                $stmt->bindParam(':NomeAluno', $NomeAluno);
                $stmt->bindParam(':EmailAluno', $EmailAluno);
                $stmt->bindParam(':Turma_idTurma', $Turma_idTurma);
                $stmt->bindParam(':idAluno', $idAluno);

                // Execute a consulta
                $stmt->execute();

                // Verifique se a atualização foi realizada
                if ($stmt->rowCount() >= 0) {
                    return true; // Atualização bem-sucedida ou nenhum dado foi modificado
                } else {
                    return false; // Falha na atualização
                }
            } catch (PDOException $e) {
                echo "Erro na atualização do aluno: " . $e->getMessage();
                return false; // Falha na atualização
            }
        }
    }

    // Seu código continua aqui para manipular a atualização do aluno com base nos dados recebidos via POST
}
?>
