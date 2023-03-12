<?php
	// Reads JSON file with login data
	$usersJson = file_get_contents("./data/login.json");

	// Decodes JSON file with login data
	$users = json_decode($usersJson, true);

	// Reads JSON file with posts data
	$postsJson = file_get_contents("./data/posts.json");

	// Decodes JSON file with posts data
	$posts = json_decode($postsJson, true);

	session_cache_expire(120);
	$cache_expire = session_cache_expire();

	// Initialize the session
	session_start();

	// Define variable and initialize with empty value
	$success = "";
	 
	// Check if user is already logged in, if so, redirect to welcome page
	if (!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true)
		header("location: index.php");

	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if (!empty($_POST["titulo"]) && !empty($_POST["descricao"]) && !empty($_POST["tipo"]))
		{
			$c = count($posts['Posts']);

			// Set the data to the associative array
			$posts['Posts'][$c]['Id'] = $c+1;
			$posts['Posts'][$c]['CrMail'] = $_SESSION["user"];
			$posts['Posts'][$c]['CrNome'] = $_SESSION["nome"];
			$posts['Posts'][$c]['Titulo'] = $_POST["titulo"];
			$posts['Posts'][$c]['Descricao'] = $_POST["descricao"];
			$posts['Posts'][$c]['Tipo'] = $_POST["tipo"];
			$posts['Posts'][$c]['Recom'] = 0;
			$posts['Posts'][$c]['NaoRecom'] = 0;
			$posts['Posts'][$c]['IntFlag'] = 0;
			$posts['Posts'][$c]['ConclFlag'] = 0;

			// Encode the associative array to JSON and write to the file
			$jsonPost = json_encode($posts, JSON_PRETTY_PRINT);
			$file = fopen('./data/posts.json', 'w');
			fwrite($file, $jsonPost);
			fclose($file);

			// Success message
			$success = "Post publicado com sucesso!";
		} else
			// Failure message
			$success = "O post não pôde ser publicado! Por favor revise as informações...";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Teste Ergon</title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
		<link rel="stylesheet" type="text/css" href="./style.css">
	</head>
	<body>
		<div class="navbar">
			<a href="./feed.php" class="selected">Geral</a>
			<a href="./seguindo.php">Seguindo</a>
			<a href="./logout.php" class="btn btn-danger logoutBtn">Logout</a>
		</div>
		<a href="javascript:abreModal()" class="btn btn-info postBtn"><i class="fa-solid fa-plus"></i> Criar Post</a>

		<div class="postFeed">
			<?php
				if (count($posts['Posts']))
				{
					for ($i = 0; $i < count($posts['Posts']); $i++)
					{ 
						echo "<div class='postagem'>".PHP_EOL;
						echo "<div style='margin: 5px; text-align: right'>".PHP_EOL;
						echo "<a href='javascript:conlcuirPost(".$posts['Posts'][$i]['Id'].", \"".$posts['Posts'][$i]['Titulo']."\", \"".$posts['Posts'][$i]['Descricao']."\", \"".$posts['Posts'][$i]['Tipo']."\")' style='color: green'><i class='fa-solid fa-circle-check'></i></a>".PHP_EOL;
						echo "</div>".PHP_EOL;
						echo "<div style='margin: 5px;  text-align: left'>".PHP_EOL;
						echo "<p>Postado por: ".$posts['Posts'][$i]['CrNome']."&nbsp;&nbsp;<a href='javascript:deletePost(".$posts['Posts'][$i]['Id'].", \"".$posts['Posts'][$i]['Titulo']."\", \"".$posts['Posts'][$i]['Descricao']."\", \"".$posts['Posts'][$i]['Tipo']."\")' style='color: red'><i class='fa-solid fa-trash-can'></i></a></p>".PHP_EOL;
						echo "</div>".PHP_EOL;
						echo "<div style='margin: 5px'>".PHP_EOL;
						echo "<h4 class='info'>".$posts['Posts'][$i]['Titulo']."</h4>".PHP_EOL;
						echo "<h5 class='info'>".$posts['Posts'][$i]['Descricao']."</h5>".PHP_EOL;
						echo "<p style='text-align: left; font-size: 20px'>".$posts['Posts'][$i]['Tipo']."</p>".PHP_EOL;
						echo "</div>".PHP_EOL;

						if (!$posts['Posts'][$i]['ConclFlag'])
						{
							echo "<div style='margin: 5px'>".PHP_EOL;
							echo "<a href='javascript:interagePost(".$posts['Posts'][$i]['Id'].", ".$posts['Posts'][$i]['Recom'].", ".$posts['Posts'][$i]['NaoRecom'].")' class='btn btn-secondary' id='S".$posts['Posts'][$i]['Id']."'><i class='fa-solid fa-eye'></i> Seguir</a>".PHP_EOL;
							echo "<a href='javascript:interagePost(".$posts['Posts'][$i]['Id'].", ".$posts['Posts'][$i]['Recom'].", ".($posts['Posts'][$i]['NaoRecom']+1).")' class='btn btn-danger' id='N".$posts['Posts'][$i]['Id']."'>".$posts['Posts'][$i]['NaoRecom']." <i class='fa-solid fa-thumbs-down'></i></a>".PHP_EOL;
							echo "<a href='javascript:interagePost(".$posts['Posts'][$i]['Id'].", ".($posts['Posts'][$i]['Recom']+1).", ".$posts['Posts'][$i]['NaoRecom'].")' class='btn btn-success' id='R".$posts['Posts'][$i]['Id']."'>".$posts['Posts'][$i]['Recom']." <i class='fa-solid fa-thumbs-up'></i></a>".PHP_EOL;
							echo "</div>".PHP_EOL;
						} else
						{
							echo "<div style='margin: 5px'>".PHP_EOL;
							echo "<a href='javascript:interagePost(".$posts['Posts'][$i]['Id'].", ".$posts['Posts'][$i]['Recom'].", ".($posts['Posts'][$i]['NaoRecom']+1).")' class='btn btn-danger disabled' id='N".$posts['Posts'][$i]['Id']."'>".$posts['Posts'][$i]['NaoRecom']." <i class='fa-solid fa-thumbs-down'></i></a>".PHP_EOL;
							echo "<a href='javascript:interagePost(".$posts['Posts'][$i]['Id'].", ".($posts['Posts'][$i]['Recom']+1).", ".$posts['Posts'][$i]['NaoRecom'].")' class='btn btn-success disabled' id='R".$posts['Posts'][$i]['Id']."'>".$posts['Posts'][$i]['Recom']." <i class='fa-solid fa-thumbs-up'></i></a>".PHP_EOL;
							echo "</div>".PHP_EOL;
						}

						echo "</div>".PHP_EOL;
					}
				} else
				{
					echo "<h2 style='text-align: center'>Nada por aqui... Comece a postar!</h2>".PHP_EOL;
				}
			?>
		</div>

		<!-- Modal -->
		<div id="modalCriar" class="modal">
			<div class="modalCont">
				<span onclick="fechaModal()" class="close">&times;</span>
				<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<h4>Novo Post</h4>
					<div class="row">
						<div class="col-md-12">
							<label>Título</label>
							<input type="text" class="form-control" id="titulo" name="titulo">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Descrição</label>
							<input type="text" class="form-control" id="descricao" name="descricao">
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Tipo</label>
							<select class="form-select" id="tipo" name="tipo">
								<option selected value="" disabled>Selecione</option>
								<option value="Filme">Filme</option>
								<option value="Serie">Série</option>
							</select>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="col-md-6">
							<a href="javascript:fechaModal()" class="btn btn-danger">Cancelar</a>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-success publBtn">Publicar</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div id="modalDelete" class="modal">
			<div class="modalCont">
				<span onclick="fechaModal()" class="close">&times;</span>
				<form enctype="multipart/form-data" action="apaga-post.php" method="post">
					<h4>Tem certeza que deseja apagar o post?</h4>
					<div class="row">
						<div class="col-md-12">
							<label>Título</label>
							<input type="text" class="form-control" id="tituloD" name="tituloD" readonly>
							<input type="hidden" class="form-control" id="idD" name="idD" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Descrição</label>
							<input type="text" class="form-control" id="descricaoD" name="descricaoD" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Tipo</label>
							<input type="text" class="form-control" id="tipoD" name="tipoD" readonly>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="col-md-6">
							<a href="javascript:fechaModal()" class="btn btn-danger">Cancelar</a>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-success publBtn">Apagar</button>
						</div>
					</div>
				</form>
			</div>
		</div>

		<div id="modalConclui" class="modal">
			<div class="modalCont">
				<span onclick="fechaModal()" class="close">&times;</span>
				<form enctype="multipart/form-data" action="conclui-post.php" method="post">
					<h4>Tem certeza que deseja concluir o post? Ninguém mais poderá interagir com ele.</h4>
					<div class="row">
						<div class="col-md-12">
							<label>Título</label>
							<input type="text" class="form-control" id="tituloC" name="tituloC" readonly>
							<input type="hidden" class="form-control" id="idC" name="idC" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Descrição</label>
							<input type="text" class="form-control" id="descricaoC" name="descricaoC" readonly>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<label>Tipo</label>
							<input type="text" class="form-control" id="tipoC" name="tipoC" readonly>
						</div>
					</div>
					</br>
					<div class="row">
						<div class="col-md-6">
							<a href="javascript:fechaModal()" class="btn btn-danger">Cancelar</a>
						</div>
						<div class="col-md-6">
							<button type="submit" class="btn btn-success publBtn">Concluir</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="./index.js"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				<?php
					if (!empty($success))
						echo "alert('".$success."');".PHP_EOL;
					if (isset($_GET['msg']) && !empty($_GET['msg']))
						echo "alert('".$_GET['msg']."');".PHP_EOL;
				?>
			});
		</script>
	</body>
</html>