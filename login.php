<?php
session_start();
require_once "app/Controller/LoginController.php";
$data = login_controller();
$error = $data['error'];
$success = $data['success'];
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
</head>

<body>
	<div class="container login-box">
		<h2 class="text-center mb-4">Entrar</h2>

		<?php if ($error): ?>
			<div class="alert alert-danger"><?= $error ?></div>
		<?php endif; ?>

		<?php if ($success): ?>
			<div class="alert alert-success"><?= $success ?></div>
		<?php endif; ?>

		<form method="POST">
			<div class="mb-3">
				<label for="exampleInputEmail1" class="form-label">Nome Usuário</label>
				<input type="text" class="form-control" name="user_name">

				<div class="mb-3">
					<label for="exampleInputPassword1" class="form-label">Senha</label>
					<input type="password" class="form-control" name="password" id="exampleInputPassword1">
				</div>

				<button type="submit" class="btn btn-primary">Entrar</button>
		</form>

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>

</html>