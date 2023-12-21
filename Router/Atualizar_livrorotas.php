<?php
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    // Importe o arquivo que contém a classe responsável pelas operações com livros
    require_once('../Controller/CAlter_livro.php');

    // Verifica se os campos necessários foram enviados via POST
    if (
        isset($_POST['idLivro']) && 
        isset($_POST['NomeLivro']) && 
        isset($_POST['EditoraLivro']) && 
        isset($_POST['IBSMLivro']) &&
        isset($_POST['Genero_idGenero']) &&
        isset($_POST['Idioma_idIdioma']) &&
        isset($_POST['QuantidadeLivros']) &&
        isset($_POST['LocalLivro']) &&
        isset($_POST['PrateleiraLivro']) &&
        isset($_POST['ColunaLivro'])
    ) {
        // Atribui os valores enviados via POST a variáveis
        $idLivro = $_POST['idLivro'];
        $NomeLivro = $_POST['NomeLivro'];
        $EditoraLivro = $_POST['EditoraLivro'];
        $IBSMLivro = $_POST['IBSMLivro'];
        $Genero_idGenero = $_POST['Genero_idGenero'];
        $Idioma_idIdioma = $_POST['Idioma_idIdioma'];
        $QuantidadeLivros = $_POST['QuantidadeLivros'];
        $LocalLivro = $_POST['LocalLivro'];
        $PrateleiraLivro = $_POST['PrateleiraLivro'];
        $ColunaLivro = $_POST['ColunaLivro'];

        // Cria uma instância da classe responsável pelas operações com livros
        $atualizacaoLivro = new CAtualizar_livro();

        // Chama o método para atualizar o livro pelo ID
        $resultado = $atualizacaoLivro->atualizarLivro($idLivro, $NomeLivro, $EditoraLivro, $IBSMLivro, $Genero_idGenero, $Idioma_idIdioma, $QuantidadeLivros, $LocalLivro, $PrateleiraLivro, $ColunaLivro);

        if ($resultado) {
            echo "Livro atualizado com sucesso!";
            header("Location: ../view/livros.php"); // Redireciona para a página correta após a atualização do livro
            exit(); // Encerra o script apsós o redirecionamento
        } else {
            echo "Falha ao atualizar o livro.";
        }
    } else {
        echo "Por favor, preencha todos os campos necessários.";
        header("Location: ../view/livros.php"); // Redireciona para a página correta após a atualização do livro
    }
} else {
    echo "O envio do formulário não foi detectado.";
}
?>
