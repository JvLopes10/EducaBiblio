<?php
// Inclua o arquivo de conexão ao banco de dados.
include '../Controller/CConexao.php';

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
	<link rel="shortcut icon" href="../img/icon.png" type="image/x-icon" alt="icon do site" />
	<link rel="stylesheet" href="../CSS/style.css">
	<link rel="stylesheet" href="../CSS/popup3.css">
	<title>EducaBiblio</title>
</head>

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
				<img src="../img/adm.png" alt="imagem de perfil do administrador">
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
						<button class="search-button">
							<i class="fas fa-search"></i></button>
					</form>
				</div>
			</section>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Devolução de livros</h3>
							<input type="text" id="searchInput" class="searchInput" placeholder="Pesquisar...">
							<button class="pdf-button">
								<i class="fas fa-file-pdf"></i></button>

						</div>
						<table><?php
								// Verifica se a requisição é do tipo POST
								if ($_SERVER["REQUEST_METHOD"] == "POST") {
									// Verifica se o campo do aluno foi enviado pelo formulário
									if (isset($_POST['aluno_idAluno'])) {
										$aluno_id = $_POST['aluno_idAluno'];

										// Aqui você precisa construir a lógica de consulta ao banco de dados
										// Substitua este trecho de código pela consulta que retorna os dados desejados
										// Por exemplo:
										$query = "SELECT 
                    aluno.NomeAluno AS Leitor,
                    turma.NomeTurma AS Turma,
                    livro.NomeLivro AS Livro,
                    CASE
                        WHEN devolucao.StatusDevolucao IS NULL OR devolucao.StatusDevolucao = 2 THEN 'Pendente'
                        ELSE 'Devolvido'
                    END AS Estado
                FROM emprestimo
                INNER JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
                INNER JOIN turma ON aluno.Turma_idTurma = turma.IdTurma
                INNER JOIN livro ON emprestimo.livro_idLivro = livro.idLivro
                LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo
                WHERE aluno.idAluno = :aluno_id";

										$stmt = $conn->prepare($query);
										$stmt->bindParam(':aluno_id', $aluno_id);
										$stmt->execute();
										$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

										// Gera a tabela HTML com base nos resultados obtidos
										if (!empty($result)) {
											echo '<table>';
											echo '<thead>';
											echo '<tr>';
											echo '<th><center>Leitor</center></th>';
											echo '<th><center>Turma</center></th>';
											echo '<th><center>Livro</center></th>';
											echo '<th><center>Estado</center></th>';
											echo '<th><center>Devolvido</center></th>';
											echo '</tr>';
											echo '</thead>';
											echo '<tbody>';

											foreach ($result as $row) {
												echo '<tr>';
												echo '<td><center>' . $row['Leitor'] . '</center></td>';
												echo '<td><center>' . $row['Turma'] . '</center></td>';
												echo '<td><center>' . $row['Livro'] . '</center></td>';
												echo '<td><center><span class="status pending">' . $row['Estado'] . '</span></center></td>';
												echo '<td>';
												echo '<div class="container">';
												echo '<center>';
												echo '<button class="historico-button" type="submit" onclick="handlePopup(true)">';
												echo '<i class="fas fa-check"></i>';
												echo '</button>';
												echo '</center>';
												echo '<div class="popup" id="popup">';
												echo '<img src="../img/livro2.png">';
												echo '<h2 class="title">Devolução</h2>';
												echo '<p class="desc">O livro foi realmente devolvido?</p>';
												echo '<button class="close-popup-button" type="submit" onclick="handlePopup(false)">';
												echo 'ㅤ Fechar ㅤ';
												echo '</button>';
												echo '<button class="close-popup-button">';
												echo 'Devolver';
												echo '</button>';
												echo '</div>';
												echo '</div>';
												echo '</td>';
												echo '</tr>';
											}

											echo '</tbody>';
											echo '</table>';
										} else {
											echo 'Nenhum resultado encontrado.';
										}
									} else {
										echo 'ID do aluno não foi recebido.';
									}
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
<script src="../JS/popup.js"></script><script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
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
                // Limpar a lista de livros antes de adicionar os novos
                $('#lista-livros').empty();

                // Adicionar os livros à lista
                $.each(response, function(index, row) {
                    var livro = '<li>' + row.NomeLivro + '</li>';
                    $('#lista-livros').append(livro);
                });

                // Mostrar a lista de livros em algum elemento na sua página
                // Por exemplo, se você tem um <ul> com id "lista-livros":
                $('#lista-livros').show();
            },
            error: function() {
                alert('Erro ao buscar dados do servidor.');
            }
        });
    }
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

</body>

</html>