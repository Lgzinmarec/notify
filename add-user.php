<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
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
			
			<form class="form-1" method="POST" action="app/add-user.php">
				<?php if (isset($_GET['error'])) { ?>
					<div class="danger" role="alert">
						<?php echo stripcslashes($_GET['error']); ?>
					</div>
				<?php } ?>

				<?php if (isset($_GET['success'])) { ?>
					<div class="success" role="alert">
						<?php echo stripcslashes($_GET['success']); ?>
					</div>
				<?php } ?>

				<div class="input-holder">
					<label>Nome Completo</label>
					<input type="text" name="full_name" class="input-1" placeholder="Nome Completo"><br>
				</div>
				<div class="input-holder">
					<label>Nome de Usuário</label>
					<input type="text" name="user_name" class="input-1" placeholder="Nome de Usuário"><br>
				</div>
				<div class="input-holder">
					<label>Senha</label>
					<input type="text" name="password" class="input-1" placeholder="Senha"><br>
				</div>

				<button class="edit-btn">Adicionar</button>
			</form>
		</section>
	</div>

	<script type="text/javascript">
		var active = document.querySelector("#navList li:nth-child(2)");
		active.classList.add("active");
	</script>
</body>
</html>
<?php 
} else { 
	$em = "Faça login primeiro";
	header("Location: login.php?error=$em");
	exit();
}
?>
