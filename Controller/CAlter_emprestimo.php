<?php
// Importe o arquivo que contém a classe de conexão
require_once('CConexao.php'); // Substitua pelo arquivo correto

class CAtualizarEmprestimo
{
    public function debugValues($idEmprestimo, $DataEmprestimo, $StatusEmprestimo, $livro_idLivro, $usuario_idUsuario, $prof_idProf, $aluno_idAluno, $Quantidade_emp)
    {
        var_dump($idEmprestimo, $DataEmprestimo, $StatusEmprestimo, $livro_idLivro, $usuario_idUsuario, $prof_idProf, $aluno_idAluno, $Quantidade_emp);
    }

    public function atualizarEmprestimo($idEmprestimo, $DataEmprestimo, $StatusEmprestimo, $livro_idLivro, $usuario_idUsuario, $prof_idProf, $aluno_idAluno, $Quantidade_emp)
    {
        try {
            // Crie uma instância da classe de conexão
            $conexao = new CConexao();
            $conn = $conexao->getConnection(); // Ajuste conforme sua implementação de conexão

            // Construa a consulta SQL para atualizar o empréstimo
            $sql = "UPDATE emprestimo SET 
                        DataEmprestimo = :DataEmprestimo, 
                        StatusEmprestimo = :StatusEmprestimo, 
                        livro_idLivro = :livro_idLivro, 
                        usuario_idUsuario = :usuario_idUsuario, 
                        prof_idProf = :prof_idProf, 
                        aluno_idAluno = :aluno_idAluno, 
                        Quantidade_emp = :Quantidade_emp 
                    WHERE idEmprestimo = :idEmprestimo";

            // Prepare a consulta
            $stmt = $conn->prepare($sql);

            // Associe os valores aos parâmetros da consulta
            $stmt->bindParam(':DataEmprestimo', $DataEmprestimo);
            $stmt->bindParam(':StatusEmprestimo', $StatusEmprestimo);
            $stmt->bindParam(':livro_idLivro', $livro_idLivro);
            $stmt->bindParam(':usuario_idUsuario', $usuario_idUsuario);
            // Verifica se os campos para professor e aluno estão vazios e atribui NULL
            $stmt->bindValue(':prof_idProf', empty($prof_idProf) ? null : $prof_idProf);
            $stmt->bindValue(':aluno_idAluno', empty($aluno_idAluno) ? null : $aluno_idAluno);
            $stmt->bindParam(':Quantidade_emp', $Quantidade_emp);
            $stmt->bindParam(':idEmprestimo', $idEmprestimo);

            // Executar a função de debug para verificar os valores dos parâmetros
            $this->debugValues($idEmprestimo, $DataEmprestimo, $StatusEmprestimo, $livro_idLivro, $usuario_idUsuario, $prof_idProf, $aluno_idAluno, $Quantidade_emp);

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
