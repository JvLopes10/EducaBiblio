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
			<li class="active">
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

		</head>

		<body>

			<section class="tabela">

				<div class="row">
					<form action="../router/livro_rotas.php" method="post" enctype="multipart/form-data">
						<h3>Cadastro de livros</h3>
						<input type="text" placeholder="ID" name="id" required maxlength="50" class="box2" autocomplete="off" readonly>
						<style>

						</style>
						<input type="text" placeholder="Nome" name="NomeLivro" id="NomeLivro" required maxlength="50" class="box" autocomplete="off" required>
						<input type="text" placeholder="Autor" name="NomeAltor" id="NomeAltor" maxlength="50" class="box" autocomplete="off" required>
						<input type="text" placeholder="Edição" name="EdicaoLivro" id="EdicaoLivro" maxlength="50" class="box" autocomplete="off">
						<input type="text" placeholder="Editora" name="EditoraLivro" id="EditoraLivro" maxlength="50" class="box" autocomplete="off">
						<input type="text" placeholder="ISBN" name="IBSMLivro" id="IBSMLivro" maxlength="50" class="box" autocomplete="off">

						<select name="NomeGenero" id="NomeGenero" class="box select-dark-mode" required>
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
						<select name="Idioma_idIdioma" id="Idioma_idIdioma" class="box select-dark-mode">
							<option value="1">Português</option>
							<option value="2">Inglês</option>
							<option value="3">Espanhol</option>
						</select>

						<select name="DidaticoGenero" id="DidaticoGenero" class="box select-dark-mode">
							<option value="Sim">Material didático</option>
							<option value="Não">Material não didático</option>
						</select>

						<input type="file" name="FotoLivro" id="FotoLivro" class="box">
						<input type="text" placeholder="Localização" name="LocalLivro" id="LocalLivro" class="box" autocomplete="off">


						<center><input type="submit" value="Cadastrar" class="inline-btn" name="action"></center>
					</form>
				</div>
			</section>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de livros</h3>
							<button class="pdf-button">
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
										<center>Autor</center>
									</th>
									<th>
										<center>Edição</center>
									</th>
									<th>
										<center>Editora</center>
									</th>
									<th>
										<center>ISBN</center>
									</th>
									<th>
										<center>Gênero</center>
									</th>
									<th>
										<center>Idioma_idIdioma</center>
									</th>
									<th>
										<center>Imagem</center>
									</th>
									<th>
										<center>Localização</center>
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
										<center>Dom Quixote</center>
									</td>
									<td>
										<center>1</center>
									</td>
									<td>
										<center>Miguel de Cervantes</center>
									</td>
									<td>
										<center>1º</center>
									</td>
									<td>
										<center>Editora LBN</center>
									</td>
									<td>
										<center>978-85-7605-563-1</center>
									</td>
									<td>
										<center>Romance</center>
									</td>
									<td>
										<center>Português</center>
									</td>
									<td>
										<center><a href="#" class="profile">
												<img src="../img/domQuixote.jfif">
											</a></center>
									</td>
									<td>
										<center><button class="historico-button">
												<i class="fas fa-map-marker-alt"></i>
											</button></center>

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