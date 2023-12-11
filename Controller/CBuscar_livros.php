<?php
include 'CConexao.php';

if (isset($_GET['generoId'])) {
    $generoId = $_GET['generoId'];
    
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    $query = "SELECT idLivro, NomeLivro FROM livro WHERE Genero_idGenero = :generoId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':generoId', $generoId, PDO::PARAM_INT);
    $stmt->execute();

    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = "<option value=''>Selecione um livro</option>";
    foreach ($livros as $livro) {
        $options .= "<option value='" . $livro['idLivro'] . "'>" . $livro['NomeLivro'] . "</option>";
    }

    echo $options;
} else {
    echo "<option value=''>Gênero inválido</option>";
}
?>
