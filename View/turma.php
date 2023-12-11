<?php
include('../Controller/CConexao.php');

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../ArquivosExternos/icons.js"></script>
	<link rel="shortcut icon" href="../img/icon.png" type="image/x-icon" />
	<link rel="stylesheet" href="../CSS/style.css">
	<link rel="stylesheet" href="../CSS/popup.css">
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
			<li>
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
			<li class="active">
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
				<img src="../img/adm.png">
			</a>
		</nav>

		</head>

		<body>

			<section class="tabela">

				<div class="row">
					<form action="../Router/turma_rotas.php" method="post">
						<h3>Cadastro de Turmas</h3>
						<input type="number" placeholder="ID" name="IdTurma" id="IdTurma" required maxlength="50" class="box3" autocomplete="off" readonly>
						<input type="Number" placeholder="Ano de início" name="AnodeInicio" id="AnodeInicio" required maxlength="50" class="box" autocomplete="off">
						<input type="text" placeholder="Série" name="AnoTurma" id="AnoTurma" required maxlength="50" class="box" autocomplete="off" required>
						<input type="text" placeholder="Turma" name="NomeTurma" id="NomeTurma"  maxlength="50" class="box" autocomplete="off">

						<center><input type="submit" value="Enviar" class="inline-btn" name="action"></center>
					</form>
				</div>
			</section>
			<style>
				/* Esconde as setas para campos de entrada numérica */
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
input[type=number] {
  -moz-appearance: textfield; /* Firefox */
}


			
			.searchInput {
  width: 20% !important;
  height: 30px;
  background-color: #f2f2f2;
  border: 1px solid #ccc;
  border-radius: 5px;
  padding: 5px;
}
</style>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de turmas</h3>
							<input type="text" id="searchInput" class="searchInput" placeholder="Pesquisar...">
							<button class="pdf-button">
								<i class="fas fa-file-pdf"></i></button>

						</div>
						<table>
							<?php
							$conexao = new CConexao();
							$conn = $conexao->getConnection();

							// Consulta para obter os dados da tabela de usuários
							$sql = "SELECT
					turma.AnodeInicio,
					turma.AnoTurma,
					turma.NomeTurma,
					turma.IdTurma
				FROM turma";

							$result = $conn->query($sql);

							if ($result === false) {
								// Use errorInfo para obter informações sobre o erro
								$errorInfo = $conn->errorInfo();
								echo "Erro na consulta SQL: " . $errorInfo[2];
							} else {
								if ($result->rowCount() > 0) {
									$user = $result->fetchAll(PDO::FETCH_ASSOC);
									$UsuarioPorPagina = 4;
									$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
									$indiceInicial = ($paginaAtual - 1) * $UsuarioPorPagina;
									$UsuarioExibidos = array_slice($user, $indiceInicial, $UsuarioPorPagina);

									// Exibir a tabela de usuários
									echo "<table>";
									echo "<thead>";
									echo "<tr>";
									echo "<th class='sortable' data-column='id'><center>ID</center></th>";
									echo "<th class='sortable' data-column='serie'><center>Série</center></th>";
									echo "<th class='sortable' data-column='turma'><center>Turma</center></th>";
									echo "<th class='sortable' data-column='ano'><center>Ano</center></th>";
									echo "<th><center>Editar</center></th>";
									echo "<th><center>Excluir</center></th>";
									echo "</tr>";
									echo "</thead>";
									echo "<tbody>";

									foreach ($UsuarioExibidos as $row) {
										echo "<tr>";
										echo "<td><center>" . $row["IdTurma"] . "</center></td>";
										echo "<td><center>" . $row["AnoTurma"] . "</center></td>";
										echo "<td><center>" . $row["NomeTurma"] . "</center></td>";
										echo "<td><center>" . $row["AnodeInicio"] . "</center></td>";
										echo "<td><center><button class='edit-button' data-id='$row[IdTurma]'><i class='fas fa-pencil-alt'></i></button></center></td>";
										echo "<td><div class='container'><center><button class='delete-button' type='button' onclick='handlePopup(true)' aria-label='botão excluir'><i class='fas fa-trash-alt'></i></button></center><div class='popup' id='popup'><img src='../img/decisao.png' aria-label='popup decisão'><h2 class='title'>Aviso!</h2><p class='desc'>Deseja mesmo excluir?</p><button class='close-popup-button' type='button' onclick='handlePopup(false)'>Fechar</button><a href='../Controller/CExcluir_turma.php?id={$row["IdTurma"]}'><button class='close-popup-button'>Excluir</button></a></div></div></div></td>";echo "</tr>";
									}

									echo "</tbody>";
									echo "</table>";

									// Adiciona links de paginação
									echo "<div class='pagination'>";
									$totalUser = count($user);
									$totalPaginas = ceil($totalUser / $UsuarioPorPagina);
									for ($i = 1; $i <= $totalPaginas; $i++) {
										$classeAtiva = ($i === $paginaAtual) ? "active" : "";
										echo "<a class='page-link $classeAtiva' href='turma.php?pagina=$i'>$i</a>";
									}
									echo "</div>";

									// Botão Fechar do popup fora da tabela

								} else {
									echo "<p></p>";
								}
							}

							$conn = null; // Fecha a conexão
							?>
							</tbody>
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
<script>
	$(document).ready(function() {
		$('#turmaTable').DataTable(); // Inicializa o DataTables para a tabela de turma
	});
