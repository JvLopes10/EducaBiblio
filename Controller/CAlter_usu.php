<?php
require_once('CConexao.php');

class CAlter_usu {
    public function atualizarUsuario($idUsuario, $UserUsuario, $NomeUsuario, $EmailUsuario, $SenhaUsuario, $FotoUsuario, $caminhoFoto) {
        try {
            // Crie uma instância da classe de conexão
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Construa a consulta SQL para atualizar o usuário
            $sql = "UPDATE usuario SET UserUsuario = :UserUsuario, NomeUsuario = :NomeUsuario, EmailUsuario = :EmailUsuario, SenhaUsuario = :SenhaUsuario, FotoUsuario = :FotoUsuario, camfoto = :caminhoFoto WHERE idUsuario = :idUsuario";

            // Prepare a consulta
            $stmt = $conn->prepare($sql);

            // Associe os valores aos parâmetros da consulta
            $stmt->bindParam(':UserUsuario', $UserUsuario);
            $stmt->bindParam(':NomeUsuario', $NomeUsuario);
            $stmt->bindParam(':EmailUsuario', $EmailUsuario);
            $stmt->bindParam(':SenhaUsuario', $SenhaUsuario);
            $stmt->bindParam(':FotoUsuario', $FotoUsuario);
            $stmt->bindParam(':caminhoFoto', $caminhoFoto);
            $stmt->bindParam(':idUsuario', $idUsuario);

            // Execute a consulta
            $stmt->execute();

            // Verifique se a atualização foi bem-sucedida
            if ($stmt->rowCount() > 0) {
                return true; // Atualização bem-sucedida
            } else {
                return false; // Falha na atualização
            }
        } catch (PDOException $e) {
            echo "Erro na atualização do usuário: " . $e->getMessage();
            return false; // Falha na atualização
        }
    }
}
