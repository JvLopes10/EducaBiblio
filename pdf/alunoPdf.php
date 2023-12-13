<?php

include 'config.php';

$sql = "SELECT aluno.NomeAluno,
aluno.idAluno,
aluno.Turma_idTurma,
aluno.EmailAluno,
'aluno' AS tipo,
turma.nomeTurma,
turma.AnoTurma  
FROM aluno
LEFT JOIN turma ON aluno.Turma_idTurma = turma.idTurma 
UNION
SELECT
prof.NomeProf AS NomeAluno,
prof.idProf AS idAluno,
NULL AS Turma_idTurma,
prof.EmailProf AS EmailAluno,
'prof' AS tipo,
NULL AS nomeTurma,
NULL AS AnoTurma  
FROM prof";

$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $html = "<html>
    <head>
        <style>
            body {
                font-family: 'Arial';
            }
            h1 {
                text-align: center;
                color: #333;
            }
            #library-info {
                text-align: center;
                margin: 20px 0;
            }
            table {
                border-collapse: collapse;
                width: 100%;
                margin-top: 20px;
                background-color: #fff; 
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); 
            }
            th, td {
                border: 1px solid #333;
                padding: 12px;
                text-align: center;
            }
            th {
                background-color: #4CAF50; 
                color: white;
                font-weight: bolder;
            }
            #logo {
                max-width: 100px;
                margin-right: 20px;
            }
        </style>
    </head>
    <body>
        <div id='library-info'>
            <img id='logo' src='logoCeara.png'>
            <p>
            Bem-vindo ao EducaBiblio, o seu sistema de biblioteca dedicado à promoção da educação e leitura! Abaixo, apresentamos os registros dos nossos leitores cadastrados.
            </p>
        </div>
        <h1>Tabela de leitores</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Série</th>
                    <th>Turma</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $res->fetch_object()) {
        $html .= "<tr>";
        $html .= "<td>" . $row->idAluno . "</td>";
        $html .= "<td>" . $row->NomeAluno . "</td>";
        $html .= "<td>" . $row->EmailAluno . "</td>";
        $html .= "<td>" . $row->AnoTurma . 'º ' . "</td>";
        $html .= "<td>" . $row->nomeTurma . "</td>";
        $html .= "</tr>";
    }

    $html .= "</tbody>
        </table>
    </body>
    </html>";
} else {
    $html = 'Não há dados a serem exibidos';
}


use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->set_option('defaultFont', 'sans');

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("Tabelas de leitores", array("Attachment" => false));
?>
