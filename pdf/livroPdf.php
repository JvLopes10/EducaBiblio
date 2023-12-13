<?php

include 'config.php';

$sql = "SELECT
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
        FROM
            livro
        LEFT JOIN
            genero ON livro.Genero_idGenero = genero.idGenero
        LEFT JOIN
            autor ON livro.Autor_idAutor = autor.idAutor
        LEFT JOIN
            idioma ON livro.Idioma_idIdioma = idioma.idIdioma";

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
            <img id='logo' src='logo.png'>
            <img id='logo' src='logoCeara.png'>
            <img id='logo' src='logoCeara.png'>
            <p>
            Bem-vindo ao EducaBiblio, o seu sistema de biblioteca dedicado à promoção da educação e leitura! Abaixo, apresentamos os registros dos livros cadastrados.
            </p>
        </div>
        <h1>Tabela de livros</h1>
        <table>
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Título</th>
                    <th>Editora</th>
                    <th>ISBN/CDD</th>
                    <th>Gênero</th>
                    <th>Idioma</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $res->fetch_object()) {
        $html .= "<tr>";
        $html .= "<td>" . $row->idLivro . "</td>";
        $html .= "<td>" . $row->NomeLivro . "</td>";
        $html .= "<td>" . $row->EditoraLivro . "</td>";
        $html .= "<td>" . $row->IBSMLivro . "</td>";
        $html .= "<td>" . $row->GeneroLivro . "</td>";
        $html .= "<td>" . $row->IdiomaLivro . "</td>";
        $html .= "<td>" . $row->QuantidadeLivros . "</td>";
        
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
