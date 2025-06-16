<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && in_array($_SESSION['role'], ["admin", "user"])) {

	include "DB_connection.php";
	require_once "app/Controller/CreateTaskController.php";

	$data = create_task_controller();
	$users = $data['users'];
	$mensagem = $data['mensagem'];
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Criar Tarefa</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<input type="checkbox" id="checkbox">
		<?php include "inc/header.php" ?>
		<div class="body">
			<?php include "inc/nav.php" ?>

			<section class="section-1">
				<h4 class="title">Criar Tarefa</h4>

				
				<?php if ($mensagem): ?>
					<div class="success" role="alert">
						<?= $mensagem ?>
					</div>
				<?php endif; ?>

				<form class="form-1" method="POST">
					<div class="input-holder">
						<label>Título</label>
						<input type="text" name="title" class="input-1" placeholder="Título"><br>
					</div>

					<div class="input-holder">
						<label>Descrição</label>
						<textarea name="description" class="input-1" placeholder="Descrição"></textarea><br>
					</div>

					<div class="input-holder">
						<label>Prazo</label>
						<input type="date" name="due_date" class="input-1" placeholder="Prazo"><br>
					</div>

					<div class="input-holder">
						<label>Atribuir para</label>
						<?php if ($_SESSION['role'] == 'admin') { ?>
							<select name="assigned_to" class="input-1">
								<option value="0">Selecionar Aluno</option>
								<?php if ($users != 0): ?>
									<?php foreach ($users as $user): ?>
										<option value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
									<?php endforeach; ?>
								<?php endif; ?>
							</select>
						<?php } else { ?>
							<input type="hidden" name="assigned_to" value="<?= $_SESSION['id'] ?>">
							<p style="color:#333; font-weight:bold;">Você está criando esta tarefa para si mesmo.</p>
						<?php } ?>
					</div>

					<div class="input-holder">
						<label>Valor em Pontos</label>
						<input type="number" name="points" class="input-1" placeholder="Ex: 50" min="0" value="0"><br>
					</div>

					<button class="edit-btn">Criar Tarefa</button>
				</form>
			</section>
		</div>

		<script type="text/javascript">
			var active = document.querySelector("#navList li:nth-child(3)");
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
