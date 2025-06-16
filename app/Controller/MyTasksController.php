<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/Task.php";

function my_tasks_controller() {
    global $conn;

    $user_id = $_SESSION['id'] ?? null;
    if (!$user_id) {
        
        return ['tasks' => []];
    }

    $tasks = get_all_tasks_by_id($conn, $user_id);

    return [
        'tasks' => $tasks
    ];
}
