<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    include "DB_connection.php";
    require_once "app/Controller/MyTasksController.php";
require_once 'app/Model/Task.php'; 


    
    $data   = my_tasks_controller();   
    $tasks  = $data['tasks'];

    
    $total_pontos = sum_completed_points_by_user($conn, $_SESSION['id']);
    $media_pontos = average_points_by_user($conn, $_SESSION['id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Minhas Tarefas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<input type="checkbox" id="checkbox">
<?php include "inc/header.php" ?>
<div class="body">
    <?php include "inc/nav.php" ?>

    <section class="section-1">
        <h4 class="title">Minhas Tarefas</h4>

        <?php if (isset($_GET['success'])): ?>
            <div class="success" role="alert">
                <?= stripcslashes($_GET['success']); ?>
            </div>
        <?php endif; ?>

        <?php if ($tasks != 0): ?>
            <table class="main-table">
                <tr>
                    <th>#</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Status</th>
                    <th>Pontos</th>
                    <th>Data de Entrega</th>
                    <th>Ação</th>
                </tr>
                <?php $i = 0; foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= ++$i ?></td>
                        <td><?= $task['title'] ?></td>
                        <td><?= $task['description'] ?></td>
                        <td><?= $task['status'] ?></td>
                        <td><?= $task['points'] ?? 0 ?></td>
                        <td><?= $task['due_date'] == "" ? "Sem prazo" : $task['due_date'] ?></td>
                        <td>
                            <a href="edit-task-user.php?id=<?= $task['id'] ?>" class="edit-btn">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>

          
            <p style="margin-top:15px;">
                <strong>Total de pontos concluídos:</strong> <?= $total_pontos ?> |
                <strong>Média por tarefa concluída:</strong> <?= $media_pontos ?>
            </p>

        <?php else: ?>
            <h3>Sem tarefas atribuídas</h3>
        <?php endif; ?>
    </section>
</div>

<script type="text/javascript">
    document.querySelector("#navList li:nth-child(2)").classList.add("active");
</script>
</body>
</html>
<?php
} else {
    header("Location: login.php?error=Faça+login+primeiro");
    exit();
}
?>
