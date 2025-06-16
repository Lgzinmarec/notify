<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/Task.php";
require_once __DIR__ . "/../Model/User.php";

function create_task_controller() {
    global $conn;


$users = get_all_users($conn);
$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $titulo = $_POST['title'] ?? '';
    $descricao = $_POST['description'] ?? '';
    $prazo = $_POST['due_date'] ?? null;
    $pontos = $_POST['points'] ?? 0;
    $atribuir_para = ($_SESSION['role'] ?? '') === 'admin' ? ($_POST['assigned_to'] ?? null) : ($_SESSION['id'] ?? null);

    if ($titulo && $descricao && $atribuir_para) {
        insert_task($conn, [$titulo, $descricao, $atribuir_para, $prazo, $pontos]);
        $mensagem = "Tarefa criada com sucesso!";
    } else {
        $mensagem = "Preencha os campos obrigatórios.";
    }
}

return [
    "users" => $users,
    "mensagem" => $mensagem
];
}