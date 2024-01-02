<?php

include 'config.php';

// Verifica se o parâmetro 'idAluno' está presente na requisição
if (isset($_GET['idProf'])) {
    $idProf = $_GET['idProf'];

    // Modifica a consulta SQL para filtrar pelo ID do aluno
    $sql = "SELECT
    emprestimo.idEmprestimo,
    prof.NomeProf AS Estudante,
    DATE_FORMAT(emprestimo.DataEmprestimo, '%d/%m/%Y') AS DataEmprestimoFormatada,
    IFNULL(DATE_FORMAT(devolucao.DataDevolucao, '%d/%m/%Y'), '--/--/----') AS DataDevolucaoFormatada,
    IFNULL(DATE_FORMAT(devolucao.DataDevolvida, '%d/%m/%Y'), '--/--/----') AS DataDevolvidaFormatada,
    CASE
        WHEN emprestimo.StatusEmprestimo = 0 THEN 'Dentro do prazo'
        WHEN emprestimo.StatusEmprestimo = 1 THEN 'Pendente'
        WHEN emprestimo.StatusEmprestimo = 2 THEN 'Devolvido'
        ELSE 'Status não definido'
    END AS Estado,
    livro.idLivro,
    livro.NomeLivro,
    livro.EditoraLivro,
    livro.IBSMLivro,
    livro.QuantidadeLivros,
    genero.NomeGenero AS GeneroLivro,
    idioma.Idioma AS IdiomaLivro,
    livro.FotoLivro,
    livro.CaminhoFotoLivro,
    livro.LocalLivro,
    livro.PrateleiraLivro,
    livro.ColunaLivro,
    autor.NomeAutor
FROM emprestimo
LEFT JOIN prof ON emprestimo.prof_idProf = prof.idProf
LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo
LEFT JOIN livro ON emprestimo.livro_idLivro = livro.idLivro
LEFT JOIN genero ON livro.Genero_idGenero = genero.idGenero
LEFT JOIN autor ON livro.Autor_idAutor = autor.idAutor
LEFT JOIN idioma ON livro.Idioma_idIdioma = idioma.idIdioma
WHERE prof.idProf = $idProf;
";
} else {
    // Se 'idAluno' não estiver presente, mostra todos os empréstimos (consulta original)
    $sql = "SELECT
                emprestimo.idEmprestimo,
                prof.NomeProf AS Estudante,
                DATE_FORMAT(emprestimo.DataEmprestimo, '%d/%m/%Y') AS DataEmprestimoFormatada,
                IFNULL(DATE_FORMAT(devolucao.DataDevolucao, '%d/%m/%Y'), '--/--/----') AS DataDevolucaoFormatada,
                IFNULL(DATE_FORMAT(devolucao.DataDevolvida, '%d/%m/%Y'), '--/--/----') AS DataDevolvidaFormatada,
                CASE
                    WHEN emprestimo.StatusEmprestimo = 0 THEN 'A prazo'
                    WHEN emprestimo.StatusEmprestimo = 1 THEN 'Pendente'
                    WHEN emprestimo.StatusEmprestimo = 2 THEN 'Devolvido'
                    ELSE 'Status não definido'
                END AS Estado
            FROM emprestimo
            LEFT JOIN prof ON emprestimo.prof_idProf = prof.idProf
            LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo";
}

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
            <h1>Histórico de empréstimos</h1>
            <p>
                Bem-vindo ao EducaBiblio, o seu sistema de biblioteca dedicado à promoção da educação e leitura! Abaixo, apresentamos o histórico de empréstimos já feitos pelo professor.
            </p>
        </div>
        <table>
            <thead>
                <tr>
                <th>Professor</th>
                <th>Livro</th>
                <th>Data do Empréstimo</th>
                <th>Data de Devolução</th>
                <th>Data em que foi Devolvido</th>
                <th>Estado</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $res->fetch_object()) {
        $html .= "<tr>";

        $html .= "<td>" . $row->Estudante . "</td>";
        $html .= "<td>" . $row->NomeLivro . "</td>";
        $html .= "<td>" . $row->DataEmprestimoFormatada . "</td>";
        $html .= "<td>" . $row->DataDevolucaoFormatada . "</td>";
        $html .= "<td>" . $row->DataDevolvidaFormatada . "</td>";
        $html .= "<td>" . $row->Estado . "</td>";

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

$dompdf->setPaper('A4', 'landscape');

$dompdf->render();

$dompdf->stream("Histórico", array("Attachment" => false));
