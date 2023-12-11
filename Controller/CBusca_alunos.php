<?php
include 'CConexao.php';

if (isset($_GET['turmaId'])) {
    $turmaId = $_GET['turmaId'];
    
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    $query = "SELECT idAluno, NomeAluno FROM aluno WHERE Turma_idTurma = :turmaId";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':turmaId', $turmaId, PDO::PARAM_INT);
    $stmt->execute();

    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $options = "<option value=''>Selecione um aluno</option>";
    foreach ($alunos as $aluno) {
        $options .= "<option value='" . $aluno['idAluno'] . "'>" . $aluno['NomeAluno'] . "</option>";
    }

    echo $options;
} else {
    echo "<option value=''>Turma inválida</option>";
}
?>
