<?php
	// Reads JSON file with login data
	$usersJson = file_get_contents("./data/login.json");

	// Decodes JSON file with login data
	$users = json_decode($usersJson, true);

	// Define variables and initialize with empty values
	$nome = $email = $cpf = $password = $success = "";
	$nome_err = $email_err = $cpf_err = $password_err = $passwordConfirm_err = "";

	// Processing form data when form is submitted
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		// Check if "CPF" and "Email" aren't already registered
		for ($i = 0; $i < count($users['Users']); $i++)
		{
			if ($_POST["cpf"] == $users['Users'][$i]['CPF'])
			{
				$cpf_err = "CPF já cadastrado!";
			}
			if ($_POST["email"] == $users['Users'][$i]['Email'])
			{
				$email_err = "E-mail já cadastrado!";
			}
		}

		// Check if "Nome" is empty
		if (empty(trim($_POST["nome"])))
			$nome_err = "Por favor digite o nome.";
		else
			$nome = trim($_POST["nome"]);

		// Check if "E-mail" is empty
		if (empty(trim($_POST["email"])))
			$email_err = "Por favor digite o e-mail.";
		else
			$email = trim($_POST["email"]);

		// Check if "CPF" is empty
		if (empty(trim($_POST["cpf"])))
			$cpf_err = "Por favor digite o CPF.";
		else
			$cpf = trim($_POST["cpf"]);
		
		// Check if "Senha" is empty
		if (empty(trim($_POST["password"])))
			$password_err = "Por favor digite a senha.";
		else
			$password = trim($_POST["password"]);

		// Check if "Confirmar Senha" is empty
		if (empty(trim($_POST["passwordConfirm"])))
			$passwordConfirm_err = "Por favor confirme a senha.";
		else
			$passwordConfirm_err = "";

		// Check if "Confirmar Senha" equals to "Senha"
		if ($_POST["passwordConfirm"] != $_POST["password"])
			$passwordConfirm_err = "A senha e a confirmação da senha devem ser iguais.";
		else
			$passwordConfirm_err = "";
		
		if (empty($nome_err) && empty($email_err) && empty($cpf_err) && empty($password_err) && empty($passwordConfirm_err))
		{
			$c = count($users['Users']);

			// Set the data to the associative array
			$users['Users'][$c]['Nome'] = $_POST["nome"];
			$users['Users'][$c]['CPF'] = $_POST["cpf"];
			$users['Users'][$c]['Email'] = $_POST["email"];
			$users['Users'][$c]['Senha'] = strval(password_hash($_POST["password"], PASSWORD_DEFAULT));
			$users['Users'][$c]['Seguindo'] = [];

			// Encode the associative array to JSON and write to the file
			$jsonData = json_encode($users, JSON_PRETTY_PRINT);
			$fp = fopen('./data/login.json', 'w');
			fwrite($fp, $jsonData);
			fclose($fp);

			// Success message and redirect user to login page
			$success = "Usuário cadastrado com sucesso! Aguarde...";
			header("refresh:3, index.php");
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
		<h1 class="text-center titulo">Cadastro</h1>
		<form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">Nome:</label>
					<input type="text" class="form-control <?php echo (!empty($nome_err)) ? 'is-invalid' : ''; ?>" name="nome" id="nome" placeholder="Nome">
					<span class="invalid-feedback texto"><?php echo $nome_err; ?></span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">E-mail:</label>
					<input type="text" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" name="email" id="email" placeholder="E-mail">
					<span class="invalid-feedback texto"><?php echo $email_err; ?></span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">CPF:</label>
					<input type="text" class="form-control <?php echo (!empty($cpf_err)) ? 'is-invalid' : ''; ?>" name="cpf" id="cpf" placeholder="CPF">
					<span class="invalid-feedback texto"><?php echo $cpf_err; ?></span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">Senha:</label>
					<input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" name="password" id="password" placeholder="Senha">
					<span class="invalid-feedback texto"><?php echo $password_err; ?></span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-6 indexInput">
					<label class="control-label col-md-2">Confirmar Senha:</label>
					<input type="password" class="form-control <?php echo (!empty($passwordConfirm_err)) ? 'is-invalid' : ''; ?>" name="passwordConfirm" id="passwordConfirm" placeholder="Confirmar Senha">
					<span class="invalid-feedback texto"><?php echo $passwordConfirm_err; ?></span>
				</div>
			</div><br/>
			<div class="text-center">
				<p class="texto" style="color: red"><?php echo $success; ?></p>
				<input type="submit" class="btn btn-primary" value="Cadastrar Usuário">
			</div>
			<div class="btnCad">
				<a href="./index.php" class="btn btn-secondary">Voltar</a>
			</div>
		</form>
		
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="./index.js"></script>
	</body>
</html>