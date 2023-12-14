<?php
require_once('../Controller/CConexao.php');
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);

// Consulta SQL para recuperar os dados da tabela Turma
$query = "SELECT idTurma, AnoTurma, NomeTurma FROM turma";

// Executar a consulta
$stmt = $pdo->query($query);

// Obter os resultados como um array
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retornar os resultados como JSON
echo json_encode($result);
