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
				<a href="index.php" class="logout">
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
						<input type="text" placeholder="ID" name="id" required maxlength="50" class="box2" autocomplete="off" readonly>
						<input type="text" placeholder="Série" name="AnoTurma" id="AnoTurma" required maxlength="50" class="box" autocomplete="off" required>
						<input type="text" placeholder="Turma" name="NomeTurma" id="NomeTurma" required maxlength="50" class="box" autocomplete="off">

						<center><input type="submit" value="Enviar" class="inline-btn" name="action"></center>
					</form>
				</div>
			</section>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de turmas</h3>
							<button class="pdf-button">
								<i class="fas fa-file-pdf"></i></button>

						</div>
						<table>
							<thead>
								<tr>
									<th>
										<center>ID</center>
									</th>
									<th>
										<center>Série</center>
									</th>
									<th>
										<center>Turma</center>
									</th>
									<th>
										<center>Ano</center>
									</th>
									<th>
										<center>Editar</center>
									</th>
									<th>
										<center>Excluir</center>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<center>1</center>
									</td>
									<td>
										<center>3º</center>
									</td>
									<td>
										<center>Informática</center>
									</td>
									<td>
										<center>2021</center>
									</td>
									<td>
										<center><button class="edit-button">
												<i class="fas fa-pencil-alt"></i>
											</button></center>
									</td>
									<td>
										<div class="container">
											<center><button class="delete-button" type="submit" onclick="handlePopup(true)">
													<i class="fas fa-trash-alt"></i>
												</button></center>

											<div class="popup" id="popup">
												<img src="../img/decisao.png">

												<h2 class="title">Aviso!</h2>

												<p class="desc">Deseja mesmo excluir?</p>

												<button class="close-popup-button" type="submit" onclick="handlePopup(false)">
													Fechar
												</button>
												<button class="close-popup-button">
													Excluir
												</button>
											</div>
										</div>
					</div>
					</td>
					<style>
						.popup {
							right: 210% !important;
						}
					</style>
					</tr>
					<tr>
						<td>
							<center>2</center>
						</td>
						<td>
							<center>3º</center>
						</td>
						<td>
							<center>Desenho da Construção Civil</center>
						</td>
						<td>
							<center>2021</center>
						</td>
						<td>
							<center><button class="edit-button">
									<i class="fas fa-pencil-alt"></i>
								</button></center>
						</td>
						<td>
							<center><button class="delete-button" type="submit" onclick="handlePopup(true)">
									<i class="fas fa-trash-alt"></i>
								</button></center>
							<div class="popup" id="popup">
								<img src="../img/decisao.png">

								<h2 class="title">Aviso!</h2>

								<p class="desc">Deseja mesmo excluir?</p>

								<button class="close-popup-button" type="submit" onclick="handlePopup(false)">
									Fechar
								</button>
								<button class="close-popup-button">
									Excluir
								</button>
							</div>
				</div>
				</div>
				</td>
				</tr>
				<tr>
					<td>
						<center>3</center>
					</td>
					<td>
						<center>3º</center>
					</td>
					<td>
						<center>Administração</center>
					</td>
					<td>
						<center>2021</center>
					</td>
					<td>
						<center><button class="edit-button">
								<i class="fas fa-pencil-alt"></i>
							</button></center>
					</td>
					<td>
						<center><button class="delete-button" type="submit" onclick="handlePopup(true)">
								<i class="fas fa-trash-alt"></i>
							</button></center>
						<div class="popup" id="popup">
							<img src="../img/decisao.png">

							<h2 class="title">Aviso!</h2>

							<p class="desc">Deseja mesmo excluir?</p>

							<button class="close-popup-button" type="submit" onclick="handlePopup(false)">
								Fechar
							</button>
							<button class="close-popup-button">
								Excluir
							</button>
						</div>
						</div>

						</div>
					</td>
				</tr>
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
</body>

</html>