<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/User.php";

function edit_profile_controller() {
    global $conn;

$erro = "";
$sucesso = "";
$user = get_user_by_id($conn, $_SESSION['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'] ?? '';
    $senha_atual = $_POST['password'] ?? '';
    $nova_senha = $_POST['new_password'] ?? '';
    $confirmar = $_POST['confirm_password'] ?? '';

    if ($nova_senha !== $confirmar) {
        $erro = "As senhas não coincidem.";
    } elseif (!password_verify($senha_atual, $user['password'])) {
        $erro = "Senha atual incorreta.";
    } else {
        $nova_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        update_profile($conn, [$full_name, $nova_hash, $_SESSION['id']]);
        $sucesso = "Perfil atualizado com sucesso!";
    }
}

return [
    'user' => $user,
    'erro' => $erro,
    'sucesso' => $sucesso
];
}