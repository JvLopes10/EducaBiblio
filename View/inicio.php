<?php
include('../Controller/CConexao.php');
session_start();

// Inclua a classe GetLivro
require '../Controller/CGet_rec.php';

$conexao = new CConexao();
$conn = $conexao->getConnection();

// Use a classe GetLivro para obter os livros
$getlivro = new GetLivro($conn);

// Use a função obterLivrosRecomendados para obter os livros recomendados
$livrosRecomendados = $getlivro->obterLivrosRecomendados();
?>

?>
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

	<section id="sidebar" class="page-transition">
		<a href="#" class="brand">
			<i class="fas fa-book"></i>
			<span class="text">EducaBiblio</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
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
				<a href="login.php" class="logout">
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
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Olá, <b><?php
								if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
									$nomeDoUsuario = $_SESSION['nomeDoUsuario'];
									echo $nomeDoUsuario; // Exibe o nome do usuário
								} else {
									// Usuário não está logado, redireciona ou exibe uma mensagem de erro
								}
								?> 👋</b>!</h1>

					<style type="text/css">
						b {
							color: #32CD32;
						}
					</style>
					<p>Seja bem-vindo ao EducaBiblio!</p>
				</div>
			</div>

			<ul class="box-info">
				<li>
					<i class="fas fa-graduation-cap"></i>
					<span class="text">
						<h3><?php

							try {
								// Consulta SQL para contar o número de alunos
								$sql = "SELECT COUNT(*) as total FROM aluno";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								if ($result) {
									$totalAlunos = $result['total'];
								} else {
									$totalAlunos = 0;
								}

								echo $totalAlunos;
							} catch (PDOException $e) {
								// Erro na conexão ou consulta SQL
								echo "Erro: " . $e->getMessage();
							}

							?></h3>
						<p>Alunos cadastrados</p>
					</span>
				</li>
				<li>
					<i class="fas fa-address-book"></i>
					<span class="text">
						<h3><?php

							try {
								// Consulta SQL para contar o número de alunos
								$sql = "SELECT COUNT(*) as total FROM empestimo";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								if ($result) {
									$totalAlunos = $result['total'];
								} else {
									$totalAlunos = 0;
								}

								echo $totalAlunos;
							} catch (PDOException $e) {
								// Erro na conexão ou consulta SQL
								echo "Erro: " . $e->getMessage();
							}

							?></h3>
						<p>Empréstimos</p>
					</span>
				</li>
				<li>
					<i class="fas fa-users"></i>
					<span class="text">
						<h3><?php

							try {
								// Consulta SQL para contar o número de alunos
								$sql = "SELECT COUNT(*) as total FROM devolucao";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								if ($result) {
									$totalAlunos = $result['total'];
								} else {
									$totalAlunos = 0;
								}

								echo $totalAlunos;
							} catch (PDOException $e) {
								// Erro na conexão ou consulta SQL
								echo "Erro: " . $e->getMessage();
							}

							?></h3>
						<p>Pendências</p>
					</span>
				</li>
			</ul>


			<section class="container-livros">
				<h1 class="heading">Recomendações Semanais</h1>
				<div class="container-card">
					<ul>
						<?php
						// Loop para exibir as recomendações da tabela 'recomendacao'
						foreach ($livrosRecomendados as $livroRecomendado) {
							echo '<div class="card">
                        				<li>
                            				<a href="' . $livroRecomendado["CamRec"] . '">
													<img src="' . $livroRecomendado["CamRec"] . '" alt="">
												<div class="card-content">
													<div class="nome">
														<section class="container-livros">
																<h3 class="heading">' . $livroRecomendado["LivroRec"] . '</h3>
																<p><b>Autor: </b>' . $livroRecomendado["AutorRec"] . '</p>
																<p><b>Categoria: </b>' . $livroRecomendado["CatRec"] . '</p>
														</section>
													</div>
												</div>
											</a>
										</li>
                  				  </div>';
						}
						?>
					</ul>
				</div>
			</section>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Histórico de empréstimos</h3>
						<button class="pdf-button">
							<i class="fas fa-file-pdf"></i></button>
					</div>
					<table>
						<thead>
							<tr>
								<th>
									<center>Estudante</center>
								</th>
								<th>
									<center>ID</center>
								</th>
								<th>
									<center>Turma</center>
								</th>
								<th>
									<center>Data do empréstimo</center>
								</th>
								<th>
									<center>Data de devolução</center>
								</th>
								<th>
									<center>Data em que foi devolvido</center>
								</th>
								<th>
									<center>Estado</center>
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
									<center>3º</center>
								</td>
								<td>
									<center>29/07/2023</center>
								</td>
								<td>
									<center>23/08/2023</center>
								</td>
								<td>
									<center>22/08/2023</center>
								</td>
								<td>
									<center><span class="status completed">Devolvido</span></center>
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
									<center>3º</center>
								</td>
								<td>
									<center>29/07/2023</center>
								</td>
								<td>
									<center>23/08/2023</center>
								</td>
								<td>
									<center>-</center>
								</td>
								<td>
									<center><span class="status pending">Pendente</span></center>
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
									<center>3º</center>
								</td>
								<td>
									<center>23/08/2023</center>
								</td>
								<td>
									<center>15/10/2023</center>
								</td>
								<td>
									<center>-</center>
								</td>
								<td>
									<center><span class="status process">Dentro do prazo</span></center>
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

	<script src="../JS/script.js"></script>
</body>

</html>