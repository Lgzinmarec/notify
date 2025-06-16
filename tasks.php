<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {

    include "DB_connection.php";
    require_once "app/Controller/TasksController.php";
    include "app/Model/User.php";        

    
    $data      = tasks_controller();
    $tasks     = $data['tasks'];
    $texto     = $data['texto'];
    $num_task  = $data['num_task'];

   
    $users = get_all_users($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Todas as Tarefas</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<input type="checkbox" id="checkbox">
<?php include "inc/header.php" ?>
<div class="body">
    <?php include "inc/nav.php" ?>

    <section class="section-1">
        <h4 class="title-2">
            <a href="create_task.php" class="btn">Criar Tarefa</a>
            <a href="tasks.php?due_date=Due Today">Vencem Hoje</a>
            <a href="tasks.php?due_date=Overdue">Atrasadas</a>
            <a href="tasks.php?due_date=No Deadline">Sem Prazo</a>
            <a href="tasks.php">Todas as Tarefas</a>
        </h4>

        <h4 class="title-2"><?= $texto ?> (<?= $num_task ?>)</h4>

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
                    <th>Atribuída a</th>
                    <th>Data de Entrega</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
                <?php $i = 0; foreach ($tasks as $task): ?>
                    <tr>
                        <td><?= ++$i ?></td>
                        <td><?= $task['title'] ?></td>
                        <td><?= $task['description'] ?></td>
                        <td>
                            <?php
                            foreach ($users as $user) {
                                if ($user['id'] == $task['assigned_to']) {
                                    echo $user['full_name'];
                                    break;
                                }
                            }
                            ?>
                        </td>
                        <td><?= $task['due_date'] == "" ? "Sem Prazo" : $task['due_date'] ?></td>
                        <td><?= $task['status'] ?></td>
                        <td>
                            <a href="edit-task.php?id=<?= $task['id'] ?>" class="edit-btn">Editar</a>
                            <a href="delete-task.php?id=<?= $task['id'] ?>" class="delete-btn">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <h3>Sem tarefas</h3>
        <?php endif; ?>
    </section>
</div>

<script type="text/javascript">
    document.querySelector("#navList li:nth-child(4)").classList.add("active");
</script>
</body>
</html>
<?php
} else {
    header("Location: login.php?error=Faça+login+primeiro");
    exit();
}
?>
