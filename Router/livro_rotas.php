<?php
include('../Controller/CCad_livro.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
        // Obtenha os dados do formulário
        $dadosLivro = [
            'NomeLivro' => $_POST['NomeLivro'],
            'IBSMLivro' => $_POST['IBSMLivro'],
            'LocalLivro' => $_POST['LocalLivro'],
            'NomeAltor' => $_POST['NomeAltor'],
            'FotoLivro' => $_FILES['FotoLivro'],  // Use $_FILES para campos de arquivo
            'DidaticoGenero' => $_POST['DidaticoGenero'],
            'NomeGenero' => $_POST['NomeGenero'],
            'Idioma_idIdioma' => $_POST['Idioma_idIdioma'],
            'EditoraLivro' => $_POST['EditoraLivro'],
            'EdicaoLivro' => $_POST['EdicaoLivro'],
            // Outros campos do livro que você deseja obter do formulário
        ];

        // Crie uma instância do controlador de livros
        $livroController = new LivroController();

        // Chame o método para cadastrar o livro, passando os dados do livro
        $livroController->cadastrarLivro($dadosLivro);
    }
    
// header("Location: ../View/livros.php");
}

 header("Location: ../View/livros.php");
?>