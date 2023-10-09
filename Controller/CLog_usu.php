<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'Entrar') {
        // Obtenha os dados do formulário
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Inclua sua conexão com o banco de dados aqui
        include('CConexao.php');
        $conexaoObj = new CConexao();
        $conn = $conexaoObj->getConnection();

        // Implemente a lógica de verificação das credenciais do usuário
        if (verificarCredenciais($conn, $username, $password)) {
            // Credenciais corretas, efetue o login
            // Você pode definir uma variável de sessão ou outra lógica de autenticação aqui
            // Em seguida, redirecione para a página de sucesso ou área restrita
            session_start();
            $_SESSION['usuario_logado'] = true; // Exemplo de variável de sessão
            header("Location: ../View/inicio.php");
            exit();
        } else {
            // Credenciais incorretas, exiba uma mensagem de erro
            echo "Nome de usuário ou senha incorretos.";
        }
    }
}

// Função para verificar as credenciais do usuário (baseada no seu banco de dados)
function verificarCredenciais($conn, $username, $password) {
    try {
        // Consulta SQL para verificar as credenciais
        $sql = "SELECT * FROM usuario WHERE UserUsuario = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['SenhaUsuario'])) {
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
?>
