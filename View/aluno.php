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

				<?php
		$conexao = new CConexao();
		$conn = $conexao->getConnection();

		// Consulta para obter os dados da tabela de usuários
		$sql = "SELECT 
            aluno.NomeAluno,
            aluno.idAluno,
            aluno.Turma_idTurma,
            aluno.EmailAluno,
            'aluno' AS tipo
        FROM aluno
        UNION
        SELECT
            prof.NomeProf AS NomeAluno,
            prof.idProf AS idAluno,
            NULL AS Turma_idTurma,
            prof.EmailProf AS EmailAluno,
            'prof' AS tipo
        FROM prof";


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
				echo "<th><center>Nome</center></th>";
				echo "<th><center>ID</center></th>";
				echo "<th><center>Email</center></th>";
				echo "<th><center>tipo</center></th>";
				echo "<th><center>turma</center></th>";
				echo "<th><center>Editar</center></th>";
				echo "<th><center>Excluir</center></th>";
				echo "<th><center>historico</center></th>";
				echo "</tr>";
				echo "</thead>";
				echo "<tbody>";

				foreach ($UsuarioExibidos as $row) {
					echo "<tr>";
					echo "<td><center>" . $row["NomeAluno"] . "</center></td>";
					echo "<td><center>" . $row["idAluno"] . "</center></td>";
					echo "<td><center>" . $row["EmailAluno"] . "</center></td>"; 
					echo "<td><center>" . ucfirst($row["tipo"]) . "</center></td>"; // Mostra se é aluno ou professor
					echo "<td><center>" . ($row["Turma_idTurma"] ? $row["Turma_idTurma"] : "Não se aplica") . "</center></td>";
				
					// Botão de edição
					echo "<td><center>";
					if (array_key_exists('idAluno', $row)) {
						echo "<button class='edit-button' data-id='" . $row["idAluno"] . "'><i class='fas fa-pencil-alt'></i></button>";
					}
					if (array_key_exists('idProf', $row)) {
						echo "<button class='edit-button' data-id='" . $row["idProf"] . "'><i class='fas fa-pencil-alt'></i></button>";
					}
					echo "</center></td>";
				
					// Botão de exclusão
					echo "<td><center>";
					if (array_key_exists('idAluno', $row)) {
						echo "<button class='delete-button' data-id='" . $row["idAluno"] . "' onclick='handleDelete(" . $row["idAluno"] . ")'><i class='fas fa-trash-alt'></i></button>";
					}
					if (array_key_exists('idProf', $row)) {
						echo "<button class='delete-button' data-id='" . $row["idProf"] . "' onclick='handleDelete(" . $row["idProf"] . ")'><i class='fas fa-trash-alt'></i></button>";
					}
					echo "</center></td>";
				
					// Botão de histórico
					echo "<td><center>";
					if (array_key_exists('idAluno', $row)) {
						echo "<button class='historico-button' data-id='" . $row["idAluno"] . "'><i class='fas fa-history'></i></button>";
					}
					if (array_key_exists('idProf', $row)) {
						echo "<button class='historico-button' data-id='" . $row["idProf"] . "'><i class='fas fa-history'></i></button>";
					}
					echo "</center></td>";
				
					echo "</tr>";
				}
				

				echo "</tbody>";
				echo "</table>";

				// Adiciona links de paginação
				echo "<div class='pagination'>";
				$totalUser = count($user);
				$totalPaginas = ceil($totalUser / $UsuarioPorPagina);
				for ($i = 1; $i <= $totalPaginas; $i++) {
					$classeAtiva = ($i === $paginaAtual) ? "active" : "";
					echo "<a class='page-link $classeAtiva' href='usuarios.php?pagina=$i'>$i</a>";
				}
				echo "</div>";

				// Botão Fechar do popup fora da tabela
				
			} else {
				echo "<p>Nenhum usuário encontrado.</p>";
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
</body>

</html>