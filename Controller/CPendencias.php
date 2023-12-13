<?php
try {
    // Criar uma nova instância da classe de conexão
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    if ($conn) {
        // Capturar a data atual do usuário
        date_default_timezone_set('America/Fortaleza'); // Configurar o fuso horário
        $dataAtualUsuario = date("Y-m-d");

        // Consulta SQL para obter os dados da tabela de devolução
        $sql = "SELECT d.DataDevolucao, e.idEmprestimo, e.StatusEmprestimo
                FROM devolucao d
                INNER JOIN emprestimo e ON d.emprestimo_idEmprestimo = e.idEmprestimo";
        $stmt = $conn->prepare($sql);
        
        if ($stmt) {
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($result as $row) {
                $dataDevolucao = $row['DataDevolucao'];
                $idEmprestimo = $row['idEmprestimo'];
                $statusEmprestimo = $row['StatusEmprestimo'];

                // Comparar a data atual do usuário com a DataDevolucao
                if ($dataAtualUsuario > $dataDevolucao && ($statusEmprestimo !== '2' && $statusEmprestimo !== '4')) {
                    // Se a data do usuário passou da DataDevolucao e o StatusEmprestimo não é 2 ou 4, atualize para 1
                    $sqlUpdate = "UPDATE emprestimo SET StatusEmprestimo = '1' WHERE idEmprestimo = :idEmprestimo";
                    $stmtUpdate = $conn->prepare($sqlUpdate);

                    if ($stmtUpdate) {
                        $stmtUpdate->bindParam(':idEmprestimo', $idEmprestimo, PDO::PARAM_INT);
                        $stmtUpdate->execute();
                    } else {
                        echo "Erro na preparação da atualização.";
                    }
                }
            }
         //   echo "Status de empréstimo atualizado com sucesso!";
        } else {
            echo "Erro na execução da consulta.";
        }
    } else {
        echo "Falha na conexão com o banco de dados.";
    }
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
?>
