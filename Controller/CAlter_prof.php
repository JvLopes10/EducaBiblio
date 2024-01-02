<?php
require_once('CConexao.php'); // Inclua o arquivo que contém a classe de conexão

class CAlter_prof
{
    public function atualizarProfessor($idProf, $NomeProf, $EmailProf, $MateriaProf)
    {
        try {
            // Crie uma instância da classe de conexão
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Construa a consulta SQL para atualizar o professor
            $sql = "UPDATE prof SET NomeProf = :NomeProf, EmailProf = :EmailProf, MateriaProf = :MateriaProf WHERE idProf = :idProf";

            // Prepare a consulta
            $stmt = $conn->prepare($sql);

            // Associe os valores aos parâmetros da consulta
            $stmt->bindParam(':NomeProf', $NomeProf);
            $stmt->bindParam(':EmailProf', $EmailProf);
            $stmt->bindParam(':MateriaProf', $MateriaProf);
            $stmt->bindParam(':idProf', $idProf);

            // Execute a consulta
            $stmt->execute();

            // Verifique se a atualização foi realizada
            if ($stmt->rowCount() >= 0) {
                return true; // Atualização bem-sucedida ou nenhum dado foi modificado
            } else {
                return false; // Falha na atualização
            }
        } catch (PDOException $e) {
            echo "Erro na atualização do professor: " . $e->getMessage();
            return false; // Falha na atualização
        }
    }
}

var_dump($_POST);
