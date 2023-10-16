<?php
include('../Controller/CConexao.php'); // Inclui o arquivo de conexão

class CCad_prof {
    // Função para cadastrar um professor no banco de dados
    public function cadastrarProfessor($nome, $email, $materia) {
        // Conecte-se ao banco de dados
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Certifique-se de que os parâmetros estejam devidamente filtrados e seguros contra SQL injection
        // Substitua as informações abaixo pelos campos da tabela do seu banco de dados
        $stmt = $conn->prepare("INSERT INTO prof (NomeProf, EmailProf, MateriaProf) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $nome);
        $stmt->bindParam(2, $email);
        $stmt->bindParam(3, $materia);

        if ($stmt->execute()) {
            echo "Professor cadastrado com sucesso!";
        } else {
            echo "Erro ao cadastrar o professor: " . $stmt->errorInfo()[2];
        }
    }
}
?>
