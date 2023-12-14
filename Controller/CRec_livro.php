<?php
require_once('CConexao.php');

function atualizarBancoDeDados($idRec, $LivroRec, $AutorRec, $CatRec, $ImgRec, $imgPath)
{
    try {
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Consulta SQL para atualizar o caminho da imagem e o campo BLOB no banco de dados
        $sql = "UPDATE recomendacao SET LivroRec = :LivroRec, AutorRec = :AutorRec, CatRec = :CatRec, CamRec = :CamRec, ImgRec = :ImgRec WHERE idRec = :idRec";

        // Prepare a consulta
        $stmt = $conn->prepare($sql);

        // Associe os parâmetros
        $stmt->bindParam(':idRec', $idRec);
        $stmt->bindParam(':LivroRec', $LivroRec);
        $stmt->bindParam(':AutorRec', $AutorRec);
        $stmt->bindParam(':CatRec', $CatRec);
        $stmt->bindParam(':CamRec', $imgPath); // Atualiza o caminho da imagem
        $stmt->bindParam(':ImgRec', $ImgRec, PDO::PARAM_LOB); // Atualiza o campo BLOB

        // Execute a consulta para atualizar o caminho da imagem e o campo BLOB
        $stmt->execute();

        echo "Dados atualizados com sucesso!";
    } catch (PDOException $e) {
        echo "Erro na atualização do banco de dados: " . $e->getMessage();
    }
}

function saveImage($image)
{
    if ($image['error'] == UPLOAD_ERR_OK) {
        $tempName = $image['tmp_name'];
        $imgName = $image['name'];
        $imgPath = '../img/rec/' . $imgName;

        if (move_uploaded_file($tempName, $imgPath)) {
            return $imgPath;
        } else {
            echo "Erro ao mover o arquivo de imagem para o servidor.";
            return null;
        }
    } else {
        echo "Nenhum arquivo de imagem enviado no formulário.";
        return null;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizar'])) {
        $idRec = $_POST['idRec'];
        $LivroRec = $_POST['LivroRec'];
        $AutorRec = $_POST['AutorRec'];
        $CatRec = $_POST['CatRec'];
        $ImgRec = file_get_contents($_FILES['ImgRec']['tmp_name']); // Leitura dos dados binários da imagem

        // Inclua o arquivo de configuração de conexão com o banco de dados
        require_once('../Controller/CRec_livro.php');

        // Processar a imagem e obter o caminho para salvá-la no servidor
        $imgPath = saveImage($_FILES['ImgRec']);

        // Chame a função de atualização do banco de dados
        atualizarBancoDeDados($idRec, $LivroRec, $AutorRec, $CatRec, $ImgRec, $imgPath);

        header("Location: ../View/recomendacoes.php");
        exit; // Encerre o script após o redirecionamento
    }
}
