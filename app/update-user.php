<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

	if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['full_name']) && isset($_POST['id']) && $_SESSION['role'] == 'admin') {
		include "../DB_connection.php";

		function validar_entrada($data)
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		$user_name = validar_entrada($_POST['user_name']);
		$password = validar_entrada($_POST['password']);
		$full_name = validar_entrada($_POST['full_name']);
		$id = validar_entrada($_POST['id']);

		if (empty($user_name)) {
			$em = "Nome de usuário é obrigatório";
			header("Location: ../edit-user.php?error=$em&id=$id");
			exit();
		} else if (empty($password)) {
			$em = "Senha é obrigatória";
			header("Location: ../edit-user.php?error=$em&id=$id");
			exit();
		} else if (empty($full_name)) {
			$em = "Nome completo é obrigatório";
			header("Location: ../edit-user.php?error=$em&id=$id");
			exit();
		} else {
			include "Model/User.php";

			$password_hash = password_hash($password, PASSWORD_DEFAULT);


			$role = "employee";
			$dados = array($full_name, $user_name, $password_hash, $role, $id);

			update_user($conn, $dados);

			$em = "Usuário atualizado com sucesso";
			header("Location: ../edit-user.php?success=$em&id=$id");
			exit();
		}
	} else {
		$em = "Ocorreu um erro desconhecido";
		header("Location: ../edit-user.php?error=$em");
		exit();
	}
} else {
	$em = "Faça login primeiro";
	header("Location: ../edit-user.php?error=$em");
	exit();
}
