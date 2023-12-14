<?php
// Inclua o arquivo do controlador
include '../Controller/CEmp_livros.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: ../View/login.php"); // Redirecionar para a página de login se não estiver logado
    exit();
}


// Roteamento para a função de empréstimo
$emprestimoController = new CEmprestimoController();
$emprestimoController->emprestarLivro();
header("Location: ../View/emprestimos.php");
