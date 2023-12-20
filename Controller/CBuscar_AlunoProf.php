<?php
include 'CConexao.php';

if (isset($_GET['turmaId'])) {
    $turmaId = $_GET['turmaId'];

    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    $options = "<option value=''>Selecione um aluno ou professor</option>";

    if ($turmaId === '0') {
        // Se o ID da turma for 0 (professores)
        $query = "SELECT idProf AS id, NomeProf AS Nome FROM prof";
    } else {
        // Se não, buscar alunos da turma especificada
        $query = "SELECT idAluno AS id, NomeAluno AS Nome FROM aluno WHERE Turma_idTurma = :turmaId";
    }

    $stmt = $conn->prepare($query);

    if ($turmaId !== '0') {
        $stmt->bindParam(':turmaId', $turmaId, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as $row) {
            $options .= "<option value='" . $row['id'] . "'>" . $row['Nome'] . "</option>";
        }

        echo $options;
    } else {
        echo "<option value=''>Erro ao carregar alunos/professores</option>";
    }
} else {
    echo "<option value=''>Turma inválida</option>";
}
?>
