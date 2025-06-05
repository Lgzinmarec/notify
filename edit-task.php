<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
	include "DB_connection.php";
	include "app/Model/Task.php";
	include "app/Model/User.php";

	if (!isset($_GET['id'])) {
		header("Location: tasks.php");
		exit();
	}

	$id = $_GET['id'];
	$task = get_task_by_id($conn, $id);

	if ($task == 0) {
		header("Location: tasks.php");
		exit();
	}

	$users = get_all_users($conn);

	// Pega o usuário atribuído nessa tarefa
	$assignedUserId = $task['assigned_to'];

	// Total de pontos concluídos pelo usuário atribuído
	$total_pontos_usuario = get_total_points_completed_by_user($conn, $assignedUserId);

	// Lista das tarefas atribuídas ao usuário
	$tasks_assigned = get_tasks_assigned_to_user($conn, $assignedUserId);
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
		<?php include "inc/header.php" ?>
		<div class="body">
			<?php include "inc/nav.php" ?>
			<section class="section-1">
				<h4 class="title">Editar Tarefa <a href="tasks.php">Voltar</a></h4>

				<!-- Exibe total de pontos do usuário -->
				<p><strong>Total de pontos concluídos pelo usuário atribuído:</strong> <?= $total_pontos_usuario ?></p>

				<!-- Exibe tabela com tarefas atribuídas -->
				<?php if ($tasks_assigned != 0) { ?>
					<table class="main-table" style="margin-bottom: 20px;">
						<thead>
							<tr>
								<th>#</th>
								<th>Título</th>
								<th>Pontos</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							<?php $count = 1;
							foreach ($tasks_assigned as $t) { ?>
								<tr>
									<td><?= $count++ ?></td>
									<td><?= htmlspecialchars($t['title']) ?></td>
									<td><?= $t['points'] ?? 0 ?></td>
									<td><?= ucfirst($t['status']) ?></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				<?php } else { ?>
					<p>Esse usuário não tem tarefas atribuídas.</p>
				<?php } ?>

				<form class="form-1" method="POST" action="app/update-task.php">
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
						<label>Título</label>
						<input type="text" name="title" class="input-1" placeholder="Título" value="<?= $task['title'] ?>"><br>
					</div>

					<div class="input-holder">
						<label>Descrição</label>
						<textarea name="description" rows="5" class="input-1"><?= $task['description'] ?></textarea><br>
					</div>

					<div class="input-holder">
						<label>Data de Entrega</label>
						<input type="date" name="due_date" class="input-1" value="<?= $task['due_date'] ?>"><br>
					</div>

					<div class="input-holder">
						<label>Atribuir para</label>
						<select name="assigned_to" class="input-1">
							<option value="0">Selecione o Aluno</option>
							<?php
							if ($users != 0) {
								foreach ($users as $user) {
									if ($task['assigned_to'] == $user['id']) { ?>
										<option selected value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
									<?php } else { ?>
										<option value="<?= $user['id'] ?>"><?= $user['full_name'] ?></option>
							<?php }
								}
							}
							?>
						</select><br>
					</div>
					<div class="input-holder">
						<label>Pontos</label>
						<input type="number" name="points" class="input-1" placeholder="Pontos da tarefa" value="<?= $task['points'] ?? 0 ?>" min="0"><br>
					</div>

					<input type="hidden" name="id" value="<?= $task['id'] ?>">

					<button class="edit-btn">Atualizar</button>
				</form>
			</section>
		</div>

		<script type="text/javascript">
			var active = document.querySelector("#navList li:nth-child(4)");
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