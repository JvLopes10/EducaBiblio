<?php
try {
    var_dump($_POST); 
    echo '1'; // Marca de posição 1

    // Verifica se a ação é POST e se o campo 'action' está definido
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateAction']) && $_POST['updateAction'] === 'Atualizar') {
        // Ação para atualizar uma turma existente
        include '../Controller/CAtualizar_turma.php';
        echo '2'; // Marca de posição 2

        // Verifica se a classe CAtualizar_turma existe
        if (class_exists('CAtualizar_turma')) {
            $controlador = new CAtualizar_turma();

            // Passe os parâmetros necessários para a função atualizarTurma()
            $idTurma = $_POST['IdTurma'];
            $anoTurma = $_POST['AnoTurma'];
            $nomeTurma = $_POST['NomeTurma'];
            $inicio = $_POST['AnodeInicio'];
            echo '3'; // Marca de posição 3

            // Chame a função atualizarTurma() com os parâmetros adequados
            $atualizacaoSucesso = $controlador->atualizarTurma($idTurma, $anoTurma, $nomeTurma, $inicio);

            if ($atualizacaoSucesso) {
                header('Location: ../View/turma.php');
                exit();
            } else {
                echo '4'; // Marca de posição 4
                echo 'Erro ao atualizar a turma.';
            }
        } else {
            echo 'A classe CAtualizar_turma não foi encontrada.';
        }
    }
} catch (PDOException $e) {
    echo "Erro na atualização do usuário: " . $e->getMessage();
    return false;
}
?>
