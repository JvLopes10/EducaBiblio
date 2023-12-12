<?php
// Incluir arquivo de conexão
include '../Controller/CConexao.php';

// Inicializar a sessão
session_start();

// Verificar se o ID do empréstimo foi passado por GET
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $idEmprestimo = $_GET['id'];

    try {
        // Criar uma nova instância da classe de conexão
        $conexao = new CConexao();
        $conn = $conexao->getConnection();

        // Consultar o StatusEmprestimo atual na tabela emprestimo
        $sqlCheckStatus = "SELECT StatusEmprestimo FROM emprestimo WHERE idEmprestimo = :id";
        $stmt = $conn->prepare($sqlCheckStatus);
        $stmt->bindParam(':id', $idEmprestimo, PDO::PARAM_INT);
        $stmt->execute();
        $statusEmprestimo = $stmt->fetchColumn();

        if ($statusEmprestimo === false) {
            echo "Empréstimo não encontrado.";
            header("Location: ../view/devolucao.php");
            exit(); // Encerra a execução do script após o redirecionamento
        }

        // Verificar se o livro já foi devolvido
        if ($statusEmprestimo == 0 || $statusEmprestimo == 1) {
            // Atualizar o StatusEmprestimo para 2 (devolvido) ou 4 (devolvido com pendência)
            $newStatus = ($statusEmprestimo == 0) ? 2 : 4;

            // Atualizar o StatusEmprestimo na tabela emprestimo
            $sqlUpdateStatus = "UPDATE emprestimo SET StatusEmprestimo = :newStatus WHERE idEmprestimo = :id";
            $stmt = $conn->prepare($sqlUpdateStatus);
            $stmt->bindParam(':newStatus', $newStatus, PDO::PARAM_INT);
            $stmt->bindParam(':id', $idEmprestimo, PDO::PARAM_INT);
            $stmt->execute();
        }

        // Verificar se já existe uma devolução para esse empréstimo na tabela devolucao
        $sqlCheckDevolucao = "SELECT * FROM devolucao WHERE emprestimo_idEmprestimo = :id";
        $stmt = $conn->prepare($sqlCheckDevolucao);
        $stmt->bindParam(':id', $idEmprestimo, PDO::PARAM_INT);
        $stmt->execute();
        $devolucaoExists = $stmt->fetch();

        if ($devolucaoExists) {
            // Se a devolução já existe, atualize a data de devolução na tabela devolucao com a data atual do servidor
            $sqlUpdateDevolucao = "UPDATE devolucao SET DataDevolvida = CURDATE() WHERE emprestimo_idEmprestimo = :id";
            $stmt = $conn->prepare($sqlUpdateDevolucao);
            $stmt->bindParam(':id', $idEmprestimo, PDO::PARAM_INT);
            $stmt->execute();
        } else {
            // Se não existe, insira uma nova entrada na tabela devolucao com a data atual do servidor
            $sqlInsertDevolucao = "INSERT INTO devolucao (DataDevolucao, DataDevolvida, StatusDevolucao, emprestimo_idEmprestimo)
                                    VALUES (CURDATE(), CURDATE(), 0, :id)";
            $stmt = $conn->prepare($sqlInsertDevolucao);
            $stmt->bindParam(':id', $idEmprestimo, PDO::PARAM_INT);
            $stmt->execute();
        }

        echo "Livro devolvido com sucesso!";
        header("Location: ../view/devolucao.php");
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
    }
} else {
    echo "ID do empréstimo não fornecido.";
    header("Location: ../view/devolucao.php");
}
?>
