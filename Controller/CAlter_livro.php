<?php
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    // Importe o arquivo que contém a classe responsável pelas operações com livros
    require_once('CConexao.php'); // Inclua o arquivo que contém a classe de conexão

    class CAtualizar_livro
    {
        public function atualizarLivro($idLivro, $NomeLivro, $EditoraLivro, $IBSMLivro, $Genero_idGenero, $Idioma_idIdioma, $QuantidadeLivros, $LocalLivro, $PrateleiraLivro, $ColunaLivro)
        {
            try {
                // Crie uma instância da classe de conexão
                $conexao = new CConexao();
                $conn = $conexao->getConnection();

                // Construa a consulta SQL para atualizar o livro
                $sql = "UPDATE livro SET 
                            NomeLivro = :NomeLivro, 
                            EditoraLivro = :EditoraLivro, 
                            IBSMLivro = :IBSMLivro, 
                            Genero_idGenero = :Genero_idGenero, 
                            Idioma_idIdioma = :Idioma_idIdioma, 
                            QuantidadeLivros = :QuantidadeLivros, 
                            LocalLivro = :LocalLivro, 
                            PrateleiraLivro = :PrateleiraLivro, 
                            ColunaLivro = :ColunaLivro 
                        WHERE idLivro = :idLivro";

                // Prepare a consulta
                $stmt = $conn->prepare($sql);

                // Associe os valores aos parâmetros da consulta
                $stmt->bindParam(':NomeLivro', $NomeLivro);
                $stmt->bindParam(':EditoraLivro', $EditoraLivro);
                $stmt->bindParam(':IBSMLivro', $IBSMLivro);
                $stmt->bindParam(':Genero_idGenero', $Genero_idGenero);
                $stmt->bindParam(':Idioma_idIdioma', $Idioma_idIdioma);
                $stmt->bindParam(':QuantidadeLivros', $QuantidadeLivros);
                $stmt->bindParam(':LocalLivro', $LocalLivro);
                $stmt->bindParam(':PrateleiraLivro', $PrateleiraLivro);
                $stmt->bindParam(':ColunaLivro', $ColunaLivro);
                $stmt->bindParam(':idLivro', $idLivro);

                // Execute a consulta
                $stmt->execute();

                // Verifique se a atualização foi realizada
                if ($stmt->rowCount() >= 0) {
                    return true; // Atualização bem-sucedida ou nenhum dado foi modificado
                } else {
                    return false; // Falha na atualização
                }
            } catch (PDOException $e) {
                echo "Erro na atualização do livro: " . $e->getMessage();
                return false; // Falha na atualização
            }
        }
    }

    // Seu código continua aqui para manipular a atualização do livro com base nos dados recebidos via POST
}
?>
