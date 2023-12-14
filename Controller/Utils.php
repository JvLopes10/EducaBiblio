<?php
// Inclua o arquivo que contém a classe de conexão
require_once 'CConexao.php';

// Criação de uma instância da classe CConexao para obter a conexão
$conexao = new CConexao();
$conn = $conexao->getConnection();

if ($conn) {
    // Obtém o ID do usuário da sessão (se existir)
    $idUsuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;

    if ($idUsuario !== null) {
        // Consulta SQL para obter o caminho da imagem do usuário do banco de dados
        $sql = "SELECT CamFoto FROM usuario WHERE idUsuario = :idUsuario";

        try {
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':idUsuario', $idUsuario);
            $stmt->execute();

            // Verifica se a consulta retornou algum resultado
            if ($stmt->rowCount() > 0) {
                // Obtém os dados da imagem
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $caminhoImagem = $result['CamFoto'];

                // Verifica se o caminho da imagem está vazio
                if (empty($caminhoImagem)) {
                    // Caso o caminho da imagem esteja vazio, exibe a imagem padrão
                    $caminhoImagem = '../img/adm.png';
                }

                // Exibe a imagem na página HTML usando a tag <img>
                echo '<img src="' . $caminhoImagem . '" alt="Imagem do usuário">';
            } else {
                // Caso não encontre a imagem, pode retornar uma imagem padrão ou uma mensagem de erro
                echo "Imagem não encontrada";
            }
        } catch (PDOException $e) {
            echo "Erro ao buscar imagem do usuário: " . $e->getMessage();
        } finally {
            // Fecha a conexão com o banco de dados
            $conn = null;
        }
    } else {
        echo "ID do usuário não encontrado na sessão.";
    }
} else {
    echo "Não foi possível conectar ao banco de dados.";
}
