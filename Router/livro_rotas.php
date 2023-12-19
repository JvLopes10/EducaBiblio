<?php
include('../Controller/CConexao.php');

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
        try {
            // Criar uma instância da conexão com o banco de dados
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Preparar a consulta SQL para inserir os dados do livro
            $sql = "INSERT INTO Livro (NomeLivro, IBSMLivro, LocalLivro, PrateleiraLivro, ColunaLivro, autor_idAutor, Genero_idGenero, Idioma_idIdioma, EditoraLivro, EdicaoLivro, QuantidadeLivros, DidaticoLivro)
                    VALUES (:NomeLivro, :IBSMLivro, :LocalLivro, :PrateleiraLivro, :ColunaLivro, :autor_idAutor, :Genero_idGenero, :Idioma_idIdioma, :EditoraLivro, :EdicaoLivro, :QuantidadeLivros, :DidaticoLivro)";
            $stmt = $conn->prepare($sql);

            // Vincular os parâmetros da consulta
            $stmt->bindParam(':NomeLivro', $_POST['NomeLivro']);
            $stmt->bindParam(':IBSMLivro', $_POST['IBSMLivro']);
            $stmt->bindParam(':LocalLivro', $_POST['LocalLivro']);
            $stmt->bindParam(':PrateleiraLivro', $_POST['PrateleiraLivro']);
            $stmt->bindParam(':ColunaLivro', $_POST['ColunaLivro']);
            $stmt->bindParam(':autor_idAutor', $_POST['NomeAutor']); // Corrija isso conforme a lógica correta
            $stmt->bindParam(':Genero_idGenero', $_POST['Genero_idGenero']);
            $stmt->bindParam(':Idioma_idIdioma', $_POST['Idioma_idIdioma']);
            $stmt->bindParam(':EditoraLivro', $_POST['EditoraLivro']);
            $stmt->bindParam(':EdicaoLivro', $_POST['EdicaoLivro']);
            $stmt->bindParam(':QuantidadeLivros', $_POST['QuantidadeLivros']);
            $stmt->bindParam(':DidaticoLivro', $dadosLivro['DidaticoLivro']);

            // Executar a consulta
            $stmt->execute();

            // Redirecionamento após o cadastro
            header("Location: ../View/livros.php");
            exit(); // Terminar o script após o redirecionamento
        } catch (PDOException $e) {
            echo "Erro ao cadastrar o livro: " . $e->getMessage();
        }
    }
}

// Redirecionamento padrão se a condição acima não for atendida
header("Location: ../View/livros.php");
exit(); // Terminar o script após o redirecionamento
?>
