<?php

var_dump($_POST);
// Importe o arquivo que contém a classe CAlter_prof
require_once('../Controller/CAlter_prof.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Editar'])) {
    $idProf = $_POST['idProf'];
    $NomeProf = $_POST['NomeProf'];
    $EmailProf = $_POST['EmailProf'];
    $MateriaProf = $_POST['MateriaProf'];

    // Crie uma instância da classe CAlter_prof
    $alteracaoProfessor = new CAlter_prof();

    // Chame o método para atualizar o professor pelo ID
    $resultado = $alteracaoProfessor->atualizarProfessor($idProf, $NomeProf, $EmailProf, $MateriaProf);

    if ($resultado) {
        echo "Professor atualizado com sucesso!";
        header("Location: ../view/professores.php"); // Redireciona para a página correta após a atualização do professor
    } else {
        echo "Falha ao atualizar o professor.";
    }
}
?>
