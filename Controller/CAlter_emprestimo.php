<?php
// Importe o arquivo que contém a classe de conexão
require_once('CConexao.php'); // Substitua pelo arquivo correto

class CAtualizarEmprestimo
{
    public function atualizarEmprestimo($idEmprestimo, $Genero_idGenero, $livro_idLivro, $Turma_idTurma, $aluno_idAluno, $prof_idProf, $DataEmprestimo, $quantidade, $data, $usuario_idUsuario)
    {
        try {
            // Crie uma instância da classe de conexão
            $conexao = new CConexao();
            $conn = $conexao->getConnection(); // Ajuste conforme sua implementação de conexão

            // Construa a consulta SQL para atualizar o empréstimo
            $sql = "UPDATE emprestimo SET 
                        Genero_idGenero = :Genero_idGenero, 
                        livro_idLivro = :livro_idLivro, 
                        Turma_idTurma = :Turma_idTurma, 
                        aluno_idAluno = :aluno_idAluno, 
                        prof_idProf = :prof_idProf, 
                        DataEmprestimo = :DataEmprestimo, 
                        quantidade = :quantidade, 
                        data = :data, 
                        usuario_idUsuario = :usuario_idUsuario 
                    WHERE idEmprestimo = :idEmprestimo";

            // Prepare a consulta
            $stmt = $conn->prepare($sql);

            // Associe os valores aos parâmetros da consulta
            $stmt->bindParam(':Genero_idGenero', $Genero_idGenero);
            $stmt->bindParam(':livro_idLivro', $livro_idLivro);
            $stmt->bindParam(':Turma_idTurma', $Turma_idTurma);
            $stmt->bindParam(':aluno_idAluno', $aluno_idAluno);
            $stmt->bindParam(':prof_idProf', $prof_idProf);
            $stmt->bindParam(':DataEmprestimo', $DataEmprestimo);
            $stmt->bindParam(':quantidade', $quantidade);
            $stmt->bindParam(':data', $data);
            $stmt->bindParam(':usuario_idUsuario', $usuario_idUsuario);
            $stmt->bindParam(':idEmprestimo', $idEmprestimo);

            // Execute a consulta
            $stmt->execute();

            // Verifique se a atualização foi realizada
            if ($stmt->rowCount() > 0) {
                return true; // Atualização bem-sucedida
            } else {
                return false; // Nenhum dado foi modificado
            }
        } catch (PDOException $e) {
            echo "Erro na atualização do empréstimo: " . $e->getMessage();
            return false; // Falha na atualização
        }
    }
}
?>
