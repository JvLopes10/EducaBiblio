<?php

include 'config.php';

$sql = "SELECT aluno.idAluno,
aluno.NomeAluno,
aluno.EmailAluno,
aluno.Turma_idTurma

 FROM aluno";

$res = $conn->query($sql);



if($res->num_rows > 0){
    $html =  "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    $html .= "<thead>";
    $html .= "<tr>";
    $html .= "<th style='border: 1px solid #000; padding: 8px;'>ID</th>";
    $html .= "<th style='border: 1px solid #000; padding: 8px;'>Nome</th>";
    $html .= "<th style='border: 1px solid #000; padding: 8px;'>E-mail</th>";
    $html .= "<th style='border: 1px solid #000; padding: 8px;'>Turma ID</th>";
    $html .= "</tr>";
    $html .= "</thead>";
    $html .= "<tbody>";
    
    while($row = $res->fetch_object()){
        $html .= "<tr>";
        $html .= "<td style='border: 1px solid #000; padding: 8px;'>".$row->idAluno."</td>";
        $html .= "<td style='border: 1px solid #000; padding: 8px;'>".$row->NomeAluno."</td>";
        $html .= "<td style='border: 1px solid #000; padding: 8px;'>".$row->EmailAluno."</td>";
        $html .= "<td style='border: 1px solid #000; padding: 8px;'>".$row->Turma_idTurma."</td>";
        $html .= "</tr>";
    }

    $html .= "</tbody>";
    $html .= "</table>";
}else{
    $html = 'Nenhum dado registrado';
}

use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_option('defaultFont', 'sans');

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("Dados dos leitores", array("Attachment" => false));
?>
