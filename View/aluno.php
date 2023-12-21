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
	<link rel="stylesheet" href="../CSS/darkPaginacao.css">
	<script src="../JS/alunos_prof.js"></script>
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
					<form action="../Router/alunos_rotas.php" method="post">
						<h3>Cadastro de leitores</h3>
						<input type="text" placeholder="ID" name="idAluno" id="idAluno" maxlength="50" class="box3" autocomplete="off" readonly>
						<input type="hidden" value="Aluno" id="escolha" name="escolha">
						<input type="text" placeholder="Nome" name="NomeAluno" id="NomeAluno" maxlength="50" class="box" autocomplete="off">
						<input type="email" placeholder="E-mail" name="EmailAluno" id="EmailAluno" maxlength="50" class="box" autocomplete="off">

						<select id="Turma_idTurma" name="Turma_idTurma" class="box select-dark-mode required">
							<option value="0">Turma</option>

							<?php

							include('../Controller/CGet_turma.php');
							$turma = getTurmasFromDB(); // Chama a função para obter as turmas do banco

							foreach ($turma as $idTurma => $nomeTurma) {
								echo "<option value=\"$idTurma\">$nomeTurma</option>";
							}


							?>

						</select>

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
							<h3>Tabela de leitores</h3>
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
// Inicializa a conexão com o banco de dados
$conexao = new CConexao();
$conn = $conexao->getConnection();

// Consulta para obter os dados dos alunos com o nome da turma
$sql = "SELECT 
        aluno.NomeAluno,
        aluno.idAluno,
        aluno.Turma_idTurma,
        aluno.EmailAluno,
        'aluno' AS tipo,
        turma.nomeTurma,
        turma.AnoTurma
    FROM aluno
    LEFT JOIN turma ON aluno.Turma_idTurma = turma.idTurma ";

$result = $conn->query($sql);

