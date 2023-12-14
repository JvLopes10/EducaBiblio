<?php
// Inclua o arquivo do controlador
include '../Controller/CEmp_livros.php';


// Roteamento para a função de empréstimo
$emprestimoController = new CEmprestimoController();
$emprestimoController->emprestarLivro();
header("Location: ../View/emprestimos.php");
?>
