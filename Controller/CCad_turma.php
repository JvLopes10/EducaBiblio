<?php

include('../Controller/CConexao.php');

class CCad_turma {
    private $pdo; // Adicione uma propriedade para armazenar a conexão PDO

    public function __construct() {
        // Crie uma instância da classe CConexao e obtenha a conexão PDO no construtor
        $conexao = new CConexao();
        $this->pdo = $conexao->getConnection();
    }

    public function cadastrarTurma() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Enviar') {
            // Processar os dados do formulário
            $anoTurma = $_POST['AnoTurma'];
            $nomeTurma = $_POST['NomeTurma'];
            
            // Preparar e executar a instrução SQL para inserção dos dados
            $sql = "INSERT INTO turma (AnoTurma, NomeTurma) VALUES (:AnoTurma, :NomeTurma)";
            $stmt = $this->pdo->prepare($sql); // Use $this->pdo para acessar a conexão PDO

            // Vincular os valores dos campos do formulário à instrução SQL
            $stmt->bindParam(':AnoTurma', $anoTurma, PDO::PARAM_STR);
            $stmt->bindParam(':NomeTurma', $nomeTurma, PDO::PARAM_STR);

            // Executar a instrução SQL
            if ($stmt->execute()) {
                // Redirecionar o usuário para uma página de confirmação ou outra página apropriada
                header('Location: ../View/turma.php');
                exit();
            } else {
                echo 'Erro ao cadastrar a turma no banco de dados.';
            }
        }
    }
}
