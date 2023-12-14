<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['atualizar'])) {
        $idRec = $_POST['idRec'];
        $LivroRec = $_POST['LivroRec'];
        $AutorRec = $_POST['AutorRec'];
        $CatRec = $_POST['CatRec'];
        $ImgRec = $_FILES['ImgRec'];

        // Inclua o arquivo de configuração de conexão com o banco de dados
        require_once('../Controller/CRec_livro.php');

        // Processar a imagem e obter o caminho para salvá-la no servidor
        $imgPath = saveImage($_FILES['ImgRec']);

        // Chame a função de atualização do banco de dados
        atualizarBancoDeDados($idRec, $LivroRec, $AutorRec, $CatRec, $ImgRec, $imgPath);

        echo "Dados recebidos com sucesso e banco de dados atualizado!";
    }
}

header("Location: ../View/recomendacoes.php");
?>
