<?php
include('../Controller/CConexao.php');

class LivroController
{
    public function cadastrarLivro($dadosLivro)
    {
        try {
            $conn = (new CConexao())->getConnection();
            $conn->beginTransaction();

            // Processar o upload da imagem
            if (isset($_FILES['FotoLivro']) && $_FILES['FotoLivro']['error'] === UPLOAD_ERR_OK) {
                $nomeArquivo = $_FILES['FotoLivro']['name'];
                $caminhoTemporario = $_FILES['FotoLivro']['tmp_name'];
                $caminhoDestino = '../img/livros/' . $nomeArquivo;
            
                // Validação do tipo de arquivo (imagem)
                $tipoArquivo = $_FILES['FotoLivro']['type'];
                $tamanhoArquivo = $_FILES['FotoLivro']['size'];
            
                if (!in_array($tipoArquivo, ['image/jpeg', 'image/png'])) {
                    echo "A imagem deve estar no formato JPEG ou PNG.";
                    exit();
                }
            
                // Validação do tamanho do arquivo (exemplo: máximo de 2MB)
                if ($tamanhoArquivo > 2 * 1024 * 1024) {
                    echo "A imagem é muito grande. O tamanho máximo permitido é 2MB.";
                    exit();
                }
            
                if (move_uploaded_file($caminhoTemporario, $caminhoDestino)) {
                    // A imagem foi enviada com sucesso, agora você pode salvar o caminho dela no banco de dados
                    $dadosLivro['CaminhoFotoLivro'] = $caminhoDestino;
                } else {
                    // O upload da imagem falhou
                    echo "Erro ao fazer o upload da imagem.";
                    exit();
                }
            }
            


            // Insira os dados do Autor na tabela Autor
            $sqlAutor = "INSERT INTO Autor (NomeAutor) VALUES (:NomeAutor)";
            $stmtAutor = $conn->prepare($sqlAutor);
            $stmtAutor->bindParam(':NomeAutor', $dadosLivro['NomeAutor']);
            $stmtAutor->execute();

            // Obtenha o ID do Autor recém-inserido
            $idAutor = $conn->lastInsertId();

            // Insira os dados do gênero na tabela Genero
            $sqlGenero = "INSERT INTO Genero (NomeGenero, DidaticoGenero) VALUES (:NomeGenero, :DidaticoGenero)";
            $stmtGenero = $conn->prepare($sqlGenero);
            $stmtGenero->bindParam(':NomeGenero', $dadosLivro['NomeGenero']);
            $stmtGenero->bindParam(':DidaticoGenero', $dadosLivro['DidaticoGenero']);
            $stmtGenero->execute();

            // Obtenha o ID do gênero recém-inserido
            $idGenero = $conn->lastInsertId();

            // Insira os dados do livro na tabela Livro
            $sqlLivro = "INSERT INTO Livro (NomeLivro, IBSMLivro, LocalLivro, PrateleiraLivro, ColunaLivro, Autor_idAutor, Genero_idGenero, Idioma_idIdioma, EditoraLivro, EdicaoLivro, CaminhoFotoLivro, QuantidadeLivros)
                         VALUES (:NomeLivro, :IBSMLivro, :LocalLivro, :PrateleiraLivro, :ColunaLivro, :Autor_idAutor, :Genero_idGenero, :Idioma_idIdioma, :EditoraLivro, :EdicaoLivro, :CaminhoFotoLivro, :QuantidadeLivros)";
            $stmtLivro = $conn->prepare($sqlLivro);
            $stmtLivro->bindParam(':NomeLivro', $dadosLivro['NomeLivro']);
            $stmtLivro->bindParam(':IBSMLivro', $dadosLivro['IBSMLivro']);
            $stmtLivro->bindParam(':LocalLivro', $dadosLivro['LocalLivro']);
            $stmtLivro->bindParam(':PrateleiraLivro', $dadosLivro['PrateleiraLivro']);
            $stmtLivro->bindParam(':ColunaLivro', $dadosLivro['ColunaLivro']);
            $stmtLivro->bindParam(':Autor_idAutor', $idAutor);
            $stmtLivro->bindParam(':Genero_idGenero', $idGenero);
            $stmtLivro->bindParam(':Idioma_idIdioma', $dadosLivro['Idioma_idIdioma']);
            $stmtLivro->bindParam(':EditoraLivro', $dadosLivro['EditoraLivro']);
            $stmtLivro->bindParam(':EdicaoLivro', $dadosLivro['EdicaoLivro']);
            $stmtLivro->bindParam(':CaminhoFotoLivro', $dadosLivro['CaminhoFotoLivro']);
            $stmtLivro->execute();

            // Finalize a transação
            $conn->commit();

            // Redirecione para uma página de sucesso ou outra página apropriada após o cadastro
             //header("Location: ../View/livros.php");
            exit();
        } catch (PDOException $e) {
            // Em caso de erro, faça o rollback da transação e exiba uma mensagem de erro
            $conn->rollBack();
            echo "Erro: " . $e->getMessage();
        }
    }
}