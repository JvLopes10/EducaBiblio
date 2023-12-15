<?php
try {


    // Verifica se a ação é POST e se o campo 'action' está definido
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateAction']) && $_POST['updateAction'] === 'Atualizar') {
        // Ação para atualizar uma turma existente
        include '../Controller/CAtualizar_turma.php';

        // Verifica se a classe CAtualizar_turma existe
        if (class_exists('CAtualizar_turma')) {
            $controlador = new CAtualizar_turma();

            // Passe os parâmetros necessários para a função atualizarTurma()
            $idTurma = $_POST['IdTurma'];
            $anoTurma = $_POST['AnoTurma'];
            $nomeTurma = $_POST['NomeTurma'];
            $inicio = intval($_POST['AnodeInicio']); // Converter para inteiro

            // Chame a função atualizarTurma() com os parâmetros adequados
            $atualizacaoSucesso = $controlador->atualizarTurma($idTurma, $anoTurma, $nomeTurma, $inicio);

            if ($atualizacaoSucesso) {
                header('Location: ../View/turma.php');
                exit();
            } else {
                //  header('Location: ../Controller/CAtualizar_turma.php');
                echo 'Erro ao atualizar a turma.';
                var_dump($_POST);
            }
        } else {
            echo 'A classe CAtualizar_turma não foi encontrada.';
        }
    }
} catch (PDOException $e) {
    echo "Erro na atualização do usuário: " . $e->getMessage();
    return false;
}
