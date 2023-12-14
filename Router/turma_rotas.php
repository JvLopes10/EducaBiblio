<?php

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: ../View/login.php"); // Redirecionar para a página de login se não estiver logado
    exit();
}

// Verifica se a ação é POST e se o campo 'action' está definido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Enviar') {
    // Ação para criar/enviar uma nova turma
    include '../Controller/CCad_turma.php';

    // Verifica se a classe CCad_turma existe
    if (class_exists('CCad_turma')) {
        $controlador = new CCad_turma();
        $controlador->cadastrarTurma();

        header('Location: ../View/turma.php');
        exit();
    } else {
        echo 'A classe CCad_turma não foi encontrada.';
    }
}