</script>
<script src="../ArquivosExternos/Jquery.js"></script>
<script>
	$(document).ready(function() {
		// Capturar clique no botão de edição
		$('.edit-button').click(function() {
			// Obter o ID da turma a ser editada
			var id = $(this).closest('tr').find('td:eq(0)').text(); // Considerando que o ID está na primeira coluna

			// Encontrar os dados correspondentes na tabela de turmas e preencher o formulário
			$('table tbody tr').each(function() {
				var rowId = $(this).find('td:eq(0)').text(); // Considerando que o ID está na primeira coluna
				if (rowId == id) {
					var anoInicio = $(this).find('td:eq(3)').text(); // Considerando que o Ano de início está na quarta coluna
					var anoTurma = $(this).find('td:eq(1)').text(); // Considerando que a Série está na segunda coluna
					var nomeTurma = $(this).find('td:eq(2)').text(); // Considerando que o Nome da turma está na terceira coluna

					// Preencher os campos do formulário com os dados obtidos
					$('#IdTurma').val(id);
					$('#AnodeInicio').val(anoInicio);
					$('#AnoTurma').val(anoTurma);
					$('#NomeTurma').val(nomeTurma);

					// Alterar o valor e o nome do botão de enviar para atualizar
					$('form').attr('action', '../Router/turmas2_rotas.php'); // Alterar o action do formulário
					$('input[type="submit"][name="action"]').val('Atualizar');
					$('input[type="submit"][name="action"]').attr('name', 'updateAction');
				}
			});
		});
	});
</script>
<script>
    $(document).ready(function() {
        $('.sortable').click(function() {
            const column = $(this).data('column');
            const order = $(this).hasClass('asc') ? 'desc' : 'asc';

            $('.sortable').removeClass('asc desc');
            $(this).addClass(order);

            sortTable(column, order);
        });
    });

    function sortTable(column, order) {
        const $tbody = $('table tbody');
        const $rows = $tbody.find('tr').get();

        $rows.sort(function(a, b) {
            const keyA = $(a).find(`td[data-column='${column}']`).text();
            const keyB = $(b).find(`td[data-column='${column}']`).text();

            if (order === 'asc') {
                return keyA.localeCompare(keyB);
            } else {
                return keyB.localeCompare(keyA);
            }
        });

        $.each($rows, function(index, row) {
            $tbody.append(row);
        });
    }
</script>

<script>
	$('#searchInput').on('keyup', function() {
		const value = $(this).val().toLowerCase();

		$('table tbody tr').filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
		});
	});
</script>
<script>
	$(document).ready(function() {
		// Capturar clique no botão de exclusão
		$('.delete-button').click(function() {
			// Obter o ID do item a ser excluído
			var id = $(this).closest('tr').find('td:eq(0)').text(); // Considerando que o ID está na primeira coluna

			// Mostrar o popup de confirmação
			handlePopup(true);

			// Preencher o link de exclusão com o ID correto
			var linkExclusao = '../Controller/CExcluir_turma.php?id=' + id;
			$('#popup a').attr('href', linkExclusao);
		});
	});
</script>
</body>

</html>