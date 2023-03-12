<?php
	// Reads JSON file with login data
	$usersJson = file_get_contents("./data/login.json");

	// Decodes JSON file with login data
	$users = json_decode($usersJson, true);

	session_cache_expire(120);
	$cache_expire = session_cache_expire();

	// Initialize the session
	session_start();
	 
	// Check if user is already logged in, if so, redirect to welcome page
	if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true)
		header("location: feed.php");

	// Define variables and initialize with empty values
	$username = $password = "";
	$username_err = $password_err = $login_err = "";
	
	// Processing form data when form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// Check if "Login" is empty
		if (empty(trim($_POST["username"])))
			$username_err = "Por favor digite seu login.";
		else
			$username = trim($_POST["username"]);
		
		// Check if "Senha" is empty
		if (empty(trim($_POST["password"])))
			$password_err = "Por favor digite sua senha.";
		else
			$password = trim($_POST["password"]);
		
		// Validate credentials
		if (empty($username_err) && empty($password_err))
		{
			for ($i = 0; $i < count($users['Users']); $i++)
			{
				if ($_POST["username"] == $users['Users'][$i]['Email'])
				{
					$hashed_password = password_hash($password, PASSWORD_DEFAULT);
					if (password_verify($password, $hashed_password))
					{
						// Password is correct, so start a new session
						session_start();
						
						// Store data in session variables
						$_SESSION["loggedin"] = true;
						$_SESSION["user"] = $_POST["username"];
						$_SESSION["nome"] = $users['Users'][$i]['Nome'];
						$_SESSION["follow"] = $users['Users'][$i]['Seguindo'];
						
						// Redirect user to feed page
						header("location: feed.php");
					} else
						$login_err = "Login/senha inválidos.";
				}
			}
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title>Teste Ergon</title>
		<link rel="stylesheet" type="text/css" href="./style.css">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	</head>
	<body>
		<h1 class="text-center titulo">Login</h1>
		<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">E-mail:</label>
					<input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" name="username" id="username" placeholder="Login">
					<span class="invalid-feedback"><?php echo $username_err; ?></span>
				</div>
			</div>
			<br/>
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">Senha:</label>
					<input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Senha">
					<span class="invalid-feedback"><?php echo $password_err; ?></span>
				</div>
			</div><br/>
			<div class="text-center">
				<p class="texto" style="color: blue"><?php echo $login_err; ?></p>
				<input type="submit" class="btn btn-primary" value="Entrar">
			</div>
			<div class="btnCad">
				<a href="./cadastro.php" class="btn btn-secondary">Cadastro</a>
			</div>
		</form>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="./index.js"></script>
	</body>
</html>