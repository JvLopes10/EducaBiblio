<?php
include 'CConexao.php';

if (isset($_GET['turmaId'])) {
    $turmaId = $_GET['turmaId'];
    
    // Crie uma instância da classe CConexao para obter a conexão com o banco de dados.
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    $query = "SELECT idAluno, NomeAluno FROM aluno WHERE Turma_idTurma = :turmaId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':turmaId', $turmaId, PDO::PARAM_INT);
    $stmt->execute();

    $options = "<option value=''>Selecione um aluno</option>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= "<option value='" . $row['idAluno'] . "'>" . $row['NomeAluno'] . "</option>";
    }

    echo $options;
}
?>
