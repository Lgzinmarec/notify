<?php
require_once __DIR__ . "/../init.php";
require_once __DIR__ . "/../Model/Task.php";


function calculator_controller() {
    global $conn;

    $user_id = $_SESSION['id'] ?? null;
    if (!$user_id) {
        return [
            'completed' => [],
            'incomplete' => [],
            'total_pontos' => 0,
            'media' => 0,
            'qtd' => 0,
            'perdidos' => 0,
        ];
    }

    $inicio = $_GET['inicio'] ?? null;
    $fim = $_GET['fim'] ?? null;

    
    if ($inicio && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $inicio)) $inicio = null;
    if ($fim && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fim)) $fim = null;

    if ($inicio && $fim) {
        $completed = get_completed_tasks_by_user_in_date_range($conn, $user_id, $inicio, $fim);
        $incomplete = get_incomplete_tasks_by_user_in_date_range($conn, $user_id, $inicio, $fim);
    } else {
        $completed = get_completed_tasks_by_user($conn, $user_id);
        $incomplete = get_incomplete_tasks_by_user($conn, $user_id);
    }

    $completed = is_array($completed) ? $completed : [];
    $incomplete = is_array($incomplete) ? $incomplete : [];

    $total_pontos = array_sum(array_column($completed, 'points'));
    $qtd = count($completed);
    $media = $qtd > 0 ? round($total_pontos / $qtd, 2) : 0;

    $perdidos = array_sum(array_column($incomplete, 'points'));

    return [
        'completed' => $completed,
        'incomplete' => $incomplete,
        'total_pontos' => $total_pontos,
        'media' => $media,
        'qtd' => $qtd,
        'perdidos' => $perdidos,
        'inicio' => $inicio,
        'fim' => $fim,
    ];
}
