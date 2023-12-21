<?php
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    // Importe o arquivo que contém a classe responsável pelas operações com alunos
    require_once('../Controller/CAlter_aluno.php');

    // Verifica se os campos necessários foram enviados via POST
    if (
        isset($_POST['idAluno']) && 
        isset($_POST['NomeAluno']) && 
        isset($_POST['EmailAluno']) && 
        isset($_POST['Turma_idTurma'])
    ) {
        // Atribui os valores enviados via POST a variáveis
        $idAluno = $_POST['idAluno'];
        $NomeAluno = $_POST['NomeAluno'];
        $EmailAluno = $_POST['EmailAluno'];
        $Turma_idTurma = $_POST['Turma_idTurma'];

        // Cria uma instância da classe responsável pelas operações com alunos
        $alteracaoAluno = new CAlter_aluno();

        // Chama o método para atualizar o aluno pelo ID
        $resultado = $alteracaoAluno->atualizarAluno($idAluno, $NomeAluno, $EmailAluno, $Turma_idTurma);

        if ($resultado) {
            echo "Aluno atualizado com sucesso!";
            header("Location: ../view/aluno.php"); // Redireciona para a página correta após a atualização do aluno
            exit(); // Encerra o script após o redirecionamento
        } else {
            echo "Falha ao atualizar o aluno.";
        }
    } else {
        echo "Por favor, preencha todos os campos necessários.";
        header("Location: ../view/aluno.php"); // Redireciona para a página correta após a atualização do aluno
    }
} else {
    echo "O envio do formulário não foi detectado.";
}
?>
