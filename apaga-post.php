<?php
	session_cache_expire(120);
	$cache_expire = session_cache_expire();

	// Initialize the session
	session_start();

	$msg = "";

	$postsJson = file_get_contents("./data/posts.json");

	$posts = json_decode($postsJson, true);

	$index = $_POST["idD"] - 1;

	// Check if post has interactions
	if ($posts['Posts'][$index]['IntFlag'])
		$msg = "Voce nao pode apagar um post com interacoes!";

	// Check if post was created by the user
	if ($posts['Posts'][$index]['CrMail'] != $_SESSION["user"])
		$msg = "Voce nao pode apagar um post que nao seja seu!";

	if (empty($msg))
	{
		unset($posts['Posts'][$index]);

		$jsonPost = json_encode($posts, JSON_PRETTY_PRINT);
		$file = fopen('./data/posts.json', 'w');
		fwrite($file, $jsonPost);
		fclose($file);

		$msg = "Post deletado com sucesso!";
	}

	// Redirect user to feed page
	header("location: feed.php?msg=".$msg);
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Teste Ergon</title>
		<link rel="stylesheet" type="text/css" href="./style.css">
	</head>
	<body>
		<h1>Aguarde...</h1>
	</body>
</html>