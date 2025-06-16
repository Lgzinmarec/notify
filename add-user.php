<?php
session_start();
if (isset($_SESSION['role']) && $_SESSION['role'] === "admin" && isset($_SESSION['id'])) {

	require_once "app/Controller/AddUserController.php";
	$data = add_user_controller();
	$erro = $data['erro'] ?? "";
	$sucesso = $data['sucesso'] ?? "";

?>

<!DOCTYPE html>
<html>
<head>
	<title>Adicionar Usuário</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<input type="checkbox" id="checkbox">
	<?php include "inc/header.php" ?>
	<div class="body">
		<?php include "inc/nav.php" ?>
		<section class="section-1">
			<h4 class="title">Adicionar Usuário <a href="user.php">Usuários</a></h4>

			<?php if ($erro): ?>
				<div class="danger" role="alert"><?= htmlspecialchars($erro) ?></div>
			<?php endif; ?>

			<?php if ($sucesso): ?>
				<div class="success" role="alert"><?= htmlspecialchars($sucesso) ?></div>
			<?php endif; ?>

			<form class="form-1" method="POST" action="">
				<div class="input-holder">
					<label>Nome Completo</label>
					<input type="text" name="full_name" class="input-1" placeholder="Nome Completo" required><br>
				</div>
				<div class="input-holder">
					<label>Nome de Usuário</label>
					<input type="text" name="user_name" class="input-1" placeholder="Nome de Usuário" required><br>
				</div>
				<div class="input-holder">
					<label>Senha</label>
					<input type="password" name="password" class="input-1" placeholder="Senha" required><br>
				</div>

				<button class="edit-btn">Adicionar</button>
			</form>
		</section>
	</div>

	<script type="text/javascript">
		var active = document.querySelector("#navList li:nth-child(2)");
		if (active) active.classList.add("active");
	</script>
</body>
</html>

<?php
} else {
	$em = "Faça login primeiro";
	header("Location: login.php?error=" . urlencode($em));
	exit();
}
?>
