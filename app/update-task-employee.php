<?php
session_start();

if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] === 'employee') {
    if (isset($_POST['id']) && isset($_POST['status'])) {
        include "../DB_connection.php";
        include "Model/Task.php";

        $id = (int) $_POST['id'];
        $status = $_POST['status'];
        $employeeId = $_SESSION['id'];

        // Verifica se a tarefa pertence ao funcionário logado
        $task = get_task_by_id($conn, $id);
        if (!$task || $task['assigned_to'] != $employeeId) {
            $erro = "Você não tem permissão para alterar esta tarefa.";
            header("Location: ../edit-task-employee.php?id=$id&error=$erro");
            exit();
        }

        // Atualiza apenas o status
        $sql = "UPDATE tasks SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$status, $id]);

        $sucesso = "Status atualizado com sucesso.";
        header("Location: ../edit-task-employee.php?id=$id&success=$sucesso");
        exit();
    } else {
        $erro = "Dados incompletos.";
        header("Location: ../edit-task-employee.php?id=".$_POST['id']."&error=$erro");
        exit();
    }
} else {
    $erro = "Acesso negado.";
    header("Location: ../login.php?error=$erro");
    exit();
}
