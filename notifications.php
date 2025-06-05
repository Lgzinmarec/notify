<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
	include "DB_connection.php";
	include "app/Model/Notification.php";

	$notifications = get_all_my_notifications($conn, $_SESSION['id']);
?>
	<!DOCTYPE html>
	<html>

	<head>
		<title>Notificações</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="css/style.css">
	</head>

	<body>
		<input type="checkbox" id="checkbox">
		<?php include "inc/header.php" ?>
		<div class="body">
			<?php include "inc/nav.php" ?>
			<section class="section-1">
				<h4 class="title">Todas as Notificações</h4>

				<?php if (isset($_GET['success'])) { ?>
					<div class="success" role="alert">
						<?php echo stripcslashes($_GET['success']); ?>
					</div>
				<?php } ?>

				<?php if ($notifications != 0) { ?>
					<table class="main-table">
						<tr>
							<th>#</th>
							<th>Mensagem</th>
							<th>Tipo</th>
							<th>Data</th>
						</tr>
						<?php $i = 0;
						foreach ($notifications as $notification) { ?>
							<tr>
								<td><?= ++$i ?></td>
								<td><?= $notification['message'] ?></td>
								<td><?= $notification['type'] ?></td>
								<td><?= $notification['date'] ?></td>
							</tr>
						<?php } ?>
					</table>
				<?php } else { ?>
					<h3>Você não tem nenhuma notificação</h3>
				<?php } ?>
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