<?php
class Model_usu {
    private $conexao;

    public function __construct($conexao) {
        $this->conexao = $conexao;
    }

    public function salvarUsuario($usuario, $nome, $email, $senha) {
        $sql = "INSERT INTO usuario (UserUsuario, NomeUsuario, EmailUsuario, SenhaUsuario) VALUES (:usuario, :nome, :email, :senha)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        if ($stmt->execute()) {
            return true; // Sucesso
        } else {
            return false; // Erro
        }
    }

    public function emailJaEmUso($email) {
        $sql = "SELECT COUNT(*) FROM usuario WHERE EmailUsuario = :email";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return ($count > 0);
    }

    // Outros métodos relacionados ao usuário podem ser adicionados aqui
}
?>
