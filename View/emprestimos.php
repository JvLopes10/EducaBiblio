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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">


	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<script src="https://kit.fontawesome.com/a81368914c.js"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
							<?php
							// Preencha as opções de gênero a partir do banco de dados.
							$query = "SELECT idGenero, NomeGenero FROM genero";
							$stmt = $conn->query($query);
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['idGenero'] . "'>" . $row['NomeGenero'] . "</option>";
							}
							?>
						</select>
						<select id="livro_idLivro" name="livro_idLivro" class="box select-dark-mode">
							<option value="">Selecione um livro</option>
							<!-- Opções de livros serão preenchidas dinamicamente com JavaScript -->
						</select>
						<select id="Turma_idTurma" name="Turma_idTurma" class="box select-dark-mode" required>
							<option value="">Selecione uma turma</option>
							<?php
							// Preencha as opções de turma a partir do banco de dados.
							$query = "SELECT AnodeInicio, AnoTurma, NomeTurma FROM turma";
							$stmt = $conn->query($query);
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['AnodeInicio'] . "'>" . $row['AnoTurma'] . 'º ' . $row['NomeTurma'] . "</option>";
							}
							?>
						</select>
						<select id="aluno_idAluno" name="aluno_idAluno" class="box select-dark-mode">
							<option value="">Selecione um aluno</option>
							<!-- Opções de alunos serão preenchidas dinamicamente com JavaScript -->
						</select>
						<input type="date" placeholder="Data" name="DataEmprestimo" id="DataEmprestimo" required class="box" autocomplete="off" required>
						<input type="date" placeholder="Data" name="data" required class="box" autocomplete="off" required>
						<input type="text" placeholder="Quantidade" name="quantidade" required class="box" autocomplete="off" required>
						<select id="usuario_idUsuario" name="usuario_idUsuario" class="box select-dark-mode" required>
							<option value="">Selecione um usuário</option>
							<?php
							// Preencha as opções de usuário a partir do banco de dados.
							$query = "SELECT idUsuario, UserUsuario FROM usuario";
							$stmt = $conn->query($query);
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
								echo "<option value='" . $row['idUsuario'] . "'>" . $row['UserUsuario'] . "</option>";
							}
							?>
						</select>
						<center> <input type="submit" value="Enviar" class="inline-btn" name="emprestar"> </center>
					</form>




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
<script>
	$(document).ready(function() {
		// Evento para quando o usuário seleciona um gênero

		$("#Genero_idGenero").change(function() {
			var generoId = $(this).val();
			if (generoId) {
				$.ajax({
					type: "GET",
					url: "../Controller/CBuscar_livros.php", // Atualize o caminho para o arquivo PHP correto
					data: {
						generoId: generoId
					},
					success: function(data) {
						$("#livro_idLivro").html(data);
					}
				});
			} else {
				$("#livro_idLivro").html("<option value=''>Selecione um livro</option>");
			}
		});

		// Evento para quando o usuário seleciona uma turma
		$("#Turma_idTurma").change(function() {
			var turmaId = $(this).val();
			if (turmaId) {
				$.ajax({
					type: "GET",
					url: "../Controller/CBusca_alunos.php", // Atualize o caminho para o arquivo PHP correto
					data: {
						turmaId: turmaId
					},
					success: function(data) {
						$("#aluno_idAluno").html(data);
					}
				});
			} else {
				$("#aluno_idAluno").html("<option value=''>Selecione um aluno</option>");
			}
		});
	});
</script>



</body>

</html>