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
            // Credenciais corretas, efetue o login e obtenha o caminho da imagem do usuário
            session_start();
            $_SESSION['usuario_logado'] = true;

            // Obtém o caminho da imagem do usuário baseado no nome de usuário
            $caminhoImagemUsuario = obterCaminhoImagemUsuario($conn, $username);

            // Define as variáveis de sessão
            $_SESSION['nomeDoUsuario'] = $username;
            $_SESSION['caminhoImagemUsuario'] = $caminhoImagemUsuario;

            // Redireciona para a página de início/logada
            header("Location: ../View/inicio.php");
            exit();
        } else {
            // Credenciais incorretas, exibe uma mensagem de erro
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

// Função para obter o caminho da imagem do usuário
function obterCaminhoImagemUsuario($conn, $username) {
    try {
        // Consulta SQL para buscar o caminho da imagem do usuário com base no nome de usuário
        $sql = "SELECT CamFoto FROM usuario WHERE UserUsuario = :username";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($resultado && isset($resultado['CamFoto'])) {
            // Se a imagem for encontrada no banco de dados, retorna o caminho
            return $resultado['CamFoto'];
        } else {
            // Se não houver imagem associada ao usuário, retorne o caminho padrão
            return "../img/adm.png"; // Substitua pelo seu caminho de imagem padrão
        }
    } catch (PDOException $e) {
        // Em caso de erro na consulta SQL ou conexão com o banco de dados
        // Trate o erro de acordo com as necessidades do seu sistema
        // Aqui você pode exibir uma mensagem de erro, registrar logs, etc.
        echo "Erro ao obter caminho da imagem do usuário: " . $e->getMessage();
        return "../img/adm.png"; // Caminho de imagem de erro ou padrão de falha
    }
}

?>