if ($result === false) {
    // Use errorInfo para obter informações sobre o erro
    $errorInfo = $conn->errorInfo();
    echo "Erro na consulta SQL: " . $errorInfo[2];
} else {
    if ($result->rowCount() > 0) {
        $user = $result->fetchAll(PDO::FETCH_ASSOC);
        $UsuarioPorPagina = 3;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $indiceInicial = ($paginaAtual - 1) * $UsuarioPorPagina;
        $UsuarioExibidos = array_slice($user, $indiceInicial, $UsuarioPorPagina);

        // Exibir a tabela de alunos com o nome da turma
        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th><center>Nome</center></th>";
        echo "<th><center>ID</center></th>";
        echo "<th><center>Email</center></th>";
        echo "<th><center>Turma</center></th>";
        echo "<th><center>Editar</center></th>";
        echo "<th><center>Excluir</center></th>";
        echo "<th><center>Histórico</center></th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";

        foreach ($UsuarioExibidos as $row) {
            echo "<tr>";
            echo "<td><center>" . $row["NomeAluno"] . "</center></td>";
            echo "<td><center>" . $row["idAluno"] . "</center></td>";
            echo "<td><center>" . $row["EmailAluno"] . "</center></td>";
            echo "<td><center>" . ($row["nomeTurma"] ? $row["AnoTurma"] . ' º ' . $row["nomeTurma"] : "Não se aplica") . "</center></td>";

										// Botões de edição, exclusão e histórico
										echo "<td><center>";
										if (array_key_exists('idAluno', $row)) {
											echo "<button class='edit-button' data-id='" . $row["idAluno"] . "'><i class='fas fa-pencil-alt'></i></button>";
										}
										if (array_key_exists('idProf', $row)) {
											echo "<button class='edit-button' data-id='" . $row["idProf"] . "'><i class='fas fa-pencil-alt'></i></button>";
										}
										echo "</center></td>";


										if (array_key_exists('idAluno', $row)) {
											echo "<td><div class='container'><center><button class='delete-button' type='button' onclick='handlePopup(true)' aria-label='botão excluir'><i class='fas fa-trash-alt'></i></button></center><div class='popup' id='popup'><img src='../img/decisao.png' aria-label='popup decisão'><h2 class='title'>Aviso!</h2><p class='desc'>Deseja mesmo excluir?</p><button class='close-popup-button' type='button' onclick='handlePopup(false)'>Fechar</button><a href='../Controller/CExcluir_aluno.php?id={$row["idAluno"]}'><button class='close-popup-button'>Excluir</button></a></div></div></div></td>";
										}
										if (array_key_exists('idProf', $row)) {
											echo "<td><div class='container'><center><button class='delete-button' type='button' onclick='handlePopup(true)' aria-label='botão excluir'><i class='fas fa-trash-alt'></i></button></center><div class='popup' id='popup'><img src='../img/decisao.png' aria-label='popup decisão'><h2 class='title'>Aviso!</h2><p class='desc'>Deseja mesmo excluir?</p><button class='close-popup-button' type='button' onclick='handlePopup(false)'>Fechar</button><a href='../Controller/CExcluir_prof.php?id={$row["idProf"]}'><button class='close-popup-button'>Excluir</button></a></div></div></div></td>";
										}


										echo "<td><center>";
										if (array_key_exists('idAluno', $row)) {
											echo "<button class='historico-button' data-id='" . $row["idAluno"] . "'>"
												. "<a class='button-link' href='../pdf/registrosAluPdf.php?idAluno=" . $row["idAluno"] . "' target='_blank'>"
												. "<i class='fas fa-history'></i></a></button>";
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
										echo "<a class='page-link $classeAtiva' href='aluno.php?pagina=$i'>$i</a>";
									}
									echo "</div>";

									// Botão Fechar do popup fora da tabela
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
<script src="../ArquivosExternos/Jquery.js"></script>

<script>
    $(document).ready(function() {
        // Capturar clique no botão de edição
        $('.edit-button').click(function() {
            // Encontrar a linha (tr) associada ao botão de edição
            var row = $(this).closest('tr');

            // Obter os dados das células da linha para preencher o formulário
            var id = row.find('td:eq(1)').text(); // ID do aluno
            var nome = row.find('td:eq(0)').text(); // Nome do aluno
            var email = row.find('td:eq(2)').text(); // Email do aluno
            var turma = row.find('td:eq(3)').text(); // Turma do aluno, ajuste caso necessário

            // Preencher os campos do formulário com os dados obtidos
            $('#idAluno').val(id);
            $('#NomeAluno').val(nome); // Corrigindo para preencher o campo do nome do aluno
            $('#EmailAluno').val(email);
            $('#Turma_idTurma').val(turma);

            // Alterar o valor do botão para refletir a ação de edição
            $('input[type="submit"]').val('Atualizar');
            // Alterar a rota do formulário para a rota de atualização de usuários
            $('form').attr('action', '../Router/alunoedit_rotas.php'); // Alterar a action do formulário para a rota correta
            // Alterar o nome do botão para identificar a ação como atualização
            $('input[type="submit"]').attr('name', 'Editar');
        });
    });
</script>

<script>
	$(document).ready(function() {
		// Capturar clique no botão de exclusão
		$('.delete-button').click(function() {
			// Obter o ID do item a ser excluído
			var id = $(this).closest('tr').find('td:eq(1)').text(); // Considerando que o ID está na segunda coluna

			// Mostrar o popup de confirmação
			handlePopup(true);

			// Preencher o link de exclusão com o ID correto
			var linkExclusao = '../Controller/CExcluir_aluno.php?id=' + id;
			$('#popup a').attr('href', linkExclusao);
		});
	});
</script>

<script>
	$(document).ready(function() {
		$('#turmaTable').DataTable(); // Inicializa o DataTables para a tabela de turma
	});
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
	function abrirAluno() {
		var urlDoPDF = "../pdf/registrosAluPdf.php";
		window.open(urlDoPDF, '_blank');
	}
</script>


</body>
</html>