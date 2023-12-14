<?php
include('../Controller/CConexao.php');

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
        // Verifica se houve erro no upload do arquivo
        if ($_FILES['FotoLivro']['error'] !== UPLOAD_ERR_OK) {
            echo 'Erro ao fazer o upload da imagem: ' . $_FILES['FotoLivro']['error'];
            exit();
        }

        // Dados do livro a serem inseridos no banco de dados
        $dadosLivro = [
            'NomeLivro' => $_POST['NomeLivro'],
            'IBSMLivro' => $_POST['IBSMLivro'],
            'LocalLivro' => $_POST['LocalLivro'],
            'PrateleiraLivro' => $_POST['PrateleiraLivro'],
            'ColunaLivro' => $_POST['ColunaLivro'],
            'NomeAutor' => $_POST['NomeAutor'],
            'QuantidadeLivros' => $_POST['QuantidadeLivros'],
            'DidaticoLivro' => isset($_POST['DidaticoLivro']) ? $_POST['DidaticoLivro'] : null,
            'Genero_idGenero' => $_POST['Genero_idGenero'],
            'Idioma_idIdioma' => $_POST['Idioma_idIdioma'],
            'EditoraLivro' => $_POST['EditoraLivro'],
            'EdicaoLivro' => $_POST['EdicaoLivro']
        ];

        // Diretório de destino para o upload da imagem
        $caminhoDestino = '../img/livros/';
        $nomeArquivo = $_FILES['FotoLivro']['name'];
        $caminhoArquivo = $caminhoDestino . $nomeArquivo;
        $arquivoTemp = $_FILES['FotoLivro']['tmp_name'];

        // Movendo o arquivo para o diretório de destino
        if (!move_uploaded_file($arquivoTemp, $caminhoArquivo)) {
            echo "Erro ao fazer o upload da imagem.";
            exit();
        }

        try {
            // Criar uma instância da conexão com o banco de dados
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Preparar a consulta SQL para inserir os dados do livro
            $sql = "INSERT INTO Livro (NomeLivro, IBSMLivro, LocalLivro, PrateleiraLivro, ColunaLivro, autor_idAutor, Genero_idGenero, Idioma_idIdioma, FotoLivro, CaminhoFotoLivro, EditoraLivro, EdicaoLivro, QuantidadeLivros, DidaticoLivro)
                    VALUES (:NomeLivro, :IBSMLivro, :LocalLivro, :PrateleiraLivro, :ColunaLivro, :autor_idAutor, :Genero_idGenero, :Idioma_idIdioma, :FotoLivro, :CaminhoFotoLivro, :EditoraLivro, :EdicaoLivro, :QuantidadeLivros, :DidaticoLivro)";
            $stmt = $conn->prepare($sql);

            // Lê o conteúdo do arquivo em binário
            $conteudoImagem = file_get_contents($caminhoArquivo);

            // Vincular os parâmetros da consulta
            $stmt->bindParam(':NomeLivro', $dadosLivro['NomeLivro']);
            $stmt->bindParam(':IBSMLivro', $dadosLivro['IBSMLivro']);
            $stmt->bindParam(':LocalLivro', $dadosLivro['LocalLivro']);
            $stmt->bindParam(':PrateleiraLivro', $dadosLivro['PrateleiraLivro']);
            $stmt->bindParam(':ColunaLivro', $dadosLivro['ColunaLivro']);
            $stmt->bindParam(':autor_idAutor', $dadosLivro['NomeAutor']); // Corrija isso conforme a lógica correta
            $stmt->bindParam(':Genero_idGenero', $dadosLivro['Genero_idGenero']);
            $stmt->bindParam(':Idioma_idIdioma', $dadosLivro['Idioma_idIdioma']);
            $stmt->bindParam(':EditoraLivro', $dadosLivro['EditoraLivro']);
            $stmt->bindParam(':EdicaoLivro', $dadosLivro['EdicaoLivro']);
            $stmt->bindParam(':FotoLivro', $conteudoImagem, PDO::PARAM_LOB); // Utiliza o parâmetro PDO::PARAM_LOB para campos BLOB
            $stmt->bindParam(':CaminhoFotoLivro', $caminhoArquivo);
            $stmt->bindParam(':QuantidadeLivros', $dadosLivro['QuantidadeLivros']);
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
