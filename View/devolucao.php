<?php
// Inclua o arquivo de conexão ao banco de dados.
include '../Controller/CConexao.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: ../View/login.php"); // Redirecionar para a página de login se não estiver logado
    exit();
}


// Inicialize a instância da classe de conexão.
$conexao = new CConexao();
$conn = $conexao->getConnection();
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="description" content="Página de devolução de livros.">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../ArquivosExternos/icons.js"></script>
    <link rel="shortcut icon" href="../img/icon1.png" type="image/x-icon">
    <link rel="stylesheet" href="../CSS/style.css">
    <link rel="stylesheet" href="../CSS/popup3.css">
    <title>EducaBiblio</title>
</head>
<style>
    .pagination {
        text-align: center;
        margin-top: 15px;

    }

    .page-link {
        display: inline-block;
        padding: 5px 10px;
        margin: 2px;
        border: 1px solid #333;
        background-color: #fff;
        color: #333;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
    }

    .page-link.active {
        background-color: #333;
        color: #fff;
    }

    .page-link:hover {
        background-color: #333;
        color: #fff;
    }
</style>

<body>
    <section id="sidebar">
        <a href="#" class="brand">
            <i class="fas fa-book"></i>
            <span class="text">EducaBiblio</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="inicio.php">
                    <i class='fas fa-home'></i>
                    <span class="text">Início</span>
                </a>
            </li>
            <li>
                <a href="livros.php">
                    <i class="fas fa-book"></i>
                    <span class="text">Livros</span>
                </a>
            </li>
            <li>
                <a href="emprestimos.php">
                    <i class="fas fa-undo"></i>
                    <span class="text">Empréstimos</span>
                </a>
            </li>
            <li class="active">
                <a href="devolucao.php">
                    <i class="fas fa-arrow-left"></i>
                    <span class="text">Devoluções</span>
                </a>
            </li>
            <li>
                <a href="aluno.php">
                    <i class="fas fa-graduation-cap"></i>
                    <span class="text">Alunos</span>
                </a>
            </li>
            <li>
				<a href="prof.php">
					<i class="fas fa-clipboard-list"></i>
					<span class="text">Professores</span>
				</a>
			</li>
            <li>
                <a href="turma.php">
                    <i class="fas fa-users"></i>
                    <span class="text">Turma</span>
                </a>
            </li>
            <li>
                <a href="recomendacoes.php">
                    <i class="fas fa-download"></i>
                    <span class="text">Recomendações</span>
                </a>
            </li>
            <li>
                <a href="usuarios.php">
                    <i class="fas fa-cogs"></i>
                    <span class="text">Usuários</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu">
            <li>
                <a href="../Controller/CLogout.php" class="logout">
                    <i class="fas fa-sign-out-alt"></i>
                    <span class="text">Deslogar</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <i class='fas fa-bars'></i>
            <form action="#"></form>

            <div class="icons">
                <div id="menu-btn" class="fas fa-question" onclick="abrirPDFEmNovaAba()"></div>
            </div>

            <script>
                function abrirPDFEmNovaAba() {
                    var urlDoPDF = "../ArquivosExternos/Manual.pdf";
                    window.open(urlDoPDF, '_blank');
                }
            </script>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="profile">
                <?php
                require('../Controller/Utils.php');

                $conexao = new CConexao();
                $conn = $conexao->getConnection();

                ?>
            </a>
        </nav>
        </head>

        <body>
            <section class="tabela">

                <div class="row">
                    <form action="../Router/dev_rotas.php" method="post">
                        <h3>Busca de empréstimos</h3>
                        <select id="Turma_idTurma" name="Turma_idTurma" class="box select-dark-mode" required>
                            <option value="">Selecione uma turma</option>
                            <?php
                            // Preencha as opções de turma a partir do banco de dados.
                            $query = "SELECT IdTurma, AnodeInicio, AnoTurma, NomeTurma FROM turma";
                            $stmt = $conn->query($query);
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='" . $row['IdTurma'] . "'>" . $row['AnoTurma'] . 'º ' . $row['NomeTurma'] . "</option>";
                            }
                            ?>
                        </select>
                        <select id="aluno_idAluno" name="aluno_idAluno" class="box select-dark-mode">
                            <option value="">Selecione um aluno</option>
                            <!-- Opções de alunos serão preenchidas dinamicamente com JavaScript -->
                        </select>

                    </form>
                </div>
            </section>
            <main>
                <div class="table-data">
                    <div class="order">
                        <div class="head">
                            <h3>Devolução de livros</h3>
                            <input type="text" id="searchInput" class="searchInput" placeholder="Pesquisar...">
                            <button class="pdf-button" id="pdf-button" aria-label="botão pdf" onclick="abrirAluno()">
                                <i class="fas fa-file-pdf"></i></button>

                            <script>
                                function abrirAluno() {
                                    var urlDoPDF = "../pdf/devolucaoPdf.php";
                                    window.open(urlDoPDF, '_blank');
                                }
                            </script>

                        </div>
                        <table>

                        <?php
// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
    header("Location: ../View/login.php"); // Redirecionar para a página de login se não estiver logado
    exit();
}

// Inicialize a instância da classe de conexão.
$conexao = new CConexao();
$conn = $conexao->getConnection();

// Variáveis de paginação
$livrosPorPagina = 3;
$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
$inicio = ($paginaAtual - 1) * $livrosPorPagina;

// Consulta SQL para recuperar empréstimos de alunos e professores
$queryEmprestimos = "SELECT e.idEmprestimo, 
                            COALESCE(a.NomeAluno, p.Nomeprof) AS Leitor, 
                            COALESCE(a.idAluno, p.idprof) AS idLeitor,
                            COALESCE(ta.NomeTurma, tp.NomeTurma) AS Turma, 
                            l.NomeLivro AS Livro, 
                            e.StatusEmprestimo AS Estado,
                            d.DataDevolucao
                    FROM emprestimo e
                    LEFT JOIN aluno a ON e.aluno_idAluno = a.idAluno
                    LEFT JOIN prof p ON e.prof_idprof = p.idprof
                    LEFT JOIN livro l ON e.livro_idLivro = l.idLivro
                    LEFT JOIN turma ta ON Turma_idTurma = ta.IdTurma
                    LEFT JOIN turma tp ON Turma_idTurma = tp.IdTurma
                    LEFT JOIN devolucao d ON e.idEmprestimo = d.emprestimo_idEmprestimo
                    ORDER BY e.idEmprestimo
                    LIMIT $inicio, $livrosPorPagina";

// Executar a consulta para obter os empréstimos dos alunos e professores
$result = $conn->query($queryEmprestimos);

if ($result->rowCount() > 0) {
    echo '<table>';
    echo '<thead>';
    echo '<tr>';
    echo '<th><center>ID</center></th>';
    echo '<th><center>Leitor</center></th>';
    echo '<th><center>Turma</center></th>';
    echo '<th><center>Livro</center></th>';
    echo '<th><center>Data de Devolução</center></th>';
    echo '<th><center>Estado</center></th>';
    echo '<th><center>Ações</center></th>';
    echo '</tr>';
    echo '</thead>';
    echo '<tbody>';

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $estado = "";
        $classeCSS = "";

        // Lógica para definir o estado e a classe CSS
        switch ($row['Estado']) {
            case 0:
                $estado = "A prazo";
                $classeCSS = "status process";
                break;
            case 1:
                $estado = "Pendente";
                $classeCSS = "status pending";
                break;
            case 2:
                $estado = "Devolvido";
                $classeCSS = "status completed";
                break;
            case 4:
                $estado = "Devolvido com pendência";
                $classeCSS = "status process";
                break;
            default:
                $estado = "Estado desconhecido";
                $classeCSS = "status unknown";
                break;
        }

        echo '<tr>';
echo '<td><center>' . $row['idLeitor'] . '</center></td>';
echo '<td><center>' . $row['Leitor'] . '</center></td>';

// Verifica se o campo de Turma está vazio e se o campo Nomeprof não está vazio para exibir o nome do professor
if (empty($row['Turma']) && !empty($row['Nomeprof'])) {
    echo '<td><center>' . $row['Nomeprof'] . '</center></td>';
} else {
    echo '<td><center>' . $row['Turma'] . '</center></td>';
}

echo '<td><center>' . $row['Livro'] . '</center></td>';
echo '<td><center>' . $row['DataDevolucao'] . '</center></td>';
echo '<td><center><span class="' . $classeCSS . '">' . $estado . '</span></center></td>';
echo '<td>';

// Lógica para exibir ações com base no estado
if ($row['Estado'] == 2 || $row['Estado'] == 4) {
    echo '<div class="container">';
    echo '<center>-</center>';
    echo '</div>';
} else {
    echo '<div class="container">';
    echo '<center><button class="historico-button" type="submit" onclick="handlePopup(true)"><i class="fas fa-check"></i></button></center>';
    echo '<div class="popup" id="popup">';
    echo '<img src="../img/livro2.png">';
    echo '<h2 class="title"></h2>';
    echo '<p class="desc">O livro foi realmente devolvido?</p>';
    echo '<button class="close-popup-button" type="submit" onclick="handlePopup(false)">Fechar</button>';
    echo '<a href="../Controller/CDevolver_livro.php?id=' . $row['idEmprestimo'] . '"><button class="close-popup-button">Devolver</button></a>';
    echo '</div>';
    echo '</div>';
}

echo '</td>';
echo '</tr>';


        
    }

    echo '</tbody>';
    echo '</table>';

    // Consulta SQL para contar o número total de registros
    $queryCount = "SELECT COUNT(*) AS total FROM emprestimo e
                   LEFT JOIN aluno a ON e.aluno_idAluno = a.idAluno
                   LEFT JOIN prof p ON e.prof_idprof = p.idprof
                   LEFT JOIN livro l ON e.livro_idLivro = l.idLivro
                   LEFT JOIN turma ta ON Turma_idTurma = ta.IdTurma
                   LEFT JOIN turma tp ON Turma_idTurma = tp.IdTurma
                   LEFT JOIN devolucao d ON e.idEmprestimo = d.emprestimo_idEmprestimo";

    // Executar a consulta para contar o total de registros
    $resultCount = $conn->query($queryCount);
    $totalRegistros = $resultCount->fetch(PDO::FETCH_ASSOC)['total'];

    // Calcular o número total de páginas
    $totalPaginas = ceil($totalRegistros / $livrosPorPagina);

    // Exibir os links de paginação
    echo "<div class='pagination'>";
    for ($i = 1; $i <= $totalPaginas; $i++) {
        $classeAtiva = ($i == $paginaAtual) ? "active" : "";
        echo "<a class='page-link $classeAtiva' href='seu_script.php?pagina=$i'>$i</a>";
    }
    echo "</div>";
} else {
    echo "<p><center>Nenhum empréstimo encontrado.</center></p>";
}
?>





                        </table>
                    </div>

                </div>

                <footer class="footer">
                    © Copyright 2023 por <span>EducaBiblio</span> | Todos os direitos reservados
                </footer>
            </main>
    </section>
