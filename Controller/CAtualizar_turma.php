<?php
require_once('../Controller/CConexao.php');

class CAtualizar_turma
{
    public function atualizarTurma($idTurma, $anoTurma, $nomeTurma, $inicio)
    {
        // Crie uma instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Construa a consulta SQL para atualizar a turma
        $sql = "UPDATE turma SET AnoTurma = :AnoTurma, NomeTurma = :NomeTurma, AnodeInicio = :Inicio WHERE IdTurma = :IdTurma";

        // Prepare a consulta
        $stmt = $conn->prepare($sql);

        // Associe os valores aos parâmetros da consulta
        $stmt->bindParam(':IdTurma', $idTurma);
        $stmt->bindParam(':AnoTurma', $anoTurma);
        $stmt->bindParam(':NomeTurma', $nomeTurma);

        // Converta o valor para inteiro antes de atribuir ao parâmetro 'Inicio'
        $inicio = intval($inicio);
        $stmt->bindParam(':Inicio', $inicio);

        // Execute a consulta
        $stmt->execute();

        // Verifique se a atualização foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            return true; // Atualização bem-sucedida
        } else {
            return false; // Falha na atualização
        }
    }
}
?>
