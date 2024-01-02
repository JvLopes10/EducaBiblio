<?php
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    // Importe o arquivo que contém a classe responsável pelas operações com livros
    require_once('../Controller/CConexao.php'); // Inclua o arquivo que contém a classe de conexão

    class CAtualizar_livro
    {
        public function atualizarLivro($idLivro, $NomeLivro, $EditoraLivro, $IBSMLivro, $Genero_idGenero, $Idioma_idIdioma, $QuantidadeLivros, $LocalLivro, $Tombo)
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
                            Tombo = :Tombo 
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
                $stmt->bindParam(':Tombo', $Tombo); // Adicionando o Tombo como parâmetro
                $stmt->bindParam(':idLivro', $idLivro);

                // Execute a consulta
                $stmt->execute();

                // Verifique se a atualização foi realizada
                if ($stmt->rowCount() > 0) {
                    return true; // Atualização bem-sucedida
                } else {
                    return false; // Nenhum dado foi modificado ou falha na atualização
                }
            } catch (PDOException $e) {
                echo "Erro na atualização do livro: " . $e->getMessage();
                return false; // Falha na atualização
            }
        }
    }

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
        isset($_POST['Tombo']) // Adição da variável Tombo
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
        $Tombo = $_POST['Tombo']; // Atribuição da variável Tombo

        // Cria uma instância da classe responsável pelas operações com livros
        $atualizacaoLivro = new CAtualizar_livro();

        // Chama o método para atualizar o livro pelo ID
        $resultado = $atualizacaoLivro->atualizarLivro($idLivro, $NomeLivro, $EditoraLivro, $IBSMLivro, $Genero_idGenero, $Idioma_idIdioma, $QuantidadeLivros, $LocalLivro, $Tombo); // Adição da variável Tombo como parâmetro

        if ($resultado) {
            echo "Livro atualizado com sucesso!";
             header("Location: ../view/livros.php"); // Redireciona para a página correta após a atualização do livro
            exit(); // Encerra o script após o redirecionamento
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
var_dump($_POST);
?>
