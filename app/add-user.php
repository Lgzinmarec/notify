<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    if (isset($_POST['user_name']) && isset($_POST['password']) && isset($_POST['full_name']) && $_SESSION['role'] == 'admin') {
        include "../DB_connection.php";

        function validar_entrada($dado) {
            $dado = trim($dado);
            $dado = stripslashes($dado);
            $dado = htmlspecialchars($dado);
            return $dado;
        }

        $usuario = validar_entrada($_POST['user_name']);
        $senha = validar_entrada($_POST['password']);
        $nome_completo = validar_entrada($_POST['full_name']);

        if (empty($usuario)) {
            $erro = "Nome de usuário é obrigatório";
            header("Location: ../add-user.php?error=$erro");
            exit();
        } else if (empty($senha)) {
            $erro = "Senha é obrigatória";
            header("Location: ../add-user.php?error=$erro");
            exit();
        } else if (empty($nome_completo)) {
            $erro = "Nome completo é obrigatório";
            header("Location: ../add-user.php?error=$erro");
            exit();
        } else {
            include "Model/User.php";
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

            $dados_usuario = array($nome_completo, $usuario, $senha_hash, "user");
            insert_user($conn, $dados_usuario);

            $sucesso = "Usuário criado com sucesso";
            header("Location: ../add-user.php?success=$sucesso");
            exit();
        }

    } else {
        $erro = "Ocorreu um erro desconhecido";
        header("Location: ../add-user.php?error=$erro");
        exit();
    }

} else { 
    $erro = "Faça login primeiro";
    header("Location: ../add-user.php?error=$erro");
    exit();
}
