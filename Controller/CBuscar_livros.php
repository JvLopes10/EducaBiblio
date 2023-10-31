<?php
include 'CConexao.php';

if (isset($_GET['generoId'])) {
    $generoId = $_GET['generoId'];
    
    // Crie uma instância da classe CConexao para obter a conexão com o banco de dados.
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    $query = "SELECT idLivro, NomeLivro FROM livro WHERE Genero_idGenero = :generoId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':generoId', $generoId, PDO::PARAM_INT);
    $stmt->execute();

    $options = "<option value=''>Selecione um livro</option>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= "<option value='" . $row['idLivro'] . "'>" . $row['NomeLivro'] . "</option>";
    }

    echo $options;
}
?>
