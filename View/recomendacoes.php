<?php
include('../Controller/CConexao.php');

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
			<li class="active">
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
				<img src="../img/adm.png">
			</a>
		</nav>

		</head>

		<body>

			<section class="tabela">

				<div class="row">
				<form action="../Router/Rec_rotas.php" method="post" enctype="multipart/form-data">
						<h3>Recomendações semanais</h3>
						<input type="text" id="idRec" name="idRec" placeholder="ID" class="box3 select-dark-mode" autocomplete="off" readonly>							
						<input type="text" placeholder="Livro" name="LivroRec" id="LivroRec" required maxlength="50" class="box" autocomplete="off" required>
						<input type="text" placeholder="Autor" name="AutorRec" id="AutorRec" required maxlength="50" class="box" autocomplete="off" required>
						<input type="text" placeholder="Categoria" name="CatRec" id="CatRec" required maxlength="50" class="box" autocomplete="off" required>
						<input type="file" name="ImgRec" id="ImgRec" class="box1">
						<center><input type="submit" value="Enviar" class="inline-btn" name="atualizar"></center>
					</form>
				</div>
			</section>
			<style>
								#content main .table-data .head h3 {
    color: var(--cinzaEscuro);
    margin-right: auto !important;
    margin-left: auto;
    font-size: 2rem;
    font-family: 'Mulish', sans-serif;
    font-weight: bolder;
    margin-top: -15px;
}</style>
			<main>
				<div class="table-data">
					<div class="order">
						<div class="head">
							<h3><br>Tabela de recomendações<br></h3>
						</div>
						<table>
							
							<?php
    $conexao = new CConexao();
    $conn = $conexao->getConnection();

    // Consulta para obter os dados da tabela de usuários
    $sql = "SELECT
                recomendacao.LivroRec,
                recomendacao.idRec,
                recomendacao.AutorRec,
                recomendacao.CatRec,
                recomendacao.CamRec
            FROM recomendacao";

    $result = $conn->query($sql);

    if ($result === false) {
        // Use errorInfo para obter informações sobre o erro
        $errorInfo = $conn->errorInfo();
        echo "Erro na consulta SQL: " . $errorInfo[2];
    } else {
        if ($result->rowCount() > 0) {
            $rec = $result->fetchAll(PDO::FETCH_ASSOC);
            $RecPorPagina = 4;
            $paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
            $indiceInicial = ($paginaAtual - 1) * $RecPorPagina;
            $RecExibidos = array_slice($rec, $indiceInicial, $RecPorPagina);

            // Exibir a tabela de usuários
            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th><center>Livro</center></th>";
            echo "<th><center>ID</center></th>";
            echo "<th><center>Autor</center></th>";
            echo "<th><center>Categoria</center></th>";
            echo "<th><center>Imagem</center></th>";
            echo "<th><center>Editar</center></th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            foreach ($RecExibidos as $row) {
                echo "<tr>";
                echo "<td><center>" . $row["LivroRec"] . "</center></td>";
                echo "<td><center>" . $row["idRec"] . "</center></td>";
                echo "<td><center>" . $row["AutorRec"] . "</center></td>";
                echo "<td><center>" . $row["CatRec"] . "</center></td>"; 
                echo "<td><center><img src='" . $row["CamRec"] . "' alt='Imagem do Livro' /></center></td>";
				echo "<td><center><button class='edit-button' data-id='$row[idRec]'><i class='fas fa-pencil-alt'></i></button></center></td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";

            // Adiciona links de paginação
            echo "<div class='pagination'>";
            $totalRec = count($rec);
            $totalPaginas = ceil($totalRec / $RecPorPagina);
            for ($i = 1; $i <= $totalPaginas; $i++) {
                $classeAtiva = ($i === $paginaAtual) ? "active" : "";
                echo "<a class='page-link $classeAtiva' href='recomendacoes.php?pagina=$i'>$i</a>";
            }
            echo "</div>";

            // Botão Fechar do popup fora da tabela
            
        } else {
            echo "<p>Nenhum usuário encontrado.</p>";
        }
    }

    $conn = null; // Fecha a conexão
?>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Capturar clique no botão de edição
        $('.edit-button').click(function() {
            // Obter o ID do item a ser editado
            var id = $(this).data('id');

            // Encontrar os dados correspondentes na tabela e preencher o formulário
            $('table tbody tr').each(function() {
                var rowId = $(this).find('td:eq(1)').text(); // Considerando que o ID está na segunda coluna
                if (rowId == id) {
                    var livro = $(this).find('td:eq(0)').text();
                    var autor = $(this).find('td:eq(2)').text();
                    var categoria = $(this).find('td:eq(3)').text();

                    // Preencher os campos do formulário com os dados obtidos
                    $('#idRec').val(id);
                    $('#LivroRec').val(livro);
                    $('#AutorRec').val(autor);
                    $('#CatRec').val(categoria);
                    // Não está preenchendo o campo de imagem, pois é mais complexo
                    // Pode exigir uma lógica diferente ou uma abordagem de armazenamento/manipulação diferente
                    // ...
                }
            });
        });
    });
</script>
</body>

</html>