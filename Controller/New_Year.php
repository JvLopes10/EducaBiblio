<?php
// Seu arquivo para atualizar o AnoTurma

// Inclua o arquivo que contém a classe de conexão
require_once('CConexao.php');

try {
    // Crie uma instância da classe de conexão
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    // Selecione todas as turmas
    $sql = "SELECT * FROM turma";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Itere sobre os resultados e atualize o AnoTurma
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $idTurma = $row['IdTurma'];
        $anoAtual = $row['AnoTurma'];
        $novoAno = $anoAtual + 1;

        // Atualize o AnoTurma para o próximo ano
        $updateSql = "UPDATE turma SET AnoTurma = :novoAno WHERE IdTurma = :idTurma";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bindParam(':novoAno', $novoAno);
        $updateStmt->bindParam(':idTurma', $idTurma);
        $updateStmt->execute();
    }

    echo "AnoTurma atualizado com sucesso!";
    header ('Location: ../view/turma.php');
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    header ('Location: ../view/turma.php');
}
?>
