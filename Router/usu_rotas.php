<?php

    require_once('../Controller/CAlter_usu.php'); // Inclua o arquivo que contém a classe CAlter_usu
var_Dump($_POST);
if (isset($_POST['Editar'])) {
    // Recupere os dados do formulário
    $idUsuario = $_POST['idUsuario'];
    $UserUsuario = $_POST['UserUsuario'];
    $NomeUsuario = $_POST['NomeUsuario'];
    $EmailUsuario = $_POST['EmailUsuario'];
    $SenhaUsuario = $_POST['SenhaUsuario'];

    // Tratamento da imagem
    $fotoUsuario = $_FILES['FotoUsuario']['name']; // Nome do arquivo
    $fotoUsuarioTemp = $_FILES['FotoUsuario']['tmp_name']; // Arquivo temporário

    // Pasta de destino para a imagem
    $pastaDestino = "../img/fotoUsu/" . $fotoUsuario;

    // Movendo o arquivo para a pasta de destino
    move_uploaded_file($fotoUsuarioTemp, $pastaDestino);

    // Caminho da foto para armazenar no banco (caminho completo)
    $caminhoFoto = "../img/fotoUsu/" . $fotoUsuario;

    // Crie uma instância da classe CAlter_usu
    $alteracaoUsuario = new CAlter_usu();

    // Chame o método para atualizar o usuário pelo ID
    $resultado = $alteracaoUsuario->atualizarUsuario($idUsuario, $UserUsuario, $NomeUsuario, $EmailUsuario, $SenhaUsuario, $fotoUsuario, $caminhoFoto);

    if ($resultado) {
        echo "Usuário atualizado com sucesso!";
        header("Location: ../view/usuarios.php");
    } else {
        echo "Falha ao atualizar o usuário.";
    }
}
