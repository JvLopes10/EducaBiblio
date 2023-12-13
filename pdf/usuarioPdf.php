<?php
include 'config.php';

$sql = "SELECT
usuario.NomeUsuario,
usuario.idUsuario,
usuario.UserUsuario,
usuario.EmailUsuario,
usuario.camfoto
FROM usuario";

$res = $conn->query($sql);

if ($res->num_rows > 0) {
    $html = "<html>
    <head>
        <style>
            body {
                font-family: 'Arial';
            }
            h1 {
                font-family: 'Arial';
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
                background-color: #fff; /* White table background */
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Box shadow for a subtle effect */
            }
            th, td {
                border: 1px solid #333;
                padding: 12px;
                text-align: center;
            }
            th {
                background-color: #4CAF50; /* Green header background */
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
            Bem-vindo ao EducaBiblio, o seu sistema de biblioteca dedicado à promoção da educação e leitura! Abaixo, apresentamos os registros dos nossos usuários cadastrados.
            </p>
        </div>
        <h1>Tabela de usuários</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>E-mail</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $res->fetch_object()) {
        $html .= "<tr>";
        $html .= "<td>" . $row->idUsuario . "</td>";
        $html .= "<td>" . $row->NomeUsuario . "</td>";
        $html .= "<td>" . $row->UserUsuario . "</td>";
        $html .= "<td>" . $row->EmailUsuario . "</td>";
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
