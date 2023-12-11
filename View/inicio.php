<?php
include('../Controller/CConexao.php');
include('../Controller/CLog_usu.php');
require '../Controller/CGet_rec.php';
$conexao = new CConexao();
$conn = $conexao->getConnection();
$getlivro = new GetLivro($conn);
$livrosRecomendados = $getlivro->obterLivrosRecomendados();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../ArquivosExternos/icons.js"></script>
	<link rel="shortcut icon" href="../img/icon1.png" type="image/x-icon">
	<link rel="stylesheet" href="../CSS/style.css">
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
				// Inicializa a variável do caminho da imagem do usuário
				$caminhoImagemUsuario = isset($_SESSION['caminhoImagemUsuario']) ? $_SESSION['caminhoImagemUsuario'] : '';

				if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true && !empty($caminhoImagemUsuario)) {
					// Se o usuário está logado e o caminho da imagem do usuário não está vazio, exibe a imagem do usuário
					echo '<img src="' . $caminhoImagemUsuario . '" alt="Imagem do usuário">';
				} else {
					// Se o usuário não está logado ou o caminho da imagem do usuário está vazio, exibe a imagem padrão
					echo '<img src="../img/adm.png" alt="Imagem Padrão">';
				}
				?>

			</a>


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
								$sql = "SELECT COUNT(*) as total FROM emprestimo";
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
								$sql = "SELECT COUNT(*) as total FROM emprestimo WHERE StatusEmprestimo = 1";
								$stmt = $conn->prepare($sql);
								$stmt->execute();
								$result = $stmt->fetch(PDO::FETCH_ASSOC);

								if ($result) {
									$totalComPendencia = $result['total'];
								} else {
									$totalComPendencia = 0;
								}

								echo $totalComPendencia;
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
				<h1 class="heading">Recomendações <span>semanais</span> </h1>
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



				.searchInput {
					width: 20% !important;
					height: 30px;
					background-color: #f2f2f2;
					border: 1px solid #ccc;
					border-radius: 5px;
					padding: 5px;
				}
			</style>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Histórico de empréstimos</h3>
						<input type="text" id="searchInput" class="searchInput" placeholder="Pesquisar...">

						<button class="pdf-button">
							<i class="fas fa-file-pdf"></i></button>
					</div>
					<table><?php

							$conexao = new CConexao();
							$conn = $conexao->getConnection();

							// Definir o número de registros por página
							$registrosPorPagina = 4;

							// Determinar a página atual
							$paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;
							$indiceInicial = ($paginaAtual - 1) * $registrosPorPagina;

							// Consulta para obter os dados de empréstimo paginados
							$sql = "SELECT
            emprestimo.idEmprestimo,
            aluno.NomeAluno AS Estudante,
            DATE_FORMAT(emprestimo.DataEmprestimo, '%d/%m/%Y') AS DataEmprestimoFormatada,
            IFNULL(DATE_FORMAT(devolucao.DataDevolucao, '%d/%m/%Y'), '--/--/----') AS DataDevolucaoFormatada,
            IFNULL(DATE_FORMAT(devolucao.DataDevolvida, '%d/%m/%Y'), '--/--/----') AS DataDevolvidaFormatada,
            CASE
                WHEN emprestimo.StatusEmprestimo = 0 THEN 'Dentro do prazo'
                WHEN emprestimo.StatusEmprestimo = 1 THEN 'Pendente'
                WHEN emprestimo.StatusEmprestimo = 2 THEN 'Devolvido'
                ELSE 'Status não definido'
            END AS Estado
        FROM emprestimo
        LEFT JOIN aluno ON emprestimo.aluno_idAluno = aluno.idAluno
        LEFT JOIN devolucao ON emprestimo.idEmprestimo = devolucao.emprestimo_idEmprestimo
        LIMIT $indiceInicial, $registrosPorPagina";

							$result = $conn->query($sql);

							if ($result === false) {
								// Use errorInfo para obter informações sobre o erro
								$errorInfo = $conn->errorInfo();
								echo "Erro na consulta SQL: " . $errorInfo[2];
							} else {
								if ($result->rowCount() > 0) {
									$dadosEmprestimo = $result->fetchAll(PDO::FETCH_ASSOC);

									// Exibir a tabela de empréstimos
									echo "<table>";
									echo "<thead>";
									echo "<tr>";
									echo "<th><center>Estudante</center></th>";
									echo "<th><center>ID</center></th>";
									echo "<th><center>Data do Empréstimo</center></th>";
									echo "<th><center>Data de Devolução</center></th>";
									echo "<th><center>Data em que foi Devolvido</center></th>";
									echo "<th><center>Estado</center></th>";
									echo "</tr>";
									echo "</thead>";
									echo "<tbody>";

									foreach ($dadosEmprestimo as $emprestimo) {
										echo "<tr>";
										echo "<td><center>" . $emprestimo['Estudante'] . "</center></td>";
										echo "<td><center>" . $emprestimo['idEmprestimo'] . "</center></td>";
										echo "<td><center>" . $emprestimo['DataEmprestimoFormatada'] . "</center></td>";
										echo "<td><center>" . $emprestimo['DataDevolucaoFormatada'] . "</center></td>";
										echo "<td><center>" . $emprestimo['DataDevolvidaFormatada'] . "</center></td>";
										echo "<td><center><span class='status ";
										echo ($emprestimo['Estado'] === 'Dentro do prazo') ? 'process' : (($emprestimo['Estado'] === 'Pendente') ? 'pending' : 'completed');
										echo "'>" . $emprestimo['Estado'] . "</span></center></td>";
										echo "</tr>";
									}

									echo "</tbody>";
									echo "</table>";

									// Adiciona links de paginação
									$sqlTotal = "SELECT COUNT(*) AS total FROM emprestimo";
									$resultadoTotal = $conn->query($sqlTotal);
									$totalRegistros = $resultadoTotal->fetch(PDO::FETCH_ASSOC)['total'];
									$totalPaginas = ceil($totalRegistros / $registrosPorPagina);

									echo "<div class='pagination'>";
									for ($i = 1; $i <= $totalPaginas; $i++) {
										$classeAtiva = ($i == $paginaAtual) ? "active" : "";
										echo "<a class='page-link $classeAtiva' href='pagina.php?pagina=$i'>$i</a>";
									}
									echo "</div>";
								} else {
									echo "<p>Nenhum empréstimo encontrado.</p>";
								}
							}

							$conn = null; // Fecha a conexão
							?>

					</table>
				</div>

			</div>
			<footer class="footer">

				© Copyright 2023 por <span>EducaBiblio</span> | Todos os direitos reservados

			</footer>
		</main>
	</section>

	<script src="../JS/script.js"></script>

	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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