</body>

</html>

<script src="../JS/script.js"></script>
<script src="../JS/popup.js"></script>
<script scr="../ArquivosExternos/ajax.js"></script>
<script src="../ArquivosExternos/jquery.js"></script>

<script>
    $('#aluno_idAluno').on('change', function() {
        const selectedAlunoId = $(this).val().toLowerCase();

        $('table tbody tr').filter(function() {
            const alunoId = $(this).find('td:nth-child(3)').text().trim().toLowerCase(); // Supondo que o ID do aluno esteja na terceira coluna

            if (selectedAlunoId !== '' && alunoId !== selectedAlunoId) {
                $(this).hide(); // Esconde as linhas que não correspondem ao aluno selecionado
            } else {
                $(this).show(); // Exibe as linhas que correspondem ao aluno selecionado ou mostra todas se nenhum estiver selecionado
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $("#Turma_idTurma").change(function() {
            var turmaId = $(this).val();
            var alunoSelect = $("#aluno_idAluno");

            if (turmaId) {
                $.ajax({
                    type: "GET",
                    url: "../Controller/CBusca_alunos.php",
                    data: {
                        turmaId: turmaId
                    },
                    success: function(data) {
                        alunoSelect.html(data);
                    },
                    error: function() {
                        alunoSelect.html("<option value=''>Erro ao carregar alunos</option>");
                    }
                });
            } else {
                alunoSelect.html("<option value=''>Selecione um aluno</option>");
            }
        });

        $(".search-button").click(function(e) {
            e.preventDefault();
            var alunoId = $("#aluno_idAluno").val();

            if (alunoId !== "") {
                $.ajax({
                    url: '../Controller/CDev_tabela.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        aluno_idAluno: alunoId
                    },
                    success: function(response) {
                        $('#tabela-dados tbody').empty();

                        $.each(response, function(index, row) {
                            var newRow = '<tr>' +
                                '<td><center>' + row.Leitor + '</center></td>' +
                                '<td><center>' + row.Turma + '</center></td>' +
                                '<td><center>' + row.Livro + '</center></td>' +
                                '<td><center><span class="status pending">' + row.Estado + '</span></center></td>' +
                                '<td>' +
                                '<div class="container">' +
                                '<center>' +
                                '<button class="historico-button" type="submit" onclick="handlePopup(true)">' +
                                '<i class="fas fa-check"></i>' +
                                '</button>' +
                                '</center>' +
                                '<div class="popup" id="popup">' +
                                '<img src="../img/livro2.png">' +
                                '<h2 class="title">Devolução</h2>' +
                                '<p class="desc">O livro foi realmente devolvido?</p>' +
                                '<button class="close-popup-button" type="submit" onclick="handlePopup(false)">' +
                                'ㅤ Fechar ㅤ' +
                                '</button>' +
                                '<button class="close-popup-button">' +
                                'Devolver' +
                                '</button>' +
                                '</div>' +
                                '</div>' +
                                '</td>' +
                                '</tr>';

                            $('#tabela-dados tbody').append(newRow);
                        });
                    },
                    error: function() {
                        alert('Erro ao buscar dados do servidor.');
                    }
                });
            }
        });
    });
</script>

<script>
    $('#searchInput').on('keyup', function() {
        const value = $(this).val().toLowerCase();

        $('table tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
</script>


</body>

</html>