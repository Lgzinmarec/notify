<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/Task.php";

function edit_task_user_controller() {
    global $conn;

    $id = $_GET['id'] ?? null;
    $mensagem = "";
    $erro = "";

    if (!$id) {
        header("Location: my_task.php");
        exit();
    }

    $task = get_task_by_id($conn, $id);
    if (!$task || $task['assigned_to'] != $_SESSION['id']) {
        header("Location: my_task.php");
        exit();
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $status = $_POST['status'] ?? 'pending';
        update_task_status($conn, [$status, $id]);
        $mensagem = "Status atualizado com sucesso!";
    }

    return [
        'task' => $task,
        'mensagem' => $mensagem,
        'erro' => $erro
    ];
}
