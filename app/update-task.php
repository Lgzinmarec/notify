<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

	if (isset($_POST['id'], $_POST['title'], $_POST['description'], $_POST['due_date'], $_POST['points'])) {
		include "../DB_connection.php";

		function validar_entrada($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$titulo = validar_entrada($_POST['title']);
		$descricao = validar_entrada($_POST['description']);
		$id = validar_entrada($_POST['id']);
		$data_entrega = validar_entrada($_POST['due_date']);
		$pontos = isset($_POST['points']) ? (int) $_POST['points'] : 0;


		if ($_SESSION['role'] == 'admin') {
			if (!isset($_POST['assigned_to']) || $_POST['assigned_to'] == 0) {
				$em = "Selecione um usuário";
				header("Location: ../edit-task.php?error=$em&id=$id");
				exit();
			}
			$atribuido_para = validar_entrada($_POST['assigned_to']);
		} else {
			$atribuido_para = $_SESSION['id'];
		}

		if (empty($titulo)) {
			$em = "O título é obrigatório";
			header("Location: ../edit-task.php?error=$em&id=$id");
			exit();
		} else if (empty($descricao)) {
			$em = "A descrição é obrigatória";
			header("Location: ../edit-task.php?error=$em&id=$id");
			exit();
		} else {
			require_once __DIR__ . "/Model/Task.php";




			$dados = array($titulo, $descricao, $atribuido_para, $data_entrega, $pontos, $id);
			update_task($conn, $dados);

			$em = "Tarefa atualizada com sucesso";
			header("Location: ../edit-task.php?success=$em&id=$id");
			exit();
		}
	} else {
		$em = "Ocorreu um erro desconhecido";
		header("Location: ../edit-task.php?error=$em");
		exit();
	}
} else {
	$em = "Faça login primeiro";
	header("Location: ../login.php?error=$em");
	exit();
}
