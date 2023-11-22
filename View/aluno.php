<?php
include('../Controller/CConexao.php');

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta name="description" content="Página de cadastro de leitores">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../ArquivosExternos/icons.js"></script>
	<link rel="shortcut icon" href="../img/icon.png" type="image/x-icon" alt="icon do site"/>
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
			<li class="active">
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

			<script>function abrirPDFEmNovaAba() {
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

			<section class="tabela">:
				<div class="row">
				<form action="../Router/alunos_rotas.php" method="post">
						<h3>Cadastro de leitores</h3>
						<input type="text" placeholder="ID" name="id" maxlength="50" class="box2" autocomplete="off" readonly>

						<input type="text" placeholder="Nome" name="NomeAluno" id="NomeAluno" maxlength="50" class="box" autocomplete="off">
						<input type="email" placeholder="E-mail" name="EmailAluno" id="EmailAluno" maxlength="50" class="box" autocomplete="off">

						<input type="text" placeholder="Nome" name="NomeProf" id="NomeProf" maxlength="50" class="box" autocomplete="off">

						<input type="email" placeholder="E-mail" name="EmailProf" id="EmailProf" maxlength="50" class="box" autocomplete="off">


						<select id="escolha" name="escolha" class="box select-dark-mode">
							<option value="Aluno">Estudante</option>
							<option value="Professor">Professor</option>
						</select>
						<select id="Turma_idTurma" name="Turma_idTurma" class="box select-dark-mode">
							<option value="0">Turma</option>

							<?php

							include('../Controller/CGet_turma.php');
							$turma = getTurmasFromDB(); // Chama a função para obter as turmas do banco

							foreach ($turma as $idTurma => $nomeTurma) {
								echo "<option value=\"$idTurma\">$nomeTurma</option>";
							}


							?>

						</select>

						<input type="text" placeholder="Materia" name="MateriaProf" id="MateriaProf" maxlength="50" class="box" autocomplete="off">

						<center><input type="submit" value="Enviar" class="inline-btn" name="action"></center>
					</form>
				</div>
			</section>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de leitores</h3>
							<button class="pdf-button" id="pdf-button" aria-label="botão pdf">
								<i class="fas fa-file-pdf"></i></button>

						</div>
						<table>
							<thead>
								<tr>
									<th>
										<center>Nome</center>
									</th>
									<th>
										<center>ID</center>
									</th>
									<th>
										<center>E-mail</center>
									</th>
									<th>
										<center>Tipo</center>
									</th>
									<th>
										<center>Turma</center>
									</th>
									<th>
										<center>Editar</center>
									</th>
									<th>
										<center>Excluir</center>
									</th>
									<th>
										<center>Histórico</center>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<center>Maria Raquel</center>
									</td>
									<td>
										<center>1</center>
									</td>
									<td>
										<center>maria.raquel@aluno.ce.gov.br</center>
									</td>
									<td>
										<center>Estudante</center>
									</td>
									<td>
										<center>3º DCC</center>
									</td>
									<td>
										<center><button class="edit-button" id="edit-button" aria-label="botão editar">
												<i class="fas fa-pencil-alt"></i>
											</button></center>
									</td>
									<td>
										<div class="container">
											<center><button class="delete-button" type="submit"
													onclick="handlePopup(true)">
													<i class="fas fa-trash-alt"></i>
												</button></center>
											<div class="popup" id="popup">
												<img src="../img/decisao.png" alt ="Imagem com ponto de interrogação indicando dous caminhos a serem seguidos">

												<h2 class="title">Aviso!</h2>

												<p class="desc">Deseja mesmo excluir?</p>

												<button class="close-popup-button" type="submit" onclick="handlePopup(false)" aria-label="botão fechar">
													Fechar
												</button>
												<button class="close-popup-button" aria-label="botão excluir">
													Excluir
												</button>
											</div>
										</div>
					</div>
					</td>
					<td>
						<center><button class="historico-button" aria-label="botão histórica">
								<i class="fas fa-history"></i>
							</button></center>
					</td>
					</tr>
					<tr>
						<td>
							<center>Paulo Jefferson</center>
						</td>
						<td>
							<center>2</center>
						</td>
						<td>
							<center>paulo.jefferson@aluno.ce.gov.br</center>
						</td>
						<td>
							<center>Estudante</center>
						</td>
						<td>
							<center>3º INF</center>
						</td>
						<td>
							<center><button class="edit-button" aria-label="botão editar">
									<i class="fas fa-pencil-alt"></i>
								</button></center>
						</td>
						<td>
							<div class="container"></div>
							<center><button class="delete-button" type="submit" onclick="handlePopup(true)" aria-label="botão excluir">
									<i class="fas fa-trash-alt"></i>
								</button></center>
							<div class="popup" id="popup">
								<img src="../img/decisao.png" alt ="Imagem com ponto de interrogação indicando dous caminhos a serem seguidos">

								<h2 class="title">Aviso!</h2>

								<p class="desc">Deseja mesmo excluir?</p>

								<button class="close-popup-button" type="submit" onclick="handlePopup(false)" aria-label="botão fechar">
									Fechar
								</button>
								<button class="close-popup-button" aria-label="botão excluir">
									Excluir
								</button>
							</div>
				</div>
				</div>
				</td>
				<td>
					<center><button class="historico-button" aria-label="botão histórico">
							<i class="fas fa-history"></i>
						</button></center>
				</td>
				</tr>
				<tr>
					<td>
						<center>Maria Isabel</center>
					</td>
					<td>
						<center>3</center>
					</td>
					<td>
						<center>maria.isabel@aluno.ce.gov.br</center>
					</td>
					<td>
						<center>Estudante</center>
					</td>
					<td>
						<center>3º INF</center>
					</td>
					<td>
						<center><button class="edit-button" aria-label="botão editar">
								<i class="fas fa-pencil-alt"></i>
							</button></center>
					</td>
					<td>
						<div class="container">
							<center><button class="delete-button" type="submit" onclick="handlePopup(true)" aria-label="botão excluir">
									<i class="fas fa-trash-alt"></i>
								</button></center>
					</td>
					<td>
						<center><button class="historico-button" aria-label="botão histórico">
								<i class="fas fa-history"></i>
							</button></center>
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