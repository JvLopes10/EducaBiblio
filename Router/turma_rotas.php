<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    echo "Passou na primeira condição."; // Mensagem de depuração
    if ($_POST['action'] === 'Enviar') {
        echo "A ação é 'enviar'."; // Mensagem de depuração
        include '../Controller/CCad_turma.php';

        if (class_exists('CCad_turma')) {
            echo "A classe CCad_turma foi encontrada."; // Mensagem de depuração
            $controlador = new CCad_turma();
            $controlador->cadastrarTurma();

            header('Location: ../View/turma.php');
            exit();
        } else {
            echo 'A classe CCad_turma não foi encontrada.';
        }
    }
}
