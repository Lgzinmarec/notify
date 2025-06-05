<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    if (
        isset($_POST['confirm_password']) && 
        isset($_POST['new_password']) && 
        isset($_POST['password']) && 
        isset($_POST['full_name']) && 
        $_SESSION['role'] === 'employee'
    ) {
        include "../DB_connection.php";

        function validar_entrada($dados) {
            $dados = trim($dados);
            $dados = stripslashes($dados);
            $dados = htmlspecialchars($dados);
            return $dados;
        }

        $senha_atual = validar_entrada($_POST['password']);
        $nome_completo = validar_entrada($_POST['full_name']);
        $nova_senha = validar_entrada($_POST['new_password']);
        $confirma_senha = validar_entrada($_POST['confirm_password']);
        $id = $_SESSION['id'];

        if (empty($senha_atual) || empty($nova_senha) || empty($confirma_senha)) {
            $erro = "Os campos de senha são obrigatórios";
            header("Location: ../edit_profile.php?error=$erro");
            exit();
        } elseif (empty($nome_completo)) {
            $erro = "O nome completo é obrigatório";
            header("Location: ../edit_profile.php?error=$erro");
            exit();
        } elseif ($nova_senha !== $confirma_senha) {
            $erro = "A nova senha e a confirmação não conferem";
            header("Location: ../edit_profile.php?error=$erro");
            exit();
        } else {
            include "Model/User.php";

            $usuario = get_user_by_id($conn, $id);
            if ($usuario) {
                if (password_verify($senha_atual, $usuario['password'])) {
                    $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
                    $dados = array($nome_completo, $senha_hash, $id);
                    update_profile($conn, $dados);

                    $sucesso = "Perfil atualizado com sucesso";
                    header("Location: ../edit_profile.php?success=$sucesso");
                    exit();
                } else {
                    $erro = "Senha atual incorreta";
                    header("Location: ../edit_profile.php?error=$erro");
                    exit();
                }
            } else {
                $erro = "Usuário não encontrado";
                header("Location: ../edit_profile.php?error=$erro");
                exit();
            }
        }
    } else {
        $erro = "Todos os campos são obrigatórios";
        header("Location: ../edit_profile.php?error=$erro");
        exit();
    }

} else {
    $erro = "Por favor, faça login primeiro";
    header("Location: ../login.php?error=$erro");
    exit();
}
