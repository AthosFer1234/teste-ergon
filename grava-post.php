<?php
	session_cache_expire(120);
	$cache_expire = session_cache_expire();

	// Initialize the session
	session_start(); 

	$postsJson = file_get_contents("./data/posts.json");

	$posts = json_decode($postsJson, true);

	$id = $_POST["id"];
	$index = $id - 1;

	$posts['Posts'][$index]['Recom'] = $_POST["recom"];
	$posts['Posts'][$index]['NaoRecom'] = $_POST["naorecom"];
	$posts['Posts'][$index]['IntFlag'] = 1;

	$jsonPost = json_encode($posts, JSON_PRETTY_PRINT);
	$file = fopen('./data/posts.json', 'w');
	fwrite($file, $jsonPost);
	fclose($file);

	$usersJson = file_get_contents("./data/login.json");

	$users = json_decode($usersJson, true);

	for ($i = 0; $i < count($users['Users']); $i++)
	{
		if ($_SESSION["user"] == $users['Users'][$i]['Email'] && !in_array($_POST["id"], $users['Users'][$i]['Seguindo']))
			array_push($users['Users'][$i]['Seguindo'], $_POST["id"]);
	}

	$jsonUser = json_encode($users, JSON_PRETTY_PRINT);
	$file = fopen('./data/login.json', 'w');
	fwrite($file, $jsonUser);
	fclose($file);
?>