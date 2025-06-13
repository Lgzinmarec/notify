<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] === 'user') {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        include "../DB_connection.php";
        include "Model/Task.php";

        $id = (int) $_POST['id'];
        $status = $_POST['status'];
        $userId = $_SESSION['id'];


        $task = get_task_by_id($conn, $id);
        if (!$task || $task['assigned_to'] != $userId) {
            $erro = "Você não tem permissão para alterar esta tarefa.";
            header("Location: ../edit-task-user.php?id=$id&error=$erro");
            exit();
        }


        $sql = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$status, $id]);

        $sucesso = "Status atualizado com sucesso.";
        header("Location: ../edit-task-user.php?id=$id&success=$sucesso");
        exit();
    } else {
        $erro = "Dados incompletos.";
        header("Location: ../edit-task-user.php?id=" . $_POST['id'] . "&error=$erro");
        exit();
    }
} else {
    $erro = "Acesso negado.";
    header("Location: ../login.php?error=$erro");
    exit();
}
