<?php
var_Dump($_POST);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
        include('../Controller/CCad_usu.php');
        $usuarioController = new UsuarioController();
        $usuarioController->salvarUsuario($_POST);
        header("Location: ../View/usuarios.php");
    } elseif (isset($_POST['action']) && $_POST['action'] === 'Entrar') {
        // Obtenha os dados do formulário
        $username = $_POST['UserUsuario'];
        $password = $_POST['SenhaUsuario'];

        // Inclua sua conexão com o banco de dados aqui
        include('../Controller/CConexao.php');
        $conexaoObj = new CConexao();
        $conn = $conexaoObj->getConnection();

        // Implemente a lógica de verificação das credenciais do usuário
        if (verificarCredenciais($conn, $username, $password)) {
            // Credenciais corretas, efetue o login
            // Você pode definir uma variável de sessão ou outra lógica de autenticação aqui
            // Em seguida, redirecione para a página de sucesso ou área restrita

            session_start();
            $_SESSION['usuario_logado'] = true;

            // Recupere o nome do usuário do banco de dados (substitua com sua consulta SQL)
            $nomeDoUsuario = obterNomeDoUsuario($conn, $username);
            $_SESSION['nomeDoUsuario'] = $nomeDoUsuario;

            header("Location: ../View/inicio.php");
            exit();
        } else {
            // Credenciais incorretas, exiba uma mensagem de erro
            $_SESSION['erro_login'] = "Nome de usuário ou senha incorretos.";
            header("Location: ../View/login.php?erro=1");
            

        }
    }
}

// Função para verificar as credenciais do usuário (baseada no seu banco de dados)
function verificarCredenciais($conn, $username, $password)
{
    try {
        // Consulta SQL para verificar as credenciais
        $sql = "SELECT SenhaUsuario FROM usuario WHERE UserUsuario = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $storedPassword = $stmt->fetch(PDO::FETCH_COLUMN);

        if ($storedPassword === $password) {
            // Senha correta, autenticação bem-sucedida
            return true;
        } else {
            // Credenciais incorretas
            return false;
        }
    } catch (PDOException $e) {
        // Erro na conexão ou consulta SQL
        echo "Erro: " . $e->getMessage();
        return false;
    }
}

// Função para obter o nome do usuário a partir do banco de dados
function obterNomeDoUsuario($conn, $username)
{
    try {
        $sql = "SELECT UserUsuario FROM usuario WHERE UserUsuario = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['UserUsuario'];
        } else {
            return "";
        }
    } catch (PDOException $e) {
        // Erro na conexão ou consulta SQL
        echo "Erro: " . $e->getMessage();
        return "";
    }
}
