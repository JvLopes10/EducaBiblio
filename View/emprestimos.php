<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>

	<link rel="shortcut icon" href="../img/icon.png" type="image/x-icon" />
	<link rel="stylesheet" href="../CSS/style.css">


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
			<li class="active">
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
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Pesquisar">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>

			<div class="icons">
				<div id="menu-btn" class="fas fa-question" onclick="abrirPDFEmNovaAba()"></div>
			</div>

			<script>
				function abrirPDFEmNovaAba() {
					var urlDoPDF = "../img/Manual.pdf";
					window.open(urlDoPDF, '_blank');
				}
			</script>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="profile">
				<img src="../img/adm.png">
			</a>
		</nav>


		<style>

		</style>
		</head>

		<body>

			<section class="tabela">

				<div class="row">








					<form action="../Router/emp_rotas.php" method="post">
						<h3>Empréstimo de livros</h3>
						<input type="text" placeholder="ID" name="idEmpestimo" id="idEmpestimo" required maxlength="50" class="box2" autocomplete="off" readonly>
						<select id="Genero_idGenero" name="Genero_idGenero" class="box select-dark-mode" required>
							<option value="">Selecione um gênero</option>
							<option value="1">Autoajuda</option>
							<option value="2">Biografia</option>
							<option value="3">Clássico</option>
							<option value="4">Conto</option>
							<option value="5">Fantasia</option>
							<option value="6">Ficção científica</option>
							<option value="7">Poesia</option>
							<option value="8">Romance</option>
							<option value="9">Outro</option>
						</select>
						<select id="livro_idLivro" name="livro_idLivro" class="box select-dark-mode" required>
							<option value="">Selecione um livro</option>
							<!-- Opções de livros podem ser carregadas dinamicamente com JavaScript ou PHP -->
						</select>
						<select id="Turma_idTurma" name="Turma_idTurma" class="box select-dark-mode" required>
							<option>Turma</option>
							<option>#</option>
							<option>#</option>
						</select>

						<select id="aluno_idAluno" name="aluno_idAluno" class="box select-dark-mode" required>
							<option>Leitor</option>
							<option>#</option>
							<option>#</option>
							<option>#</option>
						</select>

						<input type="date" placeholder="Data" name="DataEmprestimo" id="DataEmprestimo" required class="box" autocomplete="off" required>

						<input type="date" placeholder="Data" name="data" required class="box" autocomplete="off" required>

						<input type="text" placeholder="Quantidade" name="quantidade" required class="box" autocomplete="off" required>

						<select id="usuario_idUsuario" name="usuario_idUsuario" class="box select-dark-mode" required>
							<option>Usuário</option>
							<option>#</option>
							<option>#</option>
							<option>#</option>
						</select>

						<center> <input type="submit" value="Enviar" class="inline-btn" name="emprestar"> </center>
					</form>
				</div>






			</section>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de empréstimos</h3>
							<button class="pdf-button">
								<i class="fas fa-file-pdf"></i></button>

						</div>
						<table>
							<thead>
								<tr>
									<th>
										<center>Livro</center>
									</th>
									<th>
										<center>Gênero</center>
									</th>
									<th>
										<center>ID</center>
									</th>
									<th>
										<center>Turma</center>
									</th>
									<th>
										<center>Leitor</center>
									</th>
									<th>
										<center>Data de empréstimo</center>
									</th>
									<th>
										<center>Data prevista para devolução</center>
									</th>
									<th>
										<center>Quantidade</center>
									</th>
									<th>
										<center>Usuário</center>
									</th>
									<th>
										<center>Editar</center>
									</th>
									<th>
										<center>Excluir</center>
									</th>
									<th>
										<center>E-mail</center>
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<center>It, a coisa</center>
									</td>
									<td>
										<center>Fantasia</center>
									</td>
									<td>
										<center>1</center>
									</td>

									<td>
										<center>3º DCC</center>
									</td>
									<td>
										<center>Maria Raquel</center>
									</td>
									<td>
										<center>18/09/2023</center>
									</td>
									<td>
										<center>20/09/2023</center>
									</td>
									<td>
										<center>1</center>
									</td>
									<td>
										<center>Bruno</center>
									</td>
									<td>
										<center><button class="edit-button">
												<i class="fas fa-pencil-alt"></i>
											</button></center>
									</td>
									<td>
										<center><button class="delete-button">
												<i class="fas fa-trash-alt"></i>
											</button></center>
									</td>
									<td>
										<center><button class="historico-button">
												<i class="fas fa-envelope"></i>
											</button></center>
									</td>
								</tr>
							</tbody>
						</table>
					</div>

				</div>

				<footer class="footer">

					Copyright @ 2023 por <span>EducaBiblio</span> | Todos os direitos reservados

				</footer>

			</main>
	</section>

</body>

</html>

<script src="../JS/script.js"></script>


</body>

</html>