<?php
include('../Controller/CConexao.php');

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
							<option value="Autoajuda">Autoajuda</option>
							<option value="Biografia">Biografia</option>
							<option value="Clássico">Clássico</option>
							<option value="Conto">Conto</option>
							<option value="Fantasia">Fantasia</option>
							<option value="Ficção científica">Ficção científica</option>
							<option value="Poesia">Poesia</option>
							<option value="Romance">Romance</option>
							<option value="Outro">Outro</option>
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
						<?php
$conexao = new CConexao();
$conn = $conexao->getConnection();

// Consulta para obter os dados da tabela de livros
$sql = "SELECT
            livro.idLivro,
            livro.NomeLivro,
            livro.EditoraLivro,
            livro.IBSMLivro,
            genero.NomeGenero AS GeneroLivro,
            idioma.Idioma AS IdiomaLivro,
            livro.FotoLivro,
            livro.LocalLivro,
            altor.NomeAltor
        FROM
            livro
        LEFT JOIN
            genero ON livro.Genero_idGenero = genero.idGenero
        LEFT JOIN
            altor ON livro.Altor_idAltor = altor.idAltor
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
        $livrosPorPagina = 4;
        $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        $indiceInicial = ($paginaAtual - 1) * $livrosPorPagina;
        $livrosExibidos = array_slice($livros, $indiceInicial, $livrosPorPagina);

        echo "<table>";
        echo "<thead>";
        echo "<tr>";
        echo "<th><center>Nome</center></th>";
        echo "<th><center>ID</center></th>";
        echo "<th><center>Editora</center></th>";
        echo "<th><center>ISBN</center></th>";
        echo "<th><center>Gênero</center></th>";
        echo "<th><center>Idioma</center></th>";
        echo "<th><center>Imagem</center></th>";
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
            echo "<td><center>" . $row["IBSMLivro"] . "</center></td>";
            echo "<td><center>" . $row["GeneroLivro"] . "</center></td>";
            echo "<td><center>" . $row["IdiomaLivro"] . "</center></td>";
            echo "<td><center><img src='" . $row["FotoLivro"] . "' alt='Imagem do Livro' /></center></td>";
            echo "<td><center><button class='historico-button'><i class='fas fa-map-marker-alt'></i></button></center></td>";
            echo "<td><center><button class='edit-button'><i class='fas fa-pencil-alt'></i></button></center></td>";
            echo "<td><center><button class='delete-button'><i class='fas fa-trash-alt'></i></button></center></td>";
            echo "</tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Adiciona links de paginação
        echo "<div class='pagination'>";
        $totalLivros = count($livros);
        $totalPaginas = ceil($totalLivros / $livrosPorPagina);
        for ($i = 1; $i <= $totalPaginas; $i++) {
            $classeAtiva = ($i === $paginaAtual) ? "active" : "";
            echo "<a class='page-link $classeAtiva' href='livros.php?pagina=$i'>$i</a>";
        }
        echo "</div>";
    } else {
        echo "<tr><td colspan='8'>Nenhum livro encontrado.</td></tr>";
    }
}

$conn = null; // Fecha a conexão
?>
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