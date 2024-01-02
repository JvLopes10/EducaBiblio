<?php
var_dump($_POST);
// Verifica se houve um envio de dados pelo método POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    // Importe a classe responsável pela atualização do empréstimo
    require_once('Controller/CAlter_emprestimo.php'); // Certifique-se do nome correto do arquivo

    // Verifica se os campos necessários foram preenchidos
    if (
        isset($_POST['idEmprestimo']) &&
        isset($_POST['Genero_idGenero']) &&
        isset($_POST['livro_idLivro']) &&
        isset($_POST['Turma_idTurma']) &&
        isset($_POST['DataEmprestimo']) &&
        isset($_POST['quantidade']) &&
        isset($_POST['data']) &&
        isset($_POST['usuario_idUsuario'])
    ) {
        // Recupera os dados do formulário
        $idEmprestimo = $_POST['idEmprestimo'];
        $Genero_idGenero = $_POST['Genero_idGenero'];
        $livro_idLivro = $_POST['livro_idLivro'];
        $Turma_idTurma = $_POST['Turma_idTurma'];
        $DataEmprestimo = $_POST['DataEmprestimo'];
        $quantidade = $_POST['quantidade'];
        $data = $_POST['data'];
        $usuario_idUsuario = $_POST['usuario_idUsuario'];

        // Verifica se os campos para aluno e professor estão definidos e atribui seus valores
        $aluno_idAluno = isset($_POST['aluno_idAluno']) && $_POST['aluno_idAluno'] !== '' ? $_POST['aluno_idAluno'] : null;
        $prof_idProf = isset($_POST['prof_idProf']) && $_POST['prof_idProf'] !== '' ? $_POST['prof_idProf'] : null;

        // Verifica se os campos para professor e aluno estão vazios e atribui null
        if ($prof_idProf === '') {
            $prof_idProf = null;
        }

        if ($aluno_idAluno === '') {
            $aluno_idAluno = null;
        }

        // Cria uma instância da classe para atualizar o empréstimo
        $atualizacaoEmprestimo = new CAtualizarEmprestimo();

        // Chama o método para atualizar o empréstimo
        $resultadoAtualizacao = $atualizacaoEmprestimo->atualizarEmprestimo(
            $idEmprestimo,
            $Genero_idGenero,
            $livro_idLivro,
            $Turma_idTurma,
            $aluno_idAluno,
            $prof_idProf,
            $DataEmprestimo,
            $quantidade,
            $data,
            $usuario_idUsuario
        );

        if ($resultadoAtualizacao) {
            // Redirecione para alguma página de sucesso após a atualização
            header("Location: ../view/emprestimos.php");
            exit();
        } else {
            // Se houver um erro na atualização, redirecione para uma página de erro ou faça alguma outra gestão
            header("Location: ../view/emprestimos.php");
            exit();
        }
    } else {
        // Redirecione para alguma página de erro, pois parece que algum campo obrigatório não foi preenchido
        header("Location: ../view/emprestimos.php");
        exit();
    }
} else {
    // Redirecione para alguma página de erro, pois parece que o envio do formulário não foi corretamente tratado
    header("Location: ../view/emprestimos.php");
    exit();
}
?>
