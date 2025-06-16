<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/Task.php";
require_once __DIR__ . "/../Model/User.php";

function add_user_controller() {
    global $conn;

    $erro = "";
    $sucesso = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $full_name = $_POST['full_name'] ?? '';
        $username = $_POST['user_name'] ?? '';
        $password = $_POST['password'] ?? '';
        $role = 'user';  

        if ($full_name && $username && $password) {
           
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                insert_user($conn, [$full_name, $username, $hashed_password, $role]);
                $sucesso = "Usuário criado com sucesso!";
            } catch (PDOException $e) {
                $erro = "Erro ao criar usuário: " . $e->getMessage();
            }
        } else {
            $erro = "Preencha todos os campos obrigatórios.";
        }
    }

    return [
        "erro" => $erro,
        "sucesso" => $sucesso
    ];
}
