<?php
require_once('../Controller/CConexao.php');

function getTurmasFromDB() {
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    // Configuração para usar o modo de busca associativa
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    // Consulta para buscar as turmas no banco de dados, incluindo o ano
    $query = "SELECT AnodeInicio, NomeTurma, AnoTurma FROM turma"; // Substitua 'turma' pelo nome da sua tabela de turmas.

    $result = $conn->query($query);

    if (!$result) {
        $error = $conn->errorInfo();
        die("Erro na consulta ao banco de dados: " . $error[2]);
    }

    $turmas = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $idTurma = $row['AnodeInicio'];
        $nomeTurma = $row['NomeTurma'];
        $anoTurma = $row['AnoTurma'];
        $nomeAnoTurma = "$anoTurma º $nomeTurma";
        $turmas[$idTurma] = $nomeAnoTurma;
    }

    return $turmas;
}
?>
