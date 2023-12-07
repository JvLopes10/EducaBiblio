<?php
include('../Controller/CCad_livro.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
        // Obtenha os dados do formulário
        $dadosLivro = [
            'NomeLivro' => $_POST['NomeLivro'],
            'IBSMLivro' => $_POST['IBSMLivro'],
            'LocalLivro' => $_POST['LocalLivro'],
            'PrateleiraLivro' => $_POST['PrateleiraLivro'],
            'ColunaLivro' => $_POST['ColunaLivro'],
            'NomeAutor' => $_POST['NomeAutor'],
            'QuantidadeLivros' => $_POST['QuantidadeLivros'],
            'DidaticoLivro' => isset($_POST['DidaticoLivro']) ? $_POST['DidaticoLivro'] : null,
            'FotoLivro' => $_FILES['FotoLivro'],  // Use $_FILES para campos de arquivo

            'Genero_idGenero' => $_POST['Genero_idGenero'],
            'Idioma_idIdioma' => $_POST['Idioma_idIdioma'],
            'EditoraLivro' => $_POST['EditoraLivro'],
            'EdicaoLivro' => $_POST['EdicaoLivro'],
            // Outros campos do livro que você deseja obter do formulário
        ]; 
        
        // Validar e mover o arquivo de upload para um diretório seguro
        $caminhoDestino = '../img/livros';
        $nomeArquivo = $_FILES['FotoLivro']['name'];
        $caminhoArquivo = $caminhoDestino . '/' . $nomeArquivo;

        move_uploaded_file($_FILES['FotoLivro']['tmp_name'], $caminhoArquivo);

        // Adicione o caminho do arquivo aos dados do livro
        $dadosLivro['FotoLivro'] = $caminhoArquivo;

        // Crie uma instância do controlador de livros
        $livroController = new LivroController();

        // Chame o método para cadastrar o livro, passando os dados do livro
        $livroController->cadastrarLivro($dadosLivro);
        header("Location: ../View/livros.php");
        exit(); // Termina o script após o redirecionamento
    }
}

// Redirecionamento padrão se a condição acima não for atendida
header("Location: ../View/livros.php");
exit(); // Termina o script após o redirecionamento
