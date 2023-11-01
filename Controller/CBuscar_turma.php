<?php
// Configurações de conexão com o banco de dados
include('../Controller/CConexao.php');

// Cria uma conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

// Consulta SQL para buscar dados na tabela "turma"
$sql = "SELECT * FROM turma";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Fecha a conexão com o banco de dados
$conn->close();

// Retorna os dados como JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
