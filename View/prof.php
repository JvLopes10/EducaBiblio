<?php
include('../Controller/CConexao.php');

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
	header("Location: ../View/login.php"); // Redirecionar para a página de login se não estiver logado
	exit();
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta name="description" content="Página de cadastro de leitores">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../ArquivosExternos/icons.js"></script>
	<link rel="shortcut icon" href="../img/icon1.png" type="image/x-icon">
	<link rel="stylesheet" href="../CSS/style.css">
	<link rel="stylesheet" href="../CSS/popup.css">
	<script src="../JS/alunos_prof.js"></script>
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
					<form action="../Router/prof_rotas.php" method="post">
						<h3>Cadastro de Professores</h3>
						<input type="text" placeholder="ID" name="idProf" id="idProf" maxlength="50" class="box3 autocomplete=" off" readonly>
						<input type="text" placeholder="Nome" name="NomeProf" id="NomeProf" maxlength="50" class="box" autocomplete="off">
						<input type="email" placeholder="E-mail" name="EmailProf" id="EmailProf" maxlength="50" class="box" autocomplete="off">
						<input type="text" placeholder="Materia" name="MateriaProf" id="MateriaProf" maxlength="50" class="box" autocomplete="off">
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
					-moz-appearance: textfield;
					/* Firefox */
				}
			</style>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de Professores</h3>
							<input type="text" id="searchInput" class="searchInput" placeholder="Pesquisar...">

							<button class="pdf-button" id="pdf-button" aria-label="botão pdf" onclick="abrirAluno2()">
								<i class="fas fa-file-pdf"></i></button>

						</div>
						<script>
							function abrirAluno2() {
								var urlDoPDF = "../pdf/alunoPdf.php";
								window.open(urlDoPDF, '_blank');
							}
						</script>
						<table>

							<?php

							// Aqui você já deve ter sua conexão com o banco de dados configurada

							// Consulta SQL para obter os dados dos professores
							$sql = "SELECT * FROM prof";
							$result = $conn->query($sql);

							if ($result === false) {
								// Use errorInfo para obter informações sobre o erro
								$errorInfo = $conn->errorInfo();
								echo "Erro na consulta SQL: " . $errorInfo[2];
							} else {
								if ($result->rowCount() > 0) {
									$professores = $result->fetchAll(PDO::FETCH_ASSOC);

									// Exibir a tabela com os dados dos professores
									echo "<table>";
									echo "<thead>";
									echo "<tr>";
									echo "<th><center>ID</center></th>";
									echo "<th><center>Nome</center></th>";
									echo "<th><center>Email</center></th>";
									echo "<th><center>Materia</center></th>";
									echo "<th><center>Editar</center></th>";
									echo "<th><center>Excluir</center></th>";
									echo "<th><center>Histórico</center></th>";
									echo "</tr>";
									echo "</thead>";
									echo "<tbody>";

        foreach ($professores as $row) {
            echo "<tr>";
            echo "<td><center>" . $row["idProf"] . "</center></td>";
            echo "<td><center>" . $row["NomeProf"] . "</center></td>";
            echo "<td><center>" . $row["EmailProf"] . "</center></td>";
            echo "<td><center>" . $row["MateriaProf"] . "</center></td>";
			echo "<td><center><button class='edit-button' data-id='" . $row["idProf"] . "'><i class='fas fa-pencil-alt'></i></button></center> 	</td>";
			echo "<td><center><div class='container'><center><button class='delete-button' type='button' onclick='handlePopup(true)' aria-label='botão excluir'><i class='fas fa-trash-alt'></i></button></center><div class='popup' id='popup'><img src='../img/decisao.png' aria-label='popup decisão'><h2 class='title'>Aviso!</h2><p class='desc'>Deseja mesmo excluir?</p><button class='close-popup-button' type='button' onclick='handlePopup(false)'>Fechar</button><a href='../Controller/CExcluir_prof.php?id={$row["idProf"]}'><button class='close-popup-button'>Excluir</button></a></div></div></div></center></td>";
			echo "<td><center><a href='../pdf/registrosProfPdf.php?idProf=" . $row["idProf"] . "' target='_blank'><button class='historico-button' data-id='" . $row["idProf"] . "'><i class='fas fa-history'></i></button></a></center></td>";

            echo "</tr>";
        }

									echo "</tbody>";
									echo "</table>";

        // Você pode adicionar recursos de paginação, se necessário
    } else {
        echo "<center>Não foram encontrados professores na base de dados.</center>";
    }
}

							// Lembre-se de fechar a conexão ao final
							$conn = null;
							?>



							</tbody>
						</table>
					</div>
				</div>
				<footer class="footer">
					© Copyright 2023 por <span>EducaBiblio</span> | Todos os direitos reservados
				</footer>
				<style>
					#button-link {
						color: inherit;
						/* Use a cor padrão do texto do pai */
						text-decoration: none;
						/* Remover sublinhado padrão */
					}
				</style>
			</main>
	</section>
</body>

</html>

<script src="../JS/script.js"></script>
<script src="../JS/popup.js"></script>
<script src="../ArquivosExternos/Ajax.js"></script>
<script>
	$(document).ready(function() {
		$('#turmaTable').DataTable(); // Inicializa o DataTables para a tabela de turma
	});
</script>

<script>
	$(document).ready(function() {
		// Capturar clique no botão de exclusão
		$('.delete-button').click(function() {
			// Obter o ID do item a ser excluído
			var id = $(this).closest('tr').find('td:eq(0)').text(); // Considerando que o ID está na segunda coluna

			// Mostrar o popup de confirmação
			handlePopup(true);

			// Preencher o link de exclusão com o ID correto
			var linkExclusao = '../Controller/CExcluir_prof.php?id=' + id;
			$('#popup a').attr('href', linkExclusao);
		});
	});
</script>

<script>
	$(document).ready(function() {
		// Capturar clique no botão de edição
		$('.edit-button').click(function() {
			// Obter o ID do item a ser editado
			var id = $(this).data('id');

			// Encontrar os dados correspondentes na tabela de usuários e preencher o formulário
			$('table tbody tr').each(function() {
				var rowId = $(this).find('td:eq(0)').text(); // Considerando que o ID está na segunda coluna
				if (rowId == id) {
					var nome = $(this).find('td:eq(1)').text();
					var email = $(this).find('td:eq(2)').text();
					var materia = $(this).find('td:eq(3)').text();

					// Preencher os campos do formulário com os dados obtidos
					$('#idProf').val(id);
					$('#NomeProf').val(nome);
					$('#EmailProf').val(email);
					$('#MateriaProf').val(materia);

					// Alterar o modo de ação para editar
					$('#modoAcao').val('editar');
					// Alterar o valor do botão para refletir a ação de edição
					$('input[type="submit"]').val('Editar');
					// Alterar a rota do formulário para a rota de atualização de usuários
					$('form').attr('action', '../Router/profedit_rotas.php'); // Alterar a action do formulário para a rota correta
					// Alterar o nome do botão para identificar a ação como atualização
					$('input[type="submit"]').attr('name', 'Editar');
				}
			});
		});
	});
</script>
<script>
	function abrirAluno() {
		var urlDoPDF = "../pdf/registrosAluPdf.php";
		window.open(urlDoPDF, '_blank');
	}
</script>





</body>

</html>