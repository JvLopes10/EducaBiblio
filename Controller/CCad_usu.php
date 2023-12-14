<?php
class UsuarioController
{
    private $conexao;

    public function __construct()
    {
        // Inicializa a conexão com o banco de dados
        require_once('CConexao.php');
        $conexaoObj = new CConexao();
        $this->conexao = $conexaoObj->getConnection();
    }

    public function salvarUsuario($postData)
    {
        // Extrai dados do formulário
        $nome = $postData['NomeUsuario'];
        $usuario = $postData['UserUsuario'];
        $email = $postData['EmailUsuario'];
        $senha = $postData['SenhaUsuario'];

        // Validação simples (você deve aprimorar a validação de acordo com suas necessidades)
        if (empty($nome) || empty($usuario) || empty($email) || empty($senha)) {
            echo "Preencha todos os campos.";
            return;
        }

        // Verifica se o email já está em uso (você deve implementar essa verificação)
        if ($this->emailJaEmUso($email)) {
            echo "Este email já está em uso.";
            return;
        }

        // Insere o usuário no banco de dados
        $sql = "INSERT INTO usuario (UserUsuario, NomeUsuario, EmailUsuario, SenhaUsuario) VALUES (:usuario, :nome, :email, :senha)";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        if ($stmt->execute()) {
            // Redireciona o usuário para uma página de sucesso
            header("Location: ../View/inicio.php");
        } else {
            // Em caso de erro, exibe uma mensagem de erro
            echo "Ocorreu um erro ao salvar o usuário.";
        }
    }

    private function emailJaEmUso($email)
    {
        // Verifique se o email já está em uso no banco de dados
        $sql = "SELECT COUNT(*) FROM usuario WHERE EmailUsuario = :email";
        $stmt = $this->conexao->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        return ($count > 0);
    }
}
