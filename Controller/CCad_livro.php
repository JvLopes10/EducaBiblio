<?php
include('../Controller/CConexao.php');

class LivroController
{
    public function cadastrarLivro($dadosLivro)
    {
        try {
            $conexao = new CConexao();
            $conn = $conexao->getConnection();
            $conn->beginTransaction();

            // Verifica se o autor já existe na tabela Autor
            $idAutor = $this->buscarOuCriarAutor($conn, $dadosLivro['NomeAutor']);

            // Inserir os dados do livro na tabela Livro
            $this->inserirLivro($conn, $dadosLivro, $idAutor);

            // Finaliza a transação
            $conn->commit();

            // Redirecionar para uma página de sucesso ou outra página apropriada após o cadastro
            header("Location: ../View/livros.php");
            exit();
        } catch (PDOException $e) {
            // Em caso de erro, realizar o rollback da transação e exibir uma mensagem de erro
            $conn->rollBack();
            echo "Erro: " . $e->getMessage();
        }
    }

    private function buscarOuCriarAutor($conn, $nomeAutor)
    {
        // Verifica se o autor já existe na tabela Autor
        $sqlCheckAutor = "SELECT idAutor FROM Autor WHERE NomeAutor = :NomeAutor";
        $stmtCheckAutor = $conn->prepare($sqlCheckAutor);
        $stmtCheckAutor->bindParam(':NomeAutor', $nomeAutor);
        $stmtCheckAutor->execute();
        $autor = $stmtCheckAutor->fetch(PDO::FETCH_ASSOC);

        // Se o autor existir, retorna o ID do autor existente
        if ($autor) {
            return $autor['idAutor'];
        }

        // Se o autor não existir, insere o novo autor na tabela Autor e retorna o ID
        $sqlNovoAutor = "INSERT INTO Autor (NomeAutor) VALUES (:NomeAutor)";
        $stmtNovoAutor = $conn->prepare($sqlNovoAutor);
        $stmtNovoAutor->bindParam(':NomeAutor', $nomeAutor);
        $stmtNovoAutor->execute();

        // Retorna o ID do autor recém-inserido
        return $conn->lastInsertId();
    }

    private function inserirLivro($conn, $dadosLivro, $idAutor)
    {
        $sqlLivro = "INSERT INTO Livro (NomeLivro, IBSMLivro, LocalLivro, PrateleiraLivro, ColunaLivro, autor_idAutor, Genero_idGenero, Idioma_idIdioma, EditoraLivro, EdicaoLivro, QuantidadeLivros, DidaticoLivro)
                     VALUES (:NomeLivro, :IBSMLivro, :LocalLivro, :PrateleiraLivro, :ColunaLivro, :autor_idAutor, :Genero_idGenero, :Idioma_idIdioma, :EditoraLivro, :EdicaoLivro, :QuantidadeLivros, :DidaticoLivro)";
        $stmtLivro = $conn->prepare($sqlLivro);
        $stmtLivro->bindParam(':NomeLivro', $dadosLivro['NomeLivro']);
        $stmtLivro->bindParam(':IBSMLivro', $dadosLivro['IBSMLivro']);
        $stmtLivro->bindParam(':LocalLivro', $dadosLivro['LocalLivro']);
        $stmtLivro->bindParam(':PrateleiraLivro', $dadosLivro['PrateleiraLivro']);
        $stmtLivro->bindParam(':ColunaLivro', $dadosLivro['ColunaLivro']);
        $stmtLivro->bindParam(':autor_idAutor', $idAutor);
        $stmtLivro->bindParam(':Idioma_idIdioma', $dadosLivro['Idioma_idIdioma']);
        $stmtLivro->bindParam(':Genero_idGenero', $dadosLivro['Genero_idGenero']);
        $stmtLivro->bindParam(':EditoraLivro', $dadosLivro['EditoraLivro']);
        $stmtLivro->bindParam(':EdicaoLivro', $dadosLivro['EdicaoLivro']);
        $stmtLivro->bindParam(':QuantidadeLivros', $dadosLivro['QuantidadeLivros']);
        $stmtLivro->bindParam(':DidaticoLivro', $dadosLivro['DidaticoLivro']);
        $stmtLivro->execute();
    }
}
