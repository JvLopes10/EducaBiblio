<?php
session_start();

// Verificar se o usuário já está logado
if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
    header("Location: ../View/inicio.php"); // Redirecionar para a página inicial
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once('../Controller/CConexao.php'); // Verifique o caminho correto do arquivo

    if (isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
        include('../Controller/CCad_usu.php'); // Verifique o caminho correto do arquivo
        $usuarioController = new UsuarioController();
        $usuarioController->salvarUsuario($_POST);
        header("Location: ../View/login.php");
        exit();
    } elseif (isset($_POST['action']) && $_POST['action'] === 'Entrar') {
        // Obtenha os dados do formulário
        $username = $_POST['UserUsuario'];
        $password = $_POST['SenhaUsuario'];

        $conexaoObj = new CConexao();
        $conn = $conexaoObj->getConnection();

        if ($conn) {
            if (verificarCredenciais($conn, $username, $password)) {
                $_SESSION['usuario_logado'] = true;

                // Recupere o nome do usuário do banco de dados (substitua com sua consulta SQL)
                $nomeDoUsuario = obterNomeDoUsuario($conn, $username);
                $_SESSION['nomeDoUsuario'] = $nomeDoUsuario;

                // Recupere o ID do usuário do banco de dados (substitua com sua consulta SQL)
                $idUsuario = obterIdDoUsuario($conn, $username);
                $_SESSION['id_usuario'] = $idUsuario;

                header("Location: ../View/inicio.php");
                exit();
            } else {
                $_SESSION['erro_login'] = "Nome de usuário ou senha incorretos.";
                header("Location: ../View/login.php?erro=1");
                exit();
            }
        } else {
            echo "Não foi possível conectar ao banco de dados.";
            // Você pode redirecionar para uma página de erro se preferir
            exit();
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
            return true;
        } else {
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

// Função para obter o ID do usuário a partir do banco de dados
function obterIdDoUsuario($conn, $username)
{
    try {
        $sql = "SELECT idUsuario FROM usuario WHERE UserUsuario = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            return $user['idUsuario'];
        } else {
            return null; // Ou outra indicação de que o usuário não foi encontrado
        }
    } catch (PDOException $e) {
        // Erro na conexão ou consulta SQL
        echo "Erro: " . $e->getMessage();
        return null; // Ou outra indicação de erro, se necessário
    }
}
