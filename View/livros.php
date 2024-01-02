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
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../ArquivosExternos/icons.js"></script>
	<link rel="shortcut icon" href="../img/icon1.png" type="image/x-icon">
	<link rel="stylesheet" href="../CSS/style.css">
	<link rel="stylesheet" href="../CSS/popup2.css">
	<link rel="stylesheet" href="../CSS/darkPaginacao.css">

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
					<form action="../router/livro_rotas.php" method="post" enctype="multipart/form-data">
						<h3>Cadastro de livros</h3>
						<input type="text" placeholder="ID" name="idLivro" id="idLivro" required  class="box3" autocomplete="off" readonly>
						<style>

						</style>
						<input type="text" placeholder="Nome" name="NomeLivro" id="NomeLivro" class="box" autocomplete="off" required>
						<input type="text" placeholder="Autor" name="NomeAutor" id="NomeAutor" class="box" autocomplete="off" required>
						<input type="text" placeholder="Edição" name="EdicaoLivro" id="EdicaoLivro"  class="box" autocomplete="off">
						<input type="text" placeholder="Editora" name="EditoraLivro" id="EditoraLivro"  class="box" autocomplete="off">
						<input type="text" placeholder="Tombo " name="Tombo" id="Tombo" class="box" autocomplete="off">
						<input type="text" placeholder="ISBN / CDD " name="IBSMLivro" id="IBSMLivro"  class="box" autocomplete="off">


						<select name="Genero_idGenero" id="Genero_idGenero" class="box select-dark-mode" required>
							<option value="1">Autoajuda</option>
							<option value="2">Biografia</option>
							<option value="3">Clássico</option>
							<option value="4">Conto</option>
							<option value="5">Fantasia</option>
							<option value="6">Ficção</option>
							<option value="7">Poesia</option>
							<option value="8">Romance</option>
							<option value="9">Outro</option>
						</select>
						<select name="Idioma_idIdioma" id="Idioma_idIdioma" class="box select-dark-mode">
							<option value="1">Português</option>
							<option value="2">Inglês</option>
							<option value="3">Espanhol</option>
						</select>

						<select name="DidaticoLivro" id="DidaticoLivro" class="box select-dark-mode">
						<option value="Não">Material não didático</option>
							<option value="Sim">Material didático</option>
						</select>
						<input type="text" placeholder="Localização" name="LocalLivro" id="LocalLivro" class="box" autocomplete="off">


						<input type="text" placeholder="Quantidade" name="QuantidadeLivros" id="QuantidadeLivros" class="box" autocomplete="off">

						<center><input type="submit" value="Cadastrar" id="cadastrar" class="inline-btn" name="action"></center>
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
				}
			</style>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3>Tabela de cadastro livros</h3>
							<input type="text" id="searchInput" class="searchInput" placeholder="Pesquisar...">

							<button class="pdf-button" id="pdf-button" aria-label="botão pdf" onclick="abrirAluno()">
								<i class="fas fa-file-pdf"></i></button>

							<script>
								function abrirAluno() {
									var urlDoPDF = "../pdf/livroPdf.php";
									window.open(urlDoPDF, '_blank');
								}
							</script>

						</div>
						<table>
							<?php
							$conexao = new CConexao();
							$conn = $conexao->getConnection();

							// Consulta para obter os dados da tabela de livros
							$sql = "SELECT
            livro.idLivro,
            livro.NomeLivro,
            livro.EditoraLivro,
            livro.Tombo,
            livro.IBSMLivro,
			livro.QuantidadeLivros,
            genero.NomeGenero AS GeneroLivro,
            idioma.Idioma AS IdiomaLivro,
            livro.LocalLivro,
            livro.PrateleiraLivro,
            livro.ColunaLivro,
            autor.NomeAutor
        FROM
            livro
        LEFT JOIN
            genero ON livro.Genero_idGenero = genero.idGenero
        LEFT JOIN
            autor ON livro.Autor_idAutor = autor.idAutor
        LEFT JOIN
            idioma ON livro.Idioma_idIdioma = idioma.idIdioma";

							$result = $conn->query($sql);

							if ($result === false) {
								// Use errorInfo para obter informações sobre o erro
								$errorInfo = $conn->errorInfo();
								echo "Erro na consulta SQL: " . $errorInfo[2];
							} else {
								if ($result->rowCount() > 0) {
									$livros = $result->fetchAll(PDO::FETCH_ASSOC);
									$livrosPorPagina = 5;
									$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
									$indiceInicial = ($paginaAtual - 1) * $livrosPorPagina;
									$livrosExibidos = array_slice($livros, $indiceInicial, $livrosPorPagina);

									echo "<table>";
									echo "<thead>";
									echo "<tr>";
									echo "<th><center>Nome</center></th>";
									echo "<th><center>ID</center></th>";
									echo "<th><center>Editora</center></th>";
									echo "<th><center>Tombo</center></th>";
									echo "<th><center>ISBN / CDD</center></th>";
									echo "<th><center>Gênero</center></th>";
									echo "<th><center>Idioma</center></th>";
									echo "<th><center>Quantidade</center></th>";
									echo "<th><center>Localização</center></th>";
									echo "<th><center>Editar</center></th>";
									echo "<th><center>Excluir</center></th>";
									echo "</tr>";
									echo "</thead>";
									echo "<tbody>";

									foreach ($livrosExibidos as $row) {
										echo "<tr>";
										echo "<td><center>" . $row["NomeLivro"] . "</center></td>";
										echo "<td><center>" . $row["idLivro"] . "</center></td>";
										echo "<td><center>" . $row["EditoraLivro"] . "</center></td>";
										echo "<td><center>" . $row["Tombo"] . "</center></td>";
										echo "<td><center>" . $row["IBSMLivro"] . "</center></td>";
										echo "<td><center>" . $row["GeneroLivro"] . "</center></td>";
										echo "<td><center>" . $row["IdiomaLivro"] . "</center></td>";
										echo "<td><center>" . $row["QuantidadeLivros"] . "</center></td>";
										echo "<td><div class='container'><center><button class='historico-button' type='button' onclick='handlePopup1(\"" . $row["LocalLivro"] . "\", \"" . $row["PrateleiraLivro"] . "\", \"" . $row["ColunaLivro"] . "\")'><i class='fas fa-map-marker-alt'></i></button></center><div class='popup1' id='popup1'><img src='../img/livro.png'><h2 class='title'>Localização</h2><p class='desc'><b>✧ Localização: </b></p><p class='desc'></p><p class='desc'></p><button class='close-popup1-button' type='button' onclick='handlePopup1(false)'>Fechar</button></div></div></div></td>";

										echo "<td><center><button class='edit-button'><i class='fas fa-pencil-alt'></i></button></center></td>";
										echo "<td><div class='container'><center><button class='delete-button' type='button' onclick='handlePopup(true)' aria-label='botão excluir'><i class='fas fa-trash-alt'></i></button></center><div class='popup' id='popup'><img src='../img/decisao.png' aria-label='popup decisão'><h2 class='title'>Aviso!</h2><p class='desc'>Deseja mesmo excluir?</p><button class='close-popup-button' type='button' onclick='handlePopup(false)'>Fechar</button><a href='../Controller/CExcluir_livros.php?id={$row["idLivro"]}'><button class='close-popup-button'>Excluir</button></a></div></div></div></td>";
										echo "</tr>";
									}




									echo "</tbody>";
									echo "</table>";

									// Adiciona links de paginação
									echo "<div class='pagination'>";
									$totalLivros = count($livros);
									$totalPaginas = ceil($totalLivros / $livrosPorPagina);

									if ($totalPaginas > 4) {
										// Se houver mais de 4 páginas, exibe de forma mais seletiva
										if ($paginaAtual <= 2) {
											for ($i = 1; $i <= 3; $i++) {
												$classeAtiva = ($i === $paginaAtual) ? "active" : "";
												echo "<a class='page-link $classeAtiva' href='livros.php?pagina=$i'>$i</a>";
											}
											echo "<span>ₒₒₒ</span>";
											echo "<a class='page-link' href='livros.php?pagina=$totalPaginas'>$totalPaginas</a>";
										} elseif ($paginaAtual >= $totalPaginas - 1) {
											echo "<a class='page-link' href='livros.php?pagina=1'>1</a>";
											echo "<span>ₒₒₒ</span>";
											for ($i = $totalPaginas - 2; $i <= $totalPaginas; $i++) {
												$classeAtiva = ($i === $paginaAtual) ? "active" : "";
												echo "<a class='page-link $classeAtiva' href='livros.php?pagina=$i'>$i</a>";
											}
										} else {
											echo "<a class='page-link' href='livros.php?pagina=1'>1</a>";
											echo "<span>ₒₒₒ</span>";
											for ($i = $paginaAtual - 1; $i <= $paginaAtual + 1; $i++) {
												$classeAtiva = ($i === $paginaAtual) ? "active" : "";
												echo "<a class='page-link $classeAtiva' href='livros.php?pagina=$i'>$i</a>";
											}
											echo "<span>ₒₒₒ</span>";
											echo "<a class='page-link' href='livros.php?pagina=$totalPaginas'>$totalPaginas</a>";
										}
									} else {
										// Caso contrário, exibe normalmente
										for ($i = 1; $i <= $totalPaginas; $i++) {
											$classeAtiva = ($i === $paginaAtual) ? "active" : "";
											echo "<a class='page-link $classeAtiva' href='livros.php?pagina=$i'>$i</a>";
										}
									}

									echo "</div>";
								} else {
									echo "<tr><td colspan='8'><center>Nenhum livro encontrado.</center></td></tr>";
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

</body>

</html>

<script src="../JS/script.js"></script>
<script src="../JS/popup.js"></script>

<script src="../ArquivosExternos/Jquery.js"></script>

<script>
	$(document).ready(function() {
    // Capturar clique no botão de edição
    $('.edit-button').click(function() {
        // Obter os dados da linha correspondente na tabela de livros
        var idLivro = $(this).closest('tr').find('td:eq(1)').text(); // ID do livro na segunda coluna, ajuste conforme a estrutura real da sua tabela
        var NomeLivro = $(this).closest('tr').find('td:eq(0)').text(); // Nome do livro na primeira coluna, ajuste conforme a estrutura real da sua tabela
        var EditoraLivro = $(this).closest('tr').find('td:eq(2)').text(); // Editora na terceira coluna, ajuste conforme a estrutura real da sua tabela
        var Tombo = $(this).closest('tr').find('td:eq(3)').text(); // ISBN/CDD na quarta coluna, ajuste conforme a estrutura real da sua tabela
        var IBSMLivro = $(this).closest('tr').find('td:eq(4)').text(); // ISBN/CDD na quarta coluna, ajuste conforme a estrutura real da sua tabela
        var GeneroLivro = $(this).closest('tr').find('td:eq(5)').text(); // Gênero na quinta coluna, ajuste conforme a estrutura real da sua tabela
        var IdiomaLivro = $(this).closest('tr').find('td:eq(6)').text(); // Idioma na sexta coluna, ajuste conforme a estrutura real da sua tabela
        var QuantidadeLivros = $(this).closest('tr').find('td:eq(7)').text(); // Quantidade na sétima coluna, ajuste conforme a estrutura real da sua tabela
        var LocalLivro = $(this).closest('tr').find('td:eq(8)').text(); // Localização na oitava coluna, ajuste conforme a estrutura real da sua tabela
        var PrateleiraLivro = $(this).closest('tr').find('td:eq(9)').text(); // Prateleira na nona coluna, ajuste conforme a estrutura real da sua tabela
        var ColunaLivro = $(this).closest('tr').find('td:eq(10)').text(); // Coluna na décima coluna, ajuste conforme a estrutura real da sua tabela

        // Preencher o formulário com os dados obtidos
        preencherFormulario(idLivro, NomeLivro, EditoraLivro, Tombo, IBSMLivro, GeneroLivro, IdiomaLivro, QuantidadeLivros, LocalLivro, PrateleiraLivro, ColunaLivro); // Chama a função para preencher o formulário com os dados obtidos

        // Alterar o modo de ação para editar
        $('#modoAcao').val('editar');
        // Alterar o valor do botão para refletir a ação de edição
        $('input[type="submit"]').val('Editar');
        // Modificar o action do formulário para o script responsável pela atualização
        $('form').attr('action', '../router/Atualizar_livrorotas.php');
        // Modificar o texto do botão de envio para "Atualizar"
        $('input[type="submit"]').attr('name', 'Editar');
    });
});

// Função para preencher o formulário com os dados do livro ao clicar no botão de edição
function preencherFormulario(idLivro, NomeLivro, EditoraLivro, Tombo, IBSMLivro, GeneroLivro, IdiomaLivro, QuantidadeLivros, LocalLivro, PrateleiraLivro, ColunaLivro) {
    $('#idLivro').val(idLivro);
    $('#NomeLivro').val(NomeLivro);
    $('#EditoraLivro').val(EditoraLivro);
    $('#Tombo').val(Tombo);
    $('#IBSMLivro').val(IBSMLivro);
    $('#Genero_idGenero').val(GeneroLivro); // Ajuste conforme o ID do campo select para o gênero na sua página
    $('#Idioma_idIdioma').val(IdiomaLivro); // Ajuste conforme o ID do campo select para o idioma na sua página
    $('#QuantidadeLivros').val(QuantidadeLivros);
    $('#LocalLivro').val(LocalLivro);
    $('#PrateleiraLivro').val(PrateleiraLivro); // Ajuste conforme o ID do campo select para a prateleira na sua página
    $('#ColunaLivro').val(ColunaLivro); // Ajuste conforme o ID do campo select para a coluna na sua página
}

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
			var linkExclusao = '../Controller/CExcluir_livros.php?id=' + id;
			$('#popup a').attr('href', linkExclusao);
		});
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
	function handlePopup1(local, prateleira, coluna) {
		const popup = document.getElementById("popup1");

		if (popup.classList.contains("opened")) {
			popup.classList.remove("opened");
		} else {
			const locationInfo = `
            <b>✧ Localização:</b> ${local}<br>
        `;

			document.querySelector("#popup1 .desc").innerHTML = locationInfo;
			popup.classList.add("opened");
		}
	}
</script>

</body>

</html>