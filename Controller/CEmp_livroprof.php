<?php
require_once 'CConexao.php';

class CEmprestimoControllerProf
{
    public function emprestarLivro()
    {
        if (isset($_POST['emprestar'])) {
            // Obtenha os dados do formulário
            $dataEmprestimo = $_POST['DataEmprestimo'];
            $livroId = $_POST['livro_idLivro'];
            $usuarioId = $_POST['usuario_idUsuario'];
            $profId = $_POST['prof_idProf']; // Novo campo para o ID do professor
            $quantidade = $_POST['quantidade'];

            // Conecte-se ao banco de dados
            $conexao = new CConexao();
            $conn = $conexao->getConnection();

            // Verifique se já existe um empréstimo para o mesmo livro, professor e data
            $queryCheck = "SELECT COUNT(*) as count_emprestimo FROM emprestimo WHERE DataEmprestimo = :dataEmprestimo AND livro_idLivro = :livroId AND prof_idProf = :profId";
            $stmtCheck = $conn->prepare($queryCheck);
            $stmtCheck->bindParam(':dataEmprestimo', $dataEmprestimo);
            $stmtCheck->bindParam(':livroId', $livroId);
            $stmtCheck->bindParam(':profId', $profId);
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

            if ($result['count_emprestimo'] > 0) {
                echo "Empréstimo já existe para este livro, professor e data.";
            } else {
                // Execute a inserção no banco de dados
                $queryInsert = "INSERT INTO emprestimo (DataEmprestimo, livro_idLivro, usuario_idUsuario, prof_idProf, Quantidade_emp) VALUES (:dataEmprestimo, :livroId, :usuarioId, :profId, :quantidade)";
                $stmtInsert = $conn->prepare($queryInsert);
                $stmtInsert->bindParam(':dataEmprestimo', $dataEmprestimo);
                $stmtInsert->bindParam(':livroId', $livroId);
                $stmtInsert->bindParam(':usuarioId', $usuarioId);
                $stmtInsert->bindParam(':profId', $profId);
                $stmtInsert->bindParam(':quantidade', $quantidade);

                if ($stmtInsert->execute()) {
                    echo "Empréstimo cadastrado com sucesso!";

                    // Insira lógica para adicionar uma entrada de devolução pendente na tabela 'devolucao'
                    $emprestimoId = $conn->lastInsertId(); // Obtém o ID do empréstimo recém-inserido

                    $dataDevolucao = date('Y-m-d', strtotime($dataEmprestimo . ' + 7 days')); // Define a data de devolução após 7 dias (por exemplo)

                    $queryInsertDevolucao = "INSERT INTO devolucao (DataDevolucao, StatusDevolucao, emprestimo_idEmprestimo) VALUES (:dataDevolucao, 'Pendente', :emprestimoId)";
                    $stmtInsertDevolucao = $conn->prepare($queryInsertDevolucao);
                    $stmtInsertDevolucao->bindParam(':dataDevolucao', $dataDevolucao);
                    $stmtInsertDevolucao->bindParam(':emprestimoId', $emprestimoId);

                    if ($stmtInsertDevolucao->execute()) {
                        echo "Registro de devolução pendente adicionado com sucesso!";
                    } else {
                        echo "Erro ao adicionar registro de devolução pendente.";
                    }
                } else {
                    echo "Erro ao cadastrar o empréstimo.";
                }
            }
        }
    }
}
