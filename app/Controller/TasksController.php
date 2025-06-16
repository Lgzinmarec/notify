<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/Task.php";

function tasks_controller() {
    global $conn;

    $texto = "Todas as Tarefas";

    if (isset($_GET['due_date'])) {
        switch ($_GET['due_date']) {
            case "Due Today":
                $texto = "Vencem Hoje";
                $tasks = get_all_tasks_due_today($conn);
                break;
            case "Overdue":
                $texto = "Atrasadas";
                $tasks = get_all_tasks_overdue($conn);
                break;
            case "No Deadline":
                $texto = "Sem Prazo";
                $tasks = get_all_tasks_NoDeadline($conn);
                break;
            default:
                $tasks = get_all_tasks($conn);
        }
    } else {
        $tasks = get_all_tasks($conn);
    }

    $num_task = is_array($tasks) ? count($tasks) : 0;

    return [
        'tasks' => $tasks,
        'texto' => $texto,
        'num_task' => $num_task
    ];
}
