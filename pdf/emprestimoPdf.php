<?php

include 'config.php';

$sqlAlunos = "
    SELECT
        livro.NomeLivro AS TituloLivro,
        genero.NomeGenero,
        emprestimo.idEmprestimo,
        turma.NomeTurma,
        aluno.NomeAluno,
        turma.AnoTurma,
        emprestimo.DataEmprestimo,
        devolucao.DataDevolucao,
        emprestimo.Quantidade_emp,
        usuario.UserUsuario
    FROM emprestimo
    LEFT JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
    INNER JOIN livro ON emprestimo.livro_idLivro = livro.idLivro
    INNER JOIN genero ON livro.Genero_idGenero = genero.idGenero
    INNER JOIN turma ON aluno.Turma_idTurma = turma.IdTurma
    INNER JOIN usuario ON emprestimo.usuario_idUsuario = usuario.idUsuario
    LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo";

$sqlProfessores = "
    SELECT
        livro.NomeLivro AS TituloLivro,
        genero.NomeGenero,
        emprestimo.idEmprestimo,
        'Professor' AS NomeTurma,
        prof.NomeProf AS NomeLeitor,
        NULL AS AnoTurma,
        emprestimo.DataEmprestimo,
        devolucao.DataDevolucao,
        emprestimo.Quantidade_emp,
        usuario.UserUsuario
    FROM emprestimo
    LEFT JOIN prof ON emprestimo.prof_idProf = prof.idProf
    INNER JOIN livro ON emprestimo.livro_idLivro = livro.idLivro
    INNER JOIN genero ON livro.Genero_idGenero = genero.idGenero
    INNER JOIN usuario ON emprestimo.usuario_idUsuario = usuario.idUsuario
    LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo
    WHERE prof.idProf IS NOT NULL"; // Usando a condição na tabela 'prof'

// Consulta geral unindo empréstimos de alunos e professores
$sql = "($sqlAlunos) UNION ($sqlProfessores)";
$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $html = "<html>
    <head>
    <title>EducaBiblio</title>
        <style>
            body {
                font-family: 'Arial', sans-serif;
                margin: 0;
                padding: 0;
            }
            h1 {
                text-align: center;
                color: #ffffff;
                margin-bottom: 20px;
                background-color: rgba(76,175,80); 
                padding: 10px; 
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
            tbody tr:nth-child(even) {
                background-color: #f2f2f2; /* Light Gray */
            }
            tbody tr:nth-child(odd) {
                background-color: #fff; /* White */
            }
            .footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                text-align: center;
                background-color: #4CAF50;
                color: white;
                padding: 10px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div id='library-info'>
            <h1>Tabela de Empréstimos</h1>
            <p>
                Bem-vindo ao EducaBiblio, o seu sistema de biblioteca dedicado à promoção da educação e leitura! Abaixo, apresentamos os registros dos empréstimos realizados.
            </p>
        </div>
        <table>
            <thead>
                <tr>
                <th>ID</th>
                <th>Livro</th>
                <th>Quantidade</th>
                <th>Leitor</th>
                <th>Turma</th>
                <th>Data do empréstimo</th>
                <th>Usuário</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $res->fetch_object()) {
        $html .= "<tr>";
        $html .= "<td>" . $row->idEmprestimo . "</td>";
        $html .= "<td>" . $row->TituloLivro . "</td>";
        $html .= "<td>" . $row->Quantidade_emp . "</td>";
        $html .= "<td>" . (isset($row->NomeAluno) ? $row->NomeAluno : $row->NomeLeitor) . "</td>";
        $html .= "<td>" . $row->NomeTurma . "</td>";
        $html .= "<td>" . $row->DataEmprestimo . "</td>";
        $html .= "<td>" . $row->UserUsuario . "</td>";

        $html .= "</tr>";
    }

    $html .= "</tbody>
        </table>
        <div class='footer'>
        Governo do Estado do Ceará - Educação e Leitura
        </div>
    </body>
    </html>";
} else {
    $html = 'Não há dados a serem exibidos.';
}

use Dompdf\Dompdf;

require_once 'dompdf/autoload.inc.php';

$dompdf = new Dompdf();
  
$dompdf->loadHtml($html);

$dompdf->set_option('defaultFont', 'sans');

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream("Tabela de empréstimo", array("Attachment" => false));
