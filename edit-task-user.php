<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] === "user") {

	include "DB_connection.php";
	require_once "app/Controller/EditTaskUserController.php";

	$data = edit_task_user_controller();
	$task = $data['task'];
	$mensagem = $data['mensagem'];
	$erro = $data['erro'];
?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Editar Tarefa</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<input type="checkbox" id="checkbox">
		<?php include "inc/header.php"; ?>
		<div class="body">
			<?php include "inc/nav.php"; ?>

			<section class="section-1">
				<h4 class="title">Editar Tarefa <a href="my_task.php">Tarefas</a></h4>

				<?php if ($erro): ?>
					<div class="danger" role="alert"><?= htmlspecialchars($erro) ?></div>
				<?php endif; ?>

				<?php if ($mensagem): ?>
					<div class="success" role="alert"><?= htmlspecialchars($mensagem) ?></div>
				<?php endif; ?>

				<form class="form-1" method="POST" action="">
					<div class="input-holder">
						<label></label>
						<p><b>Título: </b><?= htmlspecialchars($task['title']) ?></p>
					</div>
					<div class="input-holder">
						<label></label>
						<p><b>Descrição: </b><?= nl2br(htmlspecialchars($task['description'])) ?></p>
					</div><br>
					<div class="input-holder">
						<label>Status</label>
						<select name="status" class="input-1">
							<option value="pending" <?= $task['status'] === "pending" ? "selected" : "" ?>>Pendente</option>
							<option value="in_progress" <?= $task['status'] === "in_progress" ? "selected" : "" ?>>Em andamento</option>
							<option value="completed" <?= $task['status'] === "completed" ? "selected" : "" ?>>Concluída</option>
						</select><br>
					</div>
					<input type="hidden" name="id" value="<?= (int)$task['id'] ?>">
					<button class="edit-btn">Atualizar</button>
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
