
?>
<?php
include('../Controller/CConexao.php');

class CAtualizar_turma {
    private $pdo;

    public function __construct() {
        $conexao = new CConexao();
        $this->pdo = $conexao->getConnection();
    }

    public function atualizarTurma() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Atualizar') {
            $idTurma = $_POST['IdTurma'];
            $anoTurma = $_POST['AnoTurma'];
            $nomeTurma = $_POST['NomeTurma'];
            $Inicio = $_POST['AnodeInicio'];

            $sql = "UPDATE turma SET AnoTurma = :AnoTurma, NomeTurma = :NomeTurma, AnodeInicio = :AnodeInicio WHERE IdTurma = :IdTurma";
            $stmt = $this->pdo->prepare($sql);

            $stmt->bindParam(':AnoTurma', $anoTurma, PDO::PARAM_STR);
            $stmt->bindParam(':NomeTurma', $nomeTurma, PDO::PARAM_STR);
            $stmt->bindParam(':AnodeInicio', $Inicio, PDO::PARAM_STR);
            $stmt->bindParam(':IdTurma', $idTurma, PDO::PARAM_INT);

            if ($stmt->execute()) {
                header('Location: ../View/turma.php');
                exit();
            } else {
                echo 'Erro ao atualizar a turma no banco de dados.';
            }
        }
    }
}
?>
