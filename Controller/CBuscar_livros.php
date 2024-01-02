<?php
include 'CConexao.php';

if (isset($_GET['generoId'])) {
    $generoId = $_GET['generoId'];

    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    $query = "SELECT idLivro, NomeLivro, Tombo FROM livro WHERE Genero_idGenero = :generoId ORDER BY NomeLivro ASC";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':generoId', $generoId, PDO::PARAM_INT);
    $stmt->execute();

    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Ordenando os livros manualmente
    usort($livros, function($a, $b) {
        return strcmp($a['NomeLivro'], $b['NomeLivro']);
    });

    $options = "<option value=''>Selecione um livro</option>";
    foreach ($livros as $livro) {
        $options .= "<option value='" . $livro['idLivro'] . "'>" . $livro['NomeLivro'] . ' (' . $livro['Tombo'] . ' )' ."</option>";
    }

    echo $options;
} else {
    echo "<option value=''>Gênero inválido</option>";
}
?>
