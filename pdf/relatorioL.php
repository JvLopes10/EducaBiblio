<?php
include "../Controller/Clivros.php";
$listaLivros = Clivros::retornarlivros();


//var_dump($listaLivros);

require "dompdf/autoload.inc.php";
$dompdf = new Dompdf\Dompdf();



$html = "<style>
* {
    font-family: Verdana, Arial, sans-serif;
}
table{
    font-size: x-small;
}
tfoot tr td{
    font-weight: bold;
    font-size: x-small;
}

.gray {
    background-color: lightgray
}
</style>
<html>
<head></head>
<body>
<center><h3>Livros Cadastrados - Equipe 7</h3></center>
  <table width='100%'>
    <tr>
        <td valign='topt'><img src='logo.png'/></td>
        <td align='right'>
            <pre>
            <strong>
            A biblioteca pública, assim como a escola, a delegacia, o centro de saúde é
            um serviço público tradicional e conhecido do morador da cidade, isso 
            não significa que seu papel esteja claro e tampouco seja imutável.
            </strong>
            </pre>
        </td>
        
    </tr>

  </table>
  <table width='100%'>
    <tr>
        <td><strong>EEEP José Vidal Alves</strong></td>
    </tr>

  </table>

  <br/>
    <table width='100%'>
    <thead style='background-color: lightgray;'>
      <tr>
        <th>#</th>
        <th>Livros</th>
        <th>Autor</th>
        <th>Gênero</th>
      </tr>
    </thead>
    <tbody>";

        foreach ($listaLivros as $livros) {
            $html .= "<tr>";
            $html .= "<td>" . $livros['it_id'] . "</td>";
            $html .= "<td>" . $livros['it_nome'] . "</td>";
            $html .= "<td>" . $livros['it_autor'] . "</td>";
            $html .= "<td>" . $livros['it_genero'] . "</td>";
            $html .= "</tr>";
        }

$html .="
    </tbody>
  </table>
</body>
</html>";



$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream("Dados do Funcionário", array("Attachment" => false));

use Dompdf\Options;
$options = new Options();
$options->setIsRemoteEnabled(true);
$options->setOptions.($options);
?